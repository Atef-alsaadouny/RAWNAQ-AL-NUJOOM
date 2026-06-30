<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Service;
use App\Models\Package;
use Illuminate\Database\Seeder;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $business = Business::first();
        if (!$business) {
            $this->command->warn('ما فيه business — شغّل DatabaseSeeder أولاً.');
            return;
        }

        $existingNames = Service::where('business_id', $business->id)->pluck('name_ar')->toArray();

        $extraServices = [
            ['name_ar' => 'حمام مغربي', 'name_en' => 'Moroccan Bath', 'price' => 18.000, 'duration_minutes' => 90, 'category' => 'عناية'],
            ['name_ar' => 'ماسك شعر', 'name_en' => 'Hair Mask', 'price' => 7.000, 'duration_minutes' => 30, 'category' => 'شعر'],
            ['name_ar' => 'سشوار', 'name_en' => 'Blow-Dry', 'price' => 4.000, 'duration_minutes' => 20, 'category' => 'شعر'],
            ['name_ar' => 'تنظيف بشرة', 'name_en' => 'Deep Facial Clean', 'price' => 10.000, 'duration_minutes' => 45, 'category' => 'بشرة'],
            ['name_ar' => 'مكياج سهرة', 'name_en' => 'Night Makeup', 'price' => 20.000, 'duration_minutes' => 60, 'category' => 'مكياج'],
            ['name_ar' => 'مكياج عرايس', 'name_en' => 'Bridal Makeup', 'price' => 50.000, 'duration_minutes' => 120, 'category' => 'مكياج'],
            ['name_ar' => 'بدكير', 'name_en' => 'Manicure', 'price' => 6.000, 'duration_minutes' => 30, 'category' => 'أظافر'],
            ['name_ar' => 'منيكير', 'name_en' => 'Pedicure', 'price' => 8.000, 'duration_minutes' => 40, 'category' => 'أظافر'],
            ['name_ar' => 'أكريليك أظافر', 'name_en' => 'Acrylic Nails', 'price' => 15.000, 'duration_minutes' => 60, 'category' => 'أظافر'],
            ['name_ar' => 'مساج استرخائي', 'name_en' => 'Relaxing Massage', 'price' => 12.000, 'duration_minutes' => 50, 'category' => 'مساج'],
            ['name_ar' => 'مساج سويدي', 'name_en' => 'Swedish Massage', 'price' => 15.000, 'duration_minutes' => 60, 'category' => 'مساج'],
            ['name_ar' => 'إزالة شعر بالواكس', 'name_en' => 'Waxing', 'price' => 5.000, 'duration_minutes' => 25, 'category' => 'عناية'],
            ['name_ar' => 'حواجب', 'name_en' => 'Eyebrows', 'price' => 3.000, 'duration_minutes' => 15, 'category' => 'عناية'],
            ['name_ar' => 'رموش', 'name_en' => 'Eyelashes', 'price' => 10.000, 'duration_minutes' => 40, 'category' => 'عناية'],
            ['name_ar' => 'تجعيد شعر', 'name_en' => 'Hair Curling', 'price' => 8.000, 'duration_minutes' => 35, 'category' => 'شعر'],
        ];

        $sort = Service::where('business_id', $business->id)->max('sort_order') + 1;
        $newServiceIds = [];
        foreach ($extraServices as $svc) {
            if (in_array($svc['name_ar'], $existingNames)) continue;
            $service = Service::create([
                'business_id' => $business->id,
                'name_ar' => $svc['name_ar'],
                'name_en' => $svc['name_en'],
                'price' => $svc['price'],
                'duration_minutes' => $svc['duration_minutes'],
                'category' => $svc['category'],
                'sort_order' => $sort++,
            ]);
            $newServiceIds[] = $service->id;
        }

        $allServiceIds = Service::where('business_id', $business->id)->pluck('id');

        $packages = [
            [
                'name_ar' => 'باقة التميز',
                'name_en' => 'Excellence Package',
                'price' => 25.000,
                'original_price' => 38.000,
                'description_ar' => 'قص شعر + تصفيف + ماسك شعر',
                'services' => ['قص شعر', 'تصفيف شعر', 'ماسك شعر'],
            ],
            [
                'name_ar' => 'باقة العناية الكاملة',
                'name_en' => 'Full Care Package',
                'price' => 30.000,
                'original_price' => 45.000,
                'description_ar' => 'تنظيف بشرة + حمام مغربي + مساج',
                'services' => ['تنظيف بشرة', 'حمام مغربي', 'مساج استرخائي'],
            ],
            [
                'name_ar' => 'باقة الأظافر',
                'name_en' => 'Nail Package',
                'price' => 22.000,
                'original_price' => 35.000,
                'description_ar' => 'بديكير ومنيكير + أكريليك + ملمع',
                'services' => ['بديكير ومنيكير', 'بدكير', 'منيكير', 'أكريليك أظافر'],
            ],
            [
                'name_ar' => 'باقة التخرج',
                'name_en' => 'Graduation Package',
                'price' => 35.000,
                'original_price' => 50.000,
                'description_ar' => 'تسريحة + مكياج سهرة + بديكير ومنيكير',
                'services' => ['تصفيف شعر', 'مكياج سهرة', 'بديكير ومنيكير'],
            ],
            [
                'name_ar' => 'باقة العروس',
                'name_en' => 'Bridal Package',
                'price' => 80.000,
                'original_price' => 120.000,
                'description_ar' => 'مكياج عرايس + تسريحة + حمام مغربي + بديكير ومنيكير + ماسك شعر',
                'services' => ['مكياج عرايس', 'تصفيف شعر', 'حمام مغربي', 'بديكير ومنيكير', 'ماسك شعر'],
            ],
            [
                'name_ar' => 'باقة الاسترخاء',
                'name_en' => 'Relaxation Package',
                'price' => 20.000,
                'original_price' => 30.000,
                'description_ar' => 'مساج سويدي + حمام مغربي',
                'services' => ['مساج سويدي', 'حمام مغربي'],
            ],
            [
                'name_ar' => 'باقة الشعر',
                'name_en' => 'Hair Package',
                'price' => 18.000,
                'original_price' => 27.000,
                'description_ar' => 'قص شعر + صبغ + سشوار',
                'services' => ['قص شعر', 'صبغ شعر', 'سشوار'],
            ],
        ];

        $sortPkg = Package::where('business_id', $business->id)->max('sort_order') + 1;
        if (!$sortPkg) $sortPkg = 0;

        foreach ($packages as $pkgData) {
            $pkg = Package::create([
                'business_id' => $business->id,
                'name_ar' => $pkgData['name_ar'],
                'name_en' => $pkgData['name_en'],
                'description_ar' => $pkgData['description_ar'],
                'price' => $pkgData['price'],
                'original_price' => $pkgData['original_price'],
                'sort_order' => $sortPkg++,
            ]);

            $serviceIds = Service::where('business_id', $business->id)
                ->whereIn('name_ar', $pkgData['services'])
                ->pluck('id');
            $pkg->services()->sync($serviceIds);
        }

        $this->command->info('تمت إضافة الخدمات والباقات الجديدة ✅');
    }
}
