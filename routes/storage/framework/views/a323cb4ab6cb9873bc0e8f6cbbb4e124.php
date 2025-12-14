

<?php $__env->startSection('title', 'Manajemen Produk'); ?>
<?php $__env->startSection('header', 'Daftar Produk'); ?>

<?php $__env->startSection('content'); ?>

<!-- alert session success -->
<?php if(session('success')): ?>
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm relative">
    <p class="font-bold">Berhasil!</p>
    <p><?php echo e(session('success')); ?></p>
    <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 mt-4 mr-4 text-green-700 font-bold">&times;</button>
</div>
<?php endif; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
<!-- toolbar -->
    <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-100">
        
        <div class="relative w-full md:w-64">
            <input type="text" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
        </div>

        <a href="<?php echo e(route('admin.products.create')); ?>" class="bg-leafly-dark text-white px-4 py-2 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">Info Produk</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800"><?php echo e($product['name']); ?></div>
                                <div class="text-xs text-gray-500">ID: <?php echo e($product['id']); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-green-50 text-leafly-dark px-2 py-1 rounded text-xs font-bold border border-green-100">
                            <?php echo e($product['category']); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        Rp <?php echo e(number_format($product['price'], 0, ',', '.')); ?>

                    </td>
                    <td class="px-6 py-4">
                        <?php if($product['stock'] > 0): ?>
                            <span class="font-bold text-gray-700"><?php echo e($product['stock']); ?></span>
                        <?php else: ?>
                            <span class="text-red-500 font-bold">0</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if($product['stock'] > 0): ?>
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span> Aktif
                        <?php else: ?>
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span> Habis
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="<?php echo e(route('admin.products.edit', $product['id'])); ?>" class="w-8 h-8 rounded bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="<?php echo e(route('admin.products.destroy', $product['id'])); ?>" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="p-6 border-t border-gray-100 flex justify-between items-center">
        <span class="text-sm text-gray-500">Menampilkan 3 dari 45 data</span>
        <div class="flex gap-2">
            <button class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50" disabled>Prev</button>
            <button class="px-3 py-1 bg-leafly-dark text-white rounded">1</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\laragon\www\leafly\resources\views/admin/products/index.blade.php ENDPATH**/ ?>