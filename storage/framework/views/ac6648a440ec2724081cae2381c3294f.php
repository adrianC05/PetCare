<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare - Clínica Veterinaria</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#f8fafc] antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-8">

        <main class="max-w-5xl w-full flex flex-col lg:flex-row bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] overflow-hidden">

            <div class="flex-1 p-8 sm:p-16 lg:p-20 flex flex-col justify-center border-b lg:border-b-0 lg:border-r border-gray-100">

                <div class="flex items-center gap-3 mb-10">
                    <div class="bg-orange-500 p-2 rounded-xl shadow-lg shadow-orange-200">
                        <span class="text-2xl">🩺</span>
                    </div>
                    <span class="text-2xl font-black text-gray-800 tracking-tighter">PetCare</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-gray-900 mb-6 leading-[1.1]">
                    Cuidamos lo que <br>
                    <span class="text-orange-500">más amas.</span>
                </h1>

                <p class="text-gray-500 text-lg mb-10 max-w-md leading-relaxed">
                    La plataforma inteligente para gestionar tu clínica veterinaria con amor, eficiencia y tecnología.
                </p>

                <div class="space-y-6 mb-12">
                    <div class="flex items-center gap-5 group">
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-2xl group-hover:bg-orange-500 group-hover:rotate-12 transition-all duration-300">🐾</div>
                        <div>
                            <p class="text-gray-900 font-bold">Gestión Integral</p>
                            <p class="text-gray-500 text-sm">Mascotas y dueños bajo control.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-5 group">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-2xl group-hover:bg-blue-500 group-hover:-rotate-12 transition-all duration-300">📅</div>
                        <div>
                            <p class="text-gray-900 font-bold">Citas Médicas</p>
                            <p class="text-gray-500 text-sm">Agenda organizada y recordatorios.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/admin')); ?>" class="flex-1 text-center bg-gray-900 text-white py-5 rounded-2xl font-bold hover:bg-orange-600 hover:-translate-y-1 transition-all shadow-xl shadow-gray-200">
                        Ir al Panel de Control
                    </a>
                    <?php else: ?>
                    <a href="<?php echo e(url('/admin/login')); ?>" class="flex-1 text-center bg-orange-500 text-white py-5 rounded-2xl font-bold hover:bg-gray-900 hover:-translate-y-1 transition-all shadow-xl shadow-orange-100">
                        Iniciar Sesión
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <div class="flex-1 bg-gradient-to-br from-orange-50 to-orange-100 items-center justify-center relative hidden sm:flex min-h-[400px]">
                <div class="absolute top-10 right-10 w-32 h-32 bg-orange-200/40 rounded-full blur-2xl"></div>
                <div class="absolute bottom-10 left-10 w-40 h-40 bg-white/50 rounded-full blur-3xl"></div>

                <div class="relative z-10 text-center">
                    <div class="text-[10rem] lg:text-[14rem] drop-shadow-2xl animate-bounce duration-[3000ms]">🐶</div>
                    <div class="mt-8 inline-flex items-center gap-2 bg-white/90 backdrop-blur px-6 py-3 rounded-full border border-white shadow-xl">
                        <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
                        <p class="text-orange-900 font-bold text-sm">✨ ¡Tu clínica, organizada!</p>
                    </div>
                </div>
            </div>

        </main>
    </div>
</body>

</html><?php /**PATH C:\Users\Stephanie Valencia\PetCare\resources\views/welcome.blade.php ENDPATH**/ ?>