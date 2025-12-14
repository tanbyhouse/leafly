

<?php $__env->startSection('title', 'Katalog Produk - Leafly'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-leafly-dark">Katalog Produk</h1>
                <p class="text-gray-600">Temukan bibit dan alat terbaik untuk kebunmu.</p>
            </div>
            
            <!-- searchbar -->
            <div class="w-full md:w-96 relative">
                <input type="text" placeholder="Cari tanaman, bibit, atau alat..." class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- sidebar filter -->
            <div class="w-full lg:w-1/4">
                <form class="sticky top-24" action="<?php echo e(route('products.index')); ?>" method="GET">
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-lg text-leafly-dark">
                                <i class="fa-solid fa-filter mr-2"></i> Filter
                            </h3>
                        
                            <a href="<?php echo e(route('products.index')); ?>" class="text-xs text-red-500 hover:underline font-medium">
                                Reset
                            </a>
                        </div>
                        
                        <!-- kategori -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">Kategori</h4>
                            <div class="space-y-3">
                                
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="benih" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Benih Tanaman</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="bibit" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Bibit Jadi</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="alat" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Peralatan</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="paket" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Paket Bundling</span>
                                </label>
                            </div>
                        </div>

                        <!-- filter harga -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">Harga (Rp)</h4>
                            <div class="flex flex-col gap-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="min_price" placeholder="Minimum" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="max_price" placeholder="Maksimum" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-md flex justify-center items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terapkan Filter
                        </button>

                    </div>
                </form>
            </div>

            <!-- grid product -->
            <div class="w-full lg:w-3/4">
                <!-- sorting -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-500">Menampilkan 9 produk</span>
                    <select class="text-sm border-gray-300 rounded-md focus:ring-leafly-green focus:border-leafly-green">
                        <option>Terbaru</option>
                        <option>Termurah</option>
                        <option>Termahal</option>
                        <option>Terlaris</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                        $products = [
                            ['name' => 'Benih Selada Hidroponik', 'category' => 'Benih', 'price' => 'Rp 15.000', 'rating' => '4.5', 'badge' => 'Terlaris'],
                            ['name' => 'Monstera Adansonii', 'category' => 'Bibit Jadi', 'price' => 'Rp 75.000', 'rating' => '4.8', 'badge' => 'Favorit'],
                            ['name' => 'Paket Hidroponik Mini', 'category' => 'Peralatan', 'price' => 'Rp 55.000', 'rating' => '4.2', 'badge' => 'Hemat'],
                            ['name' => 'Benih Tomat Unggul', 'category' => 'Benih', 'price' => 'Rp 12.000', 'rating' => '4.1', 'badge' => null],
                            ['name' => 'Nutrisi Hidroponik 1L', 'category' => 'Perlengkapan', 'price' => 'Rp 45.000', 'rating' => '4.6', 'badge' => null],
                            ['name' => 'Paket Starter Sayuran', 'category' => 'Paket Bundling', 'price' => 'Rp 95.000', 'rating' => '4.7', 'badge' => 'Terlaris'],
                        ];
                    ?>

                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full">
                        
                        <a href="<?php echo e(route('products.show', 1)); ?>" class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden cursor-pointer">
                            <i class="fa-solid fa-seedling text-6xl text-leafly-green/50 group-hover:scale-110 transition duration-500"></i>
                            
                            <?php if(!empty($product['badge'])): ?>
                                <span class="absolute top-2 left-2 bg-leafly-gold text-leafly-dark text-xs font-bold px-2 py-1 rounded">
                                    <?php echo e($product['badge']); ?>

                                </span>
                            <?php endif; ?>
                        </a>

                        <div class="p-4 flex flex-col grow">
                            <div class="text-xs text-gray-500 mb-1"><?php echo e($product['category']); ?></div>
                            
                            <a href="<?php echo e(route('products.show', 1)); ?>" class="hover:text-leafly-green transition">
                                <h3 class="font-bold text-leafly-dark text-lg mb-1 leading-tight"><?php echo e($product['name']); ?></h3>
                            </a>
                            
                            <div class="mt-auto flex justify-between items-center">
                                <span class="text-lg font-bold text-leafly-dark"><?php echo e($product['price']); ?></span>
                                
                                <a href="<?php echo e(route('products.show', 1)); ?>" class="w-8 h-8 rounded-full bg-gray-100 text-leafly-dark hover:bg-leafly-dark hover:text-white transition flex items-center justify-center">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex gap-2">
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500"><i class="fa-solid fa-chevron-left"></i></a>
                        <a href="#" class="px-3 py-1 rounded border bg-leafly-dark text-white">1</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500">2</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500">3</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500"><i class="fa-solid fa-chevron-right"></i></a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\leafly\resources\views/products/index.blade.php ENDPATH**/ ?>