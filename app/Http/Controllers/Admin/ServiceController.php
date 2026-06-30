<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use AuthorizesBusiness;
    /**
     * عرض قائمة جميع الخدمات مرتبة حسب ترتيب العرض
     */
    public function index()
    {
        // جلب خدمات الشركة الحالية مرتبة حسب حقل sort_order
        $businessId = Auth::user()->business_id;
        $services = Service::where('business_id', $businessId)->orderBy('sort_order')->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * عرض نموذج إضافة خدمة جديدة
     */
    public function create()
    {
        return view('admin.services.create');
    }

    /**
     * حفظ خدمة جديدة في قاعدة البيانات
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات: الاسم بالعربية مطلوب، الاسم بالإنجليزية اختياري، السعر مطلوب وقيمته رقمية ولا تقل عن 0، المدة بالدقائق مطلوبة ولا تقل عن 5
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
            'sort_order' => 'nullable|integer',
        ]);

        // إنشاء الخدمة الجديدة مع ربطها بشركة المستخدم الحالي
        Service::create([
            'business_id' => Auth::user()->business_id,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'category' => $request->category,
            'description_ar' => $request->description_ar,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', __('Service created successfully.'));
    }

    public function show(Service $service)
    {
        $this->authorizeBusiness($service);
        return redirect()->route('admin.services.edit', $service);
    }

    /**
     * عرض نموذج تعديل خدمة موجودة
     */
    public function edit(Service $service)
    {
        // التحقق من أن الخدمة تابعة لنفس شركة المشرف
        $this->authorizeBusiness($service);
        return view('admin.services.edit', compact('service'));
    }

    /**
     * تحديث بيانات خدمة موجودة
     */
    public function update(Request $request, Service $service)
    {
        $this->authorizeBusiness($service);

        // التحقق من صحة البيانات بالإضافة إلى حقل is_active وحالة الخدمة
        $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:1000',
            'description_en' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:5',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $service->update($request->only([
            'name_ar', 'name_en', 'category', 'description_ar', 'description_en',
            'price', 'duration_minutes', 'is_active', 'sort_order',
        ]));

        return redirect()->route('admin.services.index')
            ->with('success', __('Service updated successfully.'));
    }

    /**
     * حذف خدمة من النظام
     */
    public function destroy(Service $service)
    {
        $this->authorizeBusiness($service);
        $service->delete();
        return redirect()->route('admin.services.index')
            ->with('success', __('Service deleted successfully.'));
    }

}
