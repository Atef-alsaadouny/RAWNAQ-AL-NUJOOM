<?php $__env->startSection('title', __('site_name') . ' — ' . __('Contact Us')); ?>
<?php $__env->startSection('meta_description', __('Contact alnjoom — a ladies beauty salon in Kuwait. Phone, WhatsApp, email, or visit us in Salmiya.')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4">

    
    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            <?php echo e(__('Contact Us')); ?>

        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3"><?php echo e(__('Contact Us')); ?></h1>
        <p class="text-gray-500 text-lg max-w-2xl mx-auto"><?php echo e(__("We are here to serve you — contact us in any way that suits you")); ?></p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-16">

        
        <div class="bg-gradient-to-b from-rose-50 via-white to-amber-50 rounded-[2.5rem] shadow-sm border border-rose-100/50 p-10 md:p-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-8"><?php echo e(__('Contact Information')); ?></h2>
            <div class="space-y-6">
                <div class="flex items-start gap-5 p-5 bg-white/80 rounded-2xl">
                    <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1"><?php echo e(__('Location')); ?></p>
                        <p class="text-gray-500 text-[15px]"><?php echo e(__("Kuwait — Salmiya, Arabian Gulf Street")); ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-5 bg-white/80 rounded-2xl">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1"><?php echo e(__('Phone / WhatsApp')); ?></p>
                        <p class="text-gray-500 text-[15px]" dir="ltr"><?php echo e(config('app.phone', '+965 1234 5678')); ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-5 bg-white/80 rounded-2xl">
                    <div class="w-12 h-12 bg-rose-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1"><?php echo e(__('Email')); ?></p>
                        <p class="text-gray-500 text-[15px]"><?php echo e(config('app.contact_email', 'info@rawnaqalnujoom.com')); ?></p>
                    </div>
                </div>
                <div class="flex items-start gap-5 p-5 bg-white/80 rounded-2xl">
                    <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1"><?php echo e(__('Working Hours')); ?></p>
                        <p class="text-gray-500 text-[15px]"><?php echo e(__('Sat - Thu: 10:00 AM - 10:00 PM')); ?></p>
                        <p class="text-gray-500 text-[15px]"><?php echo e(__('Fri: 1:00 PM - 8:00 PM')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-rose-100/50 p-10 md:p-12">
            <h2 class="text-2xl font-bold text-gray-800 mb-2"><?php echo e(__('Send Us a Message')); ?></h2>
            <p class="text-gray-500 text-sm mb-8"><?php echo e(__("We are listening — send us your inquiry or suggestion")); ?></p>
            <form method="POST" action="<?php echo e(route('contact.send')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm"><?php echo e(__('Name')); ?></label>
                    <input type="text" name="name" required class="w-full border border-gray-200 rounded-xl px-5 py-3.5 focus:ring-2 focus:ring-rose-400 focus:border-transparent transition" placeholder="<?php echo e(__('Your full name')); ?>">
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm"><?php echo e(__('Phone Number')); ?></label>
                    <input type="tel" name="phone" required dir="ltr" class="w-full border border-gray-200 rounded-xl px-5 py-3.5 focus:ring-2 focus:ring-rose-400 focus:border-transparent transition text-left" placeholder="XXXXXXXX">
                </div>
                <div class="mb-5">
                    <label class="block text-gray-700 font-bold mb-2 text-sm"><?php echo e(__('Email')); ?></label>
                    <input type="email" name="email" dir="ltr" class="w-full border border-gray-200 rounded-xl px-5 py-3.5 focus:ring-2 focus:ring-rose-400 focus:border-transparent transition text-left" placeholder="name@example.com">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2 text-sm"><?php echo e(__('Message')); ?></label>
                    <textarea name="message" rows="4" required class="w-full border border-gray-200 rounded-xl px-5 py-3.5 focus:ring-2 focus:ring-rose-400 focus:border-transparent transition" placeholder="<?php echo e(__('Write your message here')); ?>"></textarea>
                </div>
                <button type="submit" class="w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-4 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 transition-all duration-200">
                    <?php echo e(__('Send Message')); ?>

                </button>
            </form>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/contact.blade.php ENDPATH**/ ?>