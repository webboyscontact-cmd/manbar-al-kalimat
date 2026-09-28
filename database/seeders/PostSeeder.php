<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first();
        $poetry = Category::where('name', 'الشعر')->first();
        $thoughts = Category::where('name', 'الخواطر')->first();
        $stories = Category::where('name', 'القصص القصيرة')->first();

        $demoPosts = [
            [
                'category_id' => $poetry?->id,
                'title' => 'في المساء',
                'content' => '<p>حين يميل الضوء نحو الغروب، تتهادى الكلمات كأنها تبحث عن سكينة النهار الأخيرة...</p><p>وتبقى الذاكرة تحتفظ بعطر اللحظة، كما تحتفظ الأرض بأثر المطر.</p>',
                'status' => 'published',
                'views' => 152,
                'published_at' => now()->subDays(3),
            ],
            [
                'category_id' => $thoughts?->id,
                'title' => 'خاطرة عابرة',
                'content' => '<p>أحياناً، لا نحتاج إلى كلمات كثيرة لنقول كل شيء. يكفي أن نصمت قليلاً لنفهم أكثر.</p>',
                'status' => 'published',
                'views' => 89,
                'published_at' => now()->subDay(),
            ],
            [
                'category_id' => $stories?->id,
                'title' => 'الباب الأخير',
                'content' => '<p>فتح الباب ببطء، وكأن كل خطوة كانت محسوبة بدقة الزمن...</p><p>لم يكن يعلم أن هذا الباب سيغيّر مجرى حياته إلى الأبد.</p>',
                'status' => 'draft',
                'views' => 0,
                'published_at' => null,
            ],
        ];

        foreach ($demoPosts as $data) {
            if (! $data['category_id']) {
                continue;
            }

            Post::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, ['admin_id' => $admin?->id])
            );
        }
    }
}
