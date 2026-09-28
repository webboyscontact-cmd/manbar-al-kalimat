<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'الشعر', 'description' => 'قصائد ونصوص شعرية'],
            ['name' => 'الخواطر', 'description' => 'أفكار ومشاعر وتأملات'],
            ['name' => 'القصص القصيرة', 'description' => 'حكايات ونصوص سردية قصيرة'],
            ['name' => 'الروايات', 'description' => 'مقتطفات وفصول من روايات'],
            ['name' => 'النثر', 'description' => 'نصوص أدبية نثرية'],
            ['name' => 'اليوميات', 'description' => 'يوميات وتدوينات شخصية أدبية'],
            ['name' => 'الرسائل', 'description' => 'رسائل أدبية ونصوص متبادلة'],
            ['name' => 'ثقافة', 'description' => 'مقالات ثقافية وأدبية عامة'],
        ];

        foreach ($categories as $i => $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                [
                    'slug' => Category::arabicSlug($data['name']),
                    'description' => $data['description'],
                    'order' => $i,
                ]
            );
        }
    }
}
