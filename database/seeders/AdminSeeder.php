<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@manbar-alkalimat.com'],
            [
                'name' => 'مدير الموقع',
                'password' => Hash::make('ChangeMe123!'),
            ]
        );

        $this->command->info('تم إنشاء حساب المدير: admin@manbar-alkalimat.com / ChangeMe123!');
        $this->command->warn('يرجى تغيير كلمة المرور فوراً بعد أول تسجيل دخول.');
    }
}
