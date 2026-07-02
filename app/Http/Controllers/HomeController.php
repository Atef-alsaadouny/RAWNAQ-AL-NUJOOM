<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Service;
use App\Models\Package;
use App\Models\Appointment;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * عرض الصفحة الرئيسية للتطبيق
     */
    public function index()
    {
        $upcomingAppointment = null;
        if (auth()->check() && auth()->user()->isCustomer()) {
            $upcomingAppointment = Appointment::where('customer_id', auth()->id())
                ->whereIn('status', Appointment::ACTIVE_STATUSES)
                ->with(['services', 'packages'])
                ->orderBy('appointment_date')
                ->first();
        }

        return view('home', compact('upcomingAppointment'));
    }

    /**
     * عرض صفحة الخدمات
     */
    public function services()
    {
        $business = Business::where('is_active', true)->first();
        $services = $business
            ? Service::where('business_id', $business->id)->where('is_active', true)->orderBy('sort_order')->get()
            : collect();

        $packages = $business
            ? Package::where('business_id', $business->id)->where('is_active', true)->with('services')->orderBy('sort_order')->get()
            : collect();

        $categories = $services->groupBy('category')->sortKeys();

        return view('services', compact('services', 'packages', 'categories'));
    }

    /**
     * عرض صفحة عن المكان
     */
    public function about()
    {
        return view('about');
    }

    /**
     * عرض صفحة معرض الصور
     */
    public function gallery()
    {
        return view('gallery');
    }

    /**
     * عرض صفحة الأسئلة الشائعة
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * عرض صفحة اتصل بنا
     */
    public function contact()
    {
        return view('contact');
    }

    public function contactSend(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            Mail::to(config('app.contact_email', 'info@rawnaqalnujoom.com'))
                ->send(new ContactFormMail([
                    'name' => $data['name'],
                    'phone' => $data['phone'] ?? '',
                    'email' => $data['email'] ?? '',
                    'message' => $data['message'],
                    'subject' => 'رسالة جديدة من ' . config('app.name'),
                ]));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Contact form email failed', [
                'error' => $e->getMessage(),
                'name' => $data['name'],
                'phone' => $data['phone'] ?? '',
            ]);
        }

        return back()->with('success', __('Your message has been sent. We will contact you soon'));
    }

    /**
     * عرض صفحة تتبع الحجز
     */
    public function track()
    {
        return view('track');
    }

    public function trackResult(Appointment $appointment, Request $request)
    {
        $phone = $request->query('phone');
        if (!$phone || $phone !== $appointment->customer_phone) {
            return redirect()->route('track')->with('error', __('No booking with this information'));
        }

        $appointment->load(['services', 'employee', 'packages', 'payment']);
        return view('track-result', compact('appointment'));
    }

    public function trackLookup(Request $request)
    {
        Appointment::expirePast();

        $request->validate([
            'ticket_number' => 'required|string',
            'phone' => 'required|string',
        ]);

        $clean = $request->ticket_number
            ? str_replace(['TKT-', '-'], '', strtoupper($request->ticket_number))
            : null;

        $appointment = Appointment::with(['services', 'employee', 'employees', 'packages'])
            ->where('ticket_number', $clean)
            ->where('customer_phone', $request->phone)
            ->first();

        if (!$appointment) {
            return back()->with('error', __('No booking with this information'));
        }

        $params = [
            'appointment' => $appointment->id,
            'phone' => $appointment->customer_phone,
        ];
        if ($appointment->guest_token) {
            $params['token'] = $appointment->guest_token;
        }

        return redirect()->route('track.result', $params);
    }
}
