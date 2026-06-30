<?php $__env->startSection('title', __('site_name') . ' — ' . __('Our Services')); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4">

    <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-rose-100/60 text-rose-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
            <span class="w-2 h-2 bg-rose-400 rounded-full animate-pulse"></span>
            <?php echo e(__('Ladies Care Services')); ?>

        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-3"><?php echo e(__('Our Services')); ?></h1>
        <p class="text-gray-500 text-lg"><?php echo e(__("Choose the service that suits you and book your appointment")); ?></p>
    </div>

    
    <div class="bg-gradient-to-r from-rose-50 via-amber-50 to-rose-50 border border-rose-200/60 rounded-2xl p-5 mb-10 text-center">
        <div class="flex items-center justify-center gap-3 flex-wrap">
            <span class="text-2xl">💡</span>
            <div>
                <p class="text-gray-700 font-medium">
                    <?php echo e(__("You can select multiple services in one booking")); ?>

                </p>
                <p class="text-gray-500 text-sm mt-0.5">
                    <?php echo e(__("Save time — choose all the services you want and enjoy a complete experience")); ?>

                </p>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($services->isEmpty()): ?>
        <div class="text-center py-20">
            <div class="text-6xl mb-4">💅</div>
            <p class="text-gray-400 text-lg"><?php echo e(__('No services available at the moment')); ?></p>
        </div>
    <?php else: ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty() && $categories->count() > 1): ?>
        <div class="flex flex-wrap justify-center gap-2 mb-8" id="categoryFilter">
            <button class="cat-btn active px-5 py-2 rounded-full text-sm font-bold border-2 border-rose-200 text-rose-700 bg-rose-50 hover:bg-rose-100 transition-all" data-cat="all">
                <?php echo e(__('All')); ?>

            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat => $catServices): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <button class="cat-btn px-5 py-2 rounded-full text-sm font-medium border-2 border-gray-200 text-gray-600 hover:border-rose-200 hover:text-rose-600 transition-all" data-cat="<?php echo e($cat); ?>">
                <?php echo e($cat); ?>

            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" id="servicesGrid">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl border border-gray-100 hover:border-rose-200 transition-all duration-300 hover:-translate-y-1 p-8 flex flex-col items-center text-center service-card" data-category="<?php echo e($service->category ?? __('Uncategorized')); ?>">
                <div class="w-20 h-20 bg-gradient-to-br from-rose-100 to-amber-100 rounded-2xl flex items-center justify-center mb-5 group-hover:scale-110 group-hover:from-rose-200 group-hover:to-amber-200 transition-all duration-300 shadow-sm">
                    <span class="text-3xl">
                        <?php
                            $emojiMap = ['شعر'=>'💇‍♀️','مكياج'=>'💄','مساج'=>'💆‍♀️','أظافر'=>'💅','بشرة'=>'✨','عناية'=>'✨','أخرى'=>'💫'];
                        ?>
                        <?php echo e($emojiMap[$service->category] ?? '💫'); ?>

                    </span>
                </div>

                <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($service->name); ?></h3>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($service->description): ?>
                    <p class="text-gray-500 text-sm leading-relaxed mb-5 line-clamp-2"><?php echo e($service->description); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <div class="mt-auto w-full">
                    <div class="flex justify-center items-baseline gap-1.5 mb-5">
                        <span class="text-3xl font-extrabold text-rose-600"><?php echo e(formatCurrency($service->price)); ?></span>
                    </div>

                    <a href="<?php echo e(route('book', ['service_id' => $service->id])); ?>"
                       class="block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 hover:-translate-y-0.5 transition-all duration-200 text-[15px]">
                        <?php echo e(__('Book Now')); ?>

                    </a>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($categories->isNotEmpty() && $categories->count() > 1): ?>
        <script>
        document.querySelectorAll('.cat-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.cat-btn').forEach(function(b) {
                    b.classList.remove('active', 'bg-rose-50', 'text-rose-700', 'border-rose-200');
                    b.classList.add('border-gray-200', 'text-gray-600');
                });
                this.classList.add('active', 'bg-rose-50', 'text-rose-700', 'border-rose-200');
                this.classList.remove('border-gray-200', 'text-gray-600');
                var cat = this.dataset.cat;
                document.querySelectorAll('.service-card').forEach(function(card) {
                    if (cat === 'all' || card.dataset.category === cat) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        </script>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($packages->isNotEmpty()): ?>
    <div class="mt-16 mb-16">
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-amber-100/60 text-amber-700 px-5 py-2 rounded-full text-sm font-medium mb-4">
                🎁 <?php echo e(__('Our Special Offers')); ?>

            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-3"><?php echo e(__('Packages & Offers')); ?></h2>
            <p class="text-gray-500"><?php echo e(__("Benefit from our special offers and exclusive packages")); ?></p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $discount = $package->original_price && $package->original_price > $package->price
                    ? round((1 - $package->price / $package->original_price) * 100)
                    : 0;
                $icons = ['💇‍♀️', '💄', '✨', '💅', '💆‍♀️', '🧴', '🎀', '💫'];
                $bgColors = ['from-rose-50 to-amber-50', 'from-purple-50 to-pink-50', 'from-teal-50 to-emerald-50', 'from-blue-50 to-indigo-50'];
            ?>
            <div class="bg-gradient-to-br <?php echo e($bgColors[$loop->index % count($bgColors)]); ?> border-2 border-rose-200/60 rounded-2xl p-8 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($discount > 0): ?>
                <div class="absolute top-3 left-3 bg-rose-500 text-white text-xs font-bold px-3 py-1 rounded-full"><?php echo e(__('Discount')); ?> <?php echo e($discount); ?>%</div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <div class="text-4xl mb-4 mt-4"><?php echo e($icons[$loop->index % count($icons)]); ?></div>
                <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($package->name); ?></h3>
                <p class="text-gray-500 text-sm mb-4"><?php echo e($package->description ?: $package->services->pluck('name')->implode(' + ')); ?></p>
                <div class="flex justify-center items-baseline gap-3 mb-5">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->original_price && $package->original_price > $package->price): ?>
                    <span class="text-lg text-gray-400 line-through"><?php echo e(formatCurrency($package->original_price)); ?></span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <span class="text-3xl font-extrabold text-rose-600"><?php echo e(formatCurrency($package->price)); ?></span>
                </div>
                <a href="<?php echo e(route('book', ['package_ids[]' => $package->id])); ?>"
                   class="block w-full bg-gradient-to-l from-rose-500 to-rose-600 text-white py-3 rounded-xl font-bold shadow-lg shadow-rose-200/60 hover:shadow-xl hover:from-rose-600 hover:to-rose-700 transition-all duration-200">
                    <?php echo e(__('Book Package')); ?>

                </a>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/resources/views/services.blade.php ENDPATH**/ ?>