<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\AuthorizesBusiness;
use App\Models\BusinessSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    use AuthorizesBusiness;
    /**
     * عرض جدول المواعيد الأسبوعي للشركة
     * يتم تجميع المواعيد حسب أيام الأسبوع
     */
    public function index()
    {
        // جلب جميع جداول المواعيد للشركة وتجميعها حسب اليوم
        $businessId = Auth::user()->business_id;
        $schedules = BusinessSchedule::where('business_id', $businessId)->get()->groupBy('day_of_week');
        return view('admin.schedule.index', compact('schedules'));
    }

    /**
     * حفظ أو تحديث جدول مواعيد ليوم وفترة معينة
     */
    public function store(Request $request)
    {
        $businessId = Auth::user()->business_id;

        // التحقق من صحة البيانات: اليوم (0-6 حيث 0=الأحد)، الفترة، وقت البداية والنهاية مع التأكد أن النهاية بعد البداية
        $request->validate([
            'day_of_week' => 'required|integer|between:0,6',
            'shift' => 'required|in:' . implode(',', [\App\Models\Appointment::SHIFT_MORNING, \App\Models\Appointment::SHIFT_EVENING]),
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // إنشاء أو تحديث الجدول لنفس اليوم والفترة لمنع التكرار
        BusinessSchedule::updateOrCreate(
            [
                'business_id' => $businessId,
                'day_of_week' => $request->day_of_week,
                'shift' => $request->shift,
            ],
            [
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'is_active' => $request->boolean('is_active', true),
            ]
        );

        return redirect()->route('admin.schedule')
            ->with('success', __('Work schedule updated successfully.'));
    }

    /**
     * حذف جدول مواعيد
     */
    public function destroy(BusinessSchedule $schedule)
    {
        $this->authorizeBusiness($schedule);
        $schedule->delete();
        return redirect()->route('admin.schedule')
            ->with('success', __('Schedule deleted successfully.'));
    }
}
