<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Business;
use App\Models\Service;
use App\Models\BusinessSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production') && !$this->command?->option('force')) {
            $this->command?->error('Seeders cannot run in production!');
            return;
        }

        // إنشاء نشاط تجاري افتراضي (صالون تجميل)
        $business = Business::create([
            'name_ar' => 'رونق النجوم',
            'name_en' => 'RAWNAQ AL NUJOOM',
            'phone' => '12345678',
            'email' => 'info@rawnaqalnujoom.com',
            'city' => 'Kuwait City',
            'subscription_plan' => 'trial',
        ]);

        // إنشاء مستخدم أدمن (مدير النظام)
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123123'),
            'role' => 'admin',
            'phone' => '99999999',
            'business_id' => $business->id,
        ]);

        // إنشاء مستخدم مالك (owner) — صلاحيات مثل admin
        User::create([
            'name' => 'Atef',
            'email' => 'atef@atef.com',
            'password' => Hash::make('123123'),
            'role' => 'owner',
            'phone' => '12345678',
            'business_id' => $business->id,
        ]);

        // قائمة الخدمات الافتراضية التي يقدمها الصالون
        $services = [
            ['name_ar' => 'قص شعر', 'name_en' => 'Haircut', 'price' => 5.000, 'duration_minutes' => 30],
            ['name_ar' => 'تصفيف شعر', 'name_en' => 'Hair Styling', 'price' => 10.000, 'duration_minutes' => 45],
            ['name_ar' => 'صبغ شعر', 'name_en' => 'Hair Dye', 'price' => 15.000, 'duration_minutes' => 60],
            ['name_ar' => 'عناية بالبشرة', 'name_en' => 'Facial', 'price' => 8.000, 'duration_minutes' => 40],
            ['name_ar' => 'بديكير ومنيكير', 'name_en' => 'Manicure & Pedicure', 'price' => 12.000, 'duration_minutes' => 50],
        ];

        // إضافة كل خدمة إلى قاعدة البيانات
        foreach ($services as $svc) {
            Service::create([
                'business_id' => $business->id,
                'name_ar' => $svc['name_ar'],
                'name_en' => $svc['name_en'],
                'price' => $svc['price'],
                'duration_minutes' => $svc['duration_minutes'],
                'sort_order' => 0,
            ]);
        }

        // أيام العمل (من الأحد إلى الخميس)
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        foreach ($days as $i => $day) {
            // الفترة الصباحية (09:00 - 13:00)
            BusinessSchedule::create([
                'business_id' => $business->id,
                'day_of_week' => $i,
                'shift' => 'morning',
                'start_time' => '09:00',
                'end_time' => '13:00',
                'is_active' => true,
            ]);
            // الفترة المسائية (16:00 - 21:00)
            BusinessSchedule::create([
                'business_id' => $business->id,
                'day_of_week' => $i,
                'shift' => 'evening',
                'start_time' => '16:00',
                'end_time' => '21:00',
                'is_active' => true,
            ]);
        }
    }
}
