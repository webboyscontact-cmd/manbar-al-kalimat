<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    protected $fillable = [
        'category_id',
        'admin_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'status',
        'seo_title',
        'seo_description',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views' => 'integer',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
            if (empty($post->excerpt)) {
                $post->excerpt = static::makeExcerpt($post->content);
            }
        });

        static::updating(function (Post $post) {
            if ($post->isDirty('status') && $post->status === 'published' && ! $post->published_at) {
                $post->published_at = now();
            }
        });
    }

    public static function generateUniqueSlug(string $title): string
    {
        $base = Category::arabicSlug($title);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public static function makeExcerpt(string $content, int $length = 200): string
    {
        $plain = trim(strip_tags($content));

        return mb_strlen($plain) > $length
            ? mb_substr($plain, 0, $length).'...'
            : $plain;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeMostViewed(Builder $query): Builder
    {
        return $query->orderByDesc('views');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('excerpt', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%")
                ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$term}%"));
        });
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
