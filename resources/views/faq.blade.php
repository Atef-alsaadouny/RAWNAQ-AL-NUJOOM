@extends('layouts.public')

@section('title', __('site_name') . ' — ' . __('FAQ'))
@section('meta_description', __('Answers to frequently asked questions about booking, cancellation, payment, and services at alnjoom — a ladies beauty salon in Kuwait.'))

@section('content')
<div class="max-w-4xl mx-auto px-4">

    {{-- عنوان الصفحة --}}
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            {{ __("We've answered your questions") }}
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3">{{ __('Frequently Asked Questions') }}</h1>
    </div>

    {{-- الفلاتر --}}
    <div class="flex flex-wrap justify-center gap-2 mb-10" id="filters">
        <button class="filter-btn active bg-rose-500 text-white px-5 py-2 rounded-full text-sm font-bold transition-all duration-200" data-filter="all">{{ __('All') }}</button>
        <button class="filter-btn bg-rose-50 text-rose-700 px-5 py-2 rounded-full text-sm font-bold hover:bg-rose-100 transition-all duration-200" data-filter="booking">{{ __('Booking') }}</button>
        <button class="filter-btn bg-rose-50 text-rose-700 px-5 py-2 rounded-full text-sm font-bold hover:bg-rose-100 transition-all duration-200" data-filter="cancel">{{ __('Cancellation') }}</button>
        <button class="filter-btn bg-rose-50 text-rose-700 px-5 py-2 rounded-full text-sm font-bold hover:bg-rose-100 transition-all duration-200" data-filter="services">{{ __('Services') }}</button>
        <button class="filter-btn bg-rose-50 text-rose-700 px-5 py-2 rounded-full text-sm font-bold hover:bg-rose-100 transition-all duration-200" data-filter="payment">{{ __('Payment') }}</button>
    </div>

    {{-- الأسئلة --}}
    <div class="space-y-4 mb-16" id="faqContainer">

        @php
            $faqs = [
                ['q' => __('How do I book an appointment at alnjoom?'), 'a' => __("You can easily book through the website. Click on 'Book Now' and choose the services you want, then select the date and suitable period. If you don't have an account, you can book as a guest without registering."), 'cat' => 'booking'],
                ['q' => __('Can I book multiple services in one booking?'), 'a' => __("Yes, of course! You can select multiple services in the same booking. For example, you can book a haircut with a pedicure and manicure at the same appointment."), 'cat' => 'booking'],
                ['q' => __('What are packages and offers?'), 'a' => __("Packages are special offers that combine multiple services at a discounted price. For example, the 'Complete Styling Package' includes cut, styling, and coloring at a lower price than booking each service separately."), 'cat' => 'booking'],
                ['q' => __('Can I modify my booking after submitting it?'), 'a' => __("Yes, you can modify the booking as long as it is still 'Pending'. You can change the date, period, services, or packages. However, if the booking is 'In Progress' or 'Completed', you cannot modify it."), 'cat' => 'booking'],
                ['q' => __('How do I cancel my booking?'), 'a' => __("If your booking is 'Pending', you can cancel it from the booking details page. All you need to do is write the cancellation reason and click 'Confirm Cancellation'. The booking is cancelled immediately."), 'cat' => 'cancel'],
                ['q' => __('Why might I cancel my booking?'), 'a' => __("There are many reasons — you may change your mind, have an emergency, or want to reschedule. The important thing is that cancellation happens before the booking starts."), 'cat' => 'cancel'],
                ['q' => __('Can I get a refund if I cancel?'), 'a' => __("Currently, payment is made at the salon after the service is provided, so there is no amount to refund. If there are advance booking fees, we will inform you of the refund policy."), 'cat' => 'cancel'],
                ['q' => __('What services do you offer?'), 'a' => __("We offer a wide range of care services: hair cutting, styling and coloring, skin care, pedicure and manicure, makeup, and advanced treatments. You can browse all services on the services page."), 'cat' => 'services'],
                ['q' => __('Do you use original products?'), 'a' => __("Yes, of course! We ensure the use of the best original international products to guarantee the best results and maintain the health of your hair and skin."), 'cat' => 'services'],
                ['q' => __('How long does each service take?'), 'a' => __("The time depends on the service type. For example, a haircut takes 30-45 minutes, coloring takes 60-90 minutes, pedicure and manicure take 45-60 minutes. You will see the approximate time when selecting each service."), 'cat' => 'services'],
                ['q' => __('How do I rate the service after it is done?'), 'a' => __("After your service is complete, you will receive a notification that the booking is completed. You can log into your account and click 'Rate This Service' to leave your rating and comment."), 'cat' => 'services'],
                ['q' => __('Do you accept card payments?'), 'a' => __("We accept cash and credit cards (Visa, MasterCard). Payment is made at the salon after the service is provided."), 'cat' => 'payment'],
                ['q' => __('Are there additional fees beyond the service price?'), 'a' => __("No, the price you see on the website is the final price for the service. There are no additional or hidden fees."), 'cat' => 'payment'],
                ['q' => __('How do I track my booking?'), 'a' => __("You can easily track your booking from the 'Track Your Booking' page. Enter the ticket number and phone number you registered with, and you will see all booking details."), 'cat' => 'booking'],
            ];
        @endphp

        @foreach($faqs as $index => $faq)
        <div class="faq-item bg-white rounded-2xl shadow-sm border border-rose-100/60 overflow-hidden transition-all duration-300 hover:shadow-md" data-category="{{ $faq['cat'] }}">
            <button class="faq-btn w-full flex items-center justify-between p-6 text-right hover:bg-rose-50/30 transition-colors duration-200" aria-expanded="false">
                <span class="font-bold text-gray-800 text-[15px]">{{ $faq['q'] }}</span>
                <svg class="faq-icon w-5 h-5 text-rose-400 shrink-0 mr-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
            <div class="faq-answer max-h-0 overflow-hidden transition-all duration-300 ease-in-out">
                <div class="px-6 pb-6 text-gray-500 leading-relaxed text-[15px]">
                    {{ $faq['a'] }}
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<script>
    // Accordion
    document.querySelectorAll('.faq-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('.faq-icon');
            const isOpen = this.getAttribute('aria-expanded') === 'true';

            document.querySelectorAll('.faq-btn').forEach(b => {
                b.nextElementSibling.style.maxHeight = '0';
                b.setAttribute('aria-expanded', 'false');
                b.querySelector('.faq-icon')?.classList.remove('rotate-45');
            });

            if (!isOpen) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                this.setAttribute('aria-expanded', 'true');
                icon.classList.add('rotate-45');
            }
        });
    });

    // Filters
    const filterBtns = document.querySelectorAll('.filter-btn');
    const faqItems = document.querySelectorAll('.faq-item');
    let activeFilter = 'all';

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
                b.classList.remove('active', 'bg-rose-500', 'text-white');
                b.classList.add('bg-rose-50', 'text-rose-700');
            });
            this.classList.add('active', 'bg-rose-500', 'text-white');
            this.classList.remove('bg-rose-50', 'text-rose-700');

            activeFilter = this.dataset.filter;
            let count = 0;
            faqItems.forEach(item => {
                if (activeFilter === 'all' || item.dataset.category === activeFilter) {
                    item.style.display = '';
                    count++;
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection