<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-ink">
            Rutinitas Hari Ini — {{ $today->translatedFormat('d F Y') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="bg-sage-100 text-sage-600 px-4 py-3 rounded-xl text-sm border border-sage-400/30">
                    {{ session('success') }}
                </div>
            @endif

            @if ($reminders->isNotEmpty())
                <div class="bg-peach-100 border border-peach-400/40 rounded-2xl p-4">
                    <p class="font-semibold text-peach-600 mb-2">⚠️ Pengingat Produk</p>
                    <ul class="list-disc list-inside text-sm text-peach-700 space-y-1">
                        @foreach ($reminders as $product)
                            <li>
                                {{ $product->name }} —
                                @if ($product->isExpired())
                                    sudah kadaluarsa ({{ $product->expiry_date->format('d M Y') }})
                                @else
                                    akan kadaluarsa {{ $product->expiry_date->diffForHumans() }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6">
                <h3 class="font-display font-semibold text-lg mb-4 text-ink">☀️ Rutinitas Pagi</h3>
                @if ($morningProducts->isEmpty())
                    <p class="text-ink/50 text-sm">Belum ada produk untuk rutinitas pagi.</p>
                @else
                    <div class="space-y-2">
                        @foreach ($morningProducts as $product)
                            @php
                                $log = $logsToday->get($product->id . '_pagi');
                                $isDone = $log && $log->is_done;
                            @endphp
                            <form action="{{ route('routine.toggle') }}" method="POST"
                                  class="flex items-center justify-between border border-pink-100 rounded-xl px-4 py-2 {{ $isDone ? 'bg-sage-100/50' : '' }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="time_of_day" value="pagi">
                                <span class="{{ $isDone ? 'line-through text-ink/40' : 'text-ink' }}">
                                    {{ $product->name }}
                                </span>
                                <button type="submit"
                                        class="text-sm px-3 py-1 rounded-full transition {{ $isDone ? 'bg-sage-400 text-white' : 'bg-blush-50 text-blush-600 hover:bg-blush-100' }}">
                                    {{ $isDone ? '✓ Selesai' : 'Tandai selesai' }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6">
                <h3 class="font-display font-semibold text-lg mb-4 text-ink">🌙 Rutinitas Malam</h3>
                @if ($eveningProducts->isEmpty())
                    <p class="text-ink/50 text-sm">Belum ada produk untuk rutinitas malam.</p>
                @else
                    <div class="space-y-2">
                        @foreach ($eveningProducts as $product)
                            @php
                                $log = $logsToday->get($product->id . '_malam');
                                $isDone = $log && $log->is_done;
                            @endphp
                            <form action="{{ route('routine.toggle') }}" method="POST"
                                  class="flex items-center justify-between border border-pink-100 rounded-xl px-4 py-2 {{ $isDone ? 'bg-sage-100/50' : '' }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="time_of_day" value="malam">
                                <span class="{{ $isDone ? 'line-through text-ink/40' : 'text-ink' }}">
                                    {{ $product->name }}
                                </span>
                                <button type="submit"
                                        class="text-sm px-3 py-1 rounded-full transition {{ $isDone ? 'bg-sage-400 text-white' : 'bg-blush-50 text-blush-600 hover:bg-blush-100' }}">
                                    {{ $isDone ? '✓ Selesai' : 'Tandai selesai' }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="text-center">
                <a href="{{ route('products.index') }}" class="text-blush-600 hover:underline text-sm">
                    Kelola daftar produk →
                </a>
            </div>
        </div>
    </div>
</x-app-layout>