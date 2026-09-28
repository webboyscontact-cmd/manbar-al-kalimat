<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'order'];

    protected static function booted(): void
    {
        static::creating(function (Category $category) {
            if (empty($category->slug)) {
                $category->slug = static::generateUniqueSlug($category->name);
            }
        });
    }

    public static function generateUniqueSlug(string $name): string
    {
        $base = static::arabicSlug($name);
        $slug = $base;
        $i = 1;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    /**
     * ينشئ slug يحافظ على الأحرف العربية بدلاً من تحويلها إلى لاتينية،
     * مع إزالة الرموز غير المسموح بها في الروابط واستبدال الفراغات بشرطات.
     */
    public static function arabicSlug(string $text): string
    {
        $text = trim($text);
        $text = preg_replace('/[\s]+/u', '-', $text);
        $text = preg_replace('/[^\p{Arabic}a-zA-Z0-9\-]/u', '', $text);
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return $text !== '' ? $text : Str::random(8);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts()
    {
        return $this->hasMany(Post::class)->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
