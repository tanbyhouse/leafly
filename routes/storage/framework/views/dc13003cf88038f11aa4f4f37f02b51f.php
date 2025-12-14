

<?php $__env->startSection('title', $product['name'] . ' - Leafly'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-6 animate-fade-in-up">
            <a href="<?php echo e(route('products.index')); ?>" class="hover:text-leafly-dark transition">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-gray-400"><?php echo e($product['category']); ?></span>
            <span class="mx-2">/</span>
            <span class="text-leafly-dark font-bold truncate"><?php echo e($product['name']); ?></span>
        </nav>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                
                <!-- image product -->
                <div class="p-6 md:p-8 bg-gray-50 flex flex-col items-center justify-center relative">
                    
                    <div class="w-full aspect-square bg-white rounded-xl shadow-inner flex items-center justify-center mb-4 relative overflow-hidden group">
                        <i class="fa-solid fa-seedling text-9xl text-leafly-green group-hover:scale-110 transition duration-500"></i>
                        
                        <!-- stock -->
                        <span class="absolute top-4 left-4 bg-leafly-dark text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            Stok: <?php echo e($product['stock']); ?>

                        </span>
                    </div>

                    <!-- thumbnail galeri -->
                    <div class="flex gap-4 overflow-x-auto w-full justify-center">
                        <?php $__currentLoopData = $product['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="w-20 h-20 bg-white rounded-lg border-2 border-transparent hover:border-leafly-gold focus:border-leafly-gold flex items-center justify-center transition shadow-sm">
                            <i class="fa-solid <?php echo e($img); ?> text-2xl text-leafly-dark/50"></i>
                        </button>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- informasi product -->
                <div class="p-6 md:p-10 flex flex-col justify-center">
                    <div class="mb-2 text-leafly-gold text-sm font-bold uppercase tracking-wider">
                        <?php echo e($product['category']); ?>

                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-leafly-dark mb-4 leading-tight">
                        <?php echo e($product['name']); ?>

                    </h1>

                    <!-- rating & review -->
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 text-sm">
                            <?php for($i=0; $i<5; $i++): ?>
                                <i class="fa-solid <?php echo e($i < floor($product['rating']) ? 'fa-star' : 'fa-star-half-stroke'); ?>"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-gray-500 text-sm ml-2 font-medium">
                            <?php echo e($product['rating']); ?> (<?php echo e($product['reviews_count']); ?> Ulasan)
                        </span>
                    </div>

                    <!-- harga -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <div class="text-4xl font-bold text-leafly-dark">
                            Rp <?php echo e(number_format($product['price'], 0, ',', '.')); ?>

                        </div>
                    </div>

                    <!-- deskripsi -->
                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                        <?php echo e($product['description']); ?>

                    </p>

                    <!-- form keranjang -->
                    <form action="#" method="POST" class="mt-auto">
                        <?php echo csrf_field(); ?>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- input jumlah -->
                            <div class="w-full sm:w-1/3">
                                <label class="text-xs text-gray-500 font-bold mb-1 block uppercase">Jumlah</label>
                                <div class="flex items-center border-2 border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" onclick="updateQty(-1)" class="w-12 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition">-</button>
                                    <input type="number" id="qty" name="quantity" value="1" min="1" max="<?php echo e($product['stock']); ?>" class="w-full text-center border-none focus:ring-0 p-0 text-leafly-dark font-bold bg-white h-full" readonly>
                                    <button type="button" onclick="updateQty(1)" class="w-12 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition">+</button>
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-2/3 pt-5">
                                <button type="button" class="w-full bg-leafly-dark text-white font-bold py-3.5 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg flex justify-center items-center gap-3 transform active:scale-95">
                                    <i class="fa-solid fa-cart-shopping"></i> Tambah Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    <!--keterangan tambahan-->
                    <div class="grid grid-cols-2 gap-4 mt-8 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-3 text-sm text-gray-500">
                            <i class="fa-solid fa-truck-fast text-leafly-dark text-lg"></i> Pengiriman Cepat
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500">
                            <i class="fa-solid fa-shield-halved text-leafly-dark text-lg"></i> Garansi Tumbuh
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- deskripsi dan ulasan -->
            <div class="border-t border-gray-200 bg-gray-50/50">
                <div class="flex border-b border-gray-200">
                    <button class="px-8 py-4 text-leafly-dark font-bold border-b-2 border-leafly-dark bg-white">Detail Produk</button>
                    <button class="px-8 py-4 text-gray-500 hover:text-leafly-dark font-medium transition">Ulasan Pelanggan</button>
                </div>
                <div class="p-8 md:p-12 bg-white">
                    <h3 class="font-bold text-xl mb-4 text-leafly-dark">Spesifikasi Lengkap</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-gray-600 mb-6 list-inside list-disc">
                        <li>Nama Latin: <i>Lactuca sativa</i></li>
                        <li>Daya Tumbuh: Min 85%</li>
                        <li>Kemurnian: 98%</li>
                        <li>Isi Bersih: 1 gram (± 800 butir)</li>
                        <li>Rekomendasi Dataran: Rendah - Tinggi</li>
                        <li>Umur Panen: 30 - 40 HST</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function updateQty(change) {
        let input = document.getElementById('qty');
        let newValue = parseInt(input.value) + change;
        if (newValue >= 1 && newValue <= <?php echo e($product['stock']); ?>) {
            input.value = newValue;
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\leafly\resources\views/products/show.blade.php ENDPATH**/ ?>