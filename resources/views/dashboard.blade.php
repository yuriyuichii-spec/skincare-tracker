<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-ink">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6 text-center">
                    <p class="text-3xl font-display font-bold text-blush-600">{{ $totalProducts }}</p>
                    <p class="text-sm text-ink/60 mt-1">Total Produk</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6 text-center">
                    <p class="text-3xl font-display font-bold text-blush-600">{{ $doneToday }}/{{ $totalRequiredToday }}</p>
                    <p class="text-sm text-ink/60 mt-1">Checklist Hari Ini</p>
                </div>
                <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6 text-center">
                    <p class="text-3xl font-display font-bold text-blush-600">🔥 {{ $streak }}</p>
                    <p class="text-sm text-ink/60 mt-1">Hari Beruntun Konsisten</p>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6">
                <h3 class="font-display font-semibold text-lg mb-4 text-ink">Menu Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}"
                       class="bg-blush-400 hover:bg-blush-500 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                        Kelola Produk
                    </a>
                    <a href="{{ route('routine.today') }}"
                       class="bg-blush-50 hover:bg-blush-100 text-blush-700 px-4 py-2 rounded-full text-sm font-medium transition">
                        Rutinitas Hari Ini
                    </a>
                    <a href="{{ route('routine.calendar') }}"
                       class="bg-blush-50 hover:bg-blush-100 text-blush-700 px-4 py-2 rounded-full text-sm font-medium transition">
                        Kalender Riwayat
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>