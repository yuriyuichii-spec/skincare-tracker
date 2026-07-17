<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-ink">
            Tambah Produk Skincare
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-ink/80">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">
                        @error('name') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink/80">Foto Produk (opsional)</label>
                        <input type="file" name="image" accept="image/*"
                               class="mt-1 block w-full text-sm text-ink/60">
                        @error('image') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink/80">Kategori</label>
                        <select name="category" class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">
                            @foreach (['cleanser','toner','serum','moisturizer','sunscreen','treatment','other'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                                    {{ ucfirst($cat) }}
                                </option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink/80">Waktu Pakai</label>
                        <select name="time_of_use" class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">
                            <option value="pagi" {{ old('time_of_use') === 'pagi' ? 'selected' : '' }}>Pagi</option>
                            <option value="malam" {{ old('time_of_use') === 'malam' ? 'selected' : '' }}>Malam</option>
                            <option value="keduanya" {{ old('time_of_use') === 'keduanya' ? 'selected' : '' }}>Keduanya</option>
                        </select>
                        @error('time_of_use') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-ink/80">Tanggal Beli</label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date') }}"
                                   class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">
                            @error('purchase_date') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-ink/80">Tanggal Kadaluarsa</label>
                            <input type="date" name="expiry_date" value="{{ old('expiry_date') }}"
                                   class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">
                            @error('expiry_date') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-ink/80">Catatan (opsional)</label>
                        <textarea name="notes" rows="3"
                                  class="mt-1 block w-full rounded-xl border-pink-200 focus:border-blush-400 focus:ring-blush-300 shadow-sm">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('products.index') }}" class="px-4 py-2 rounded-full text-ink/60 hover:bg-blush-50">Batal</a>
                        <button type="submit"
                                class="bg-blush-400 hover:bg-blush-500 text-white px-4 py-2 rounded-full font-medium transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>