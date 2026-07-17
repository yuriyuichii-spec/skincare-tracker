<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-display font-semibold text-2xl text-ink">
                Daftar Produk Skincare
            </h2>
            <a href="{{ route('products.create') }}"
               class="bg-blush-400 hover:bg-blush-500 text-white px-4 py-2 rounded-full text-sm font-medium transition">
                + Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-sage-100 text-sage-600 px-4 py-3 rounded-xl text-sm border border-sage-400/30">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white/80 backdrop-blur-sm overflow-hidden shadow-sm border border-pink-100 rounded-2xl">
                <div class="p-6">
                    @if ($products->isEmpty())
                        <p class="text-ink/50 text-center py-8">
                            Belum ada produk. Yuk tambahkan produk skincare pertamamu! 🌸
                        </p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm text-left">
                                <thead>
                                    <tr class="border-b border-pink-100 text-ink/50">
                                        <th class="py-2 pr-4 font-medium">Foto</th>
                                        <th class="py-2 pr-4 font-medium">Nama</th>
                                        <th class="py-2 pr-4 font-medium">Kategori</th>
                                        <th class="py-2 pr-4 font-medium">Waktu Pakai</th>
                                        <th class="py-2 pr-4 font-medium">Kadaluarsa</th>
                                        <th class="py-2 pr-4 font-medium">Status</th>
                                        <th class="py-2 pr-4 font-medium">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr class="border-b border-pink-50 last:border-0">
                                            <td class="py-3 pr-4">
                                                @if ($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                         class="w-12 h-12 object-cover rounded-xl border border-pink-100">
                                                @else
                                                    <div class="w-12 h-12 flex items-center justify-center bg-blush-50 rounded-xl text-xl">
                                                        🧴
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="py-3 pr-4 font-medium text-ink">{{ $product->name }}</td>
                                            <td class="py-3 pr-4 capitalize text-ink/70">{{ $product->category }}</td>
                                            <td class="py-3 pr-4 capitalize text-ink/70">{{ $product->time_of_use }}</td>
                                            <td class="py-3 pr-4 text-ink/70">
                                                {{ $product->expiry_date?->format('d M Y') ?? '-' }}
                                            </td>
                                            <td class="py-3 pr-4">
                                                @if ($product->isExpired())
                                                    <span class="text-rose-600 font-semibold">Kadaluarsa</span>
                                                @elseif ($product->isExpiringSoon())
                                                    <span class="text-peach-600 font-semibold">Segera Habis</span>
                                                @else
                                                    <span class="text-sage-600">Aman</span>
                                                @endif
                                            </td>
                                            <td class="py-3 pr-4 space-x-2">
                                                <a href="{{ route('products.edit', $product) }}"
                                                   class="text-blush-600 hover:underline">Edit</a>
                                                <form action="{{ route('products.destroy', $product) }}"
                                                      method="POST" class="inline"
                                                      onsubmit="return confirm('Yakin mau hapus produk ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-500 hover:underline">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>