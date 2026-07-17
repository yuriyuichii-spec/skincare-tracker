<x-app-layout>
    <x-slot name="header">
        <h2 class="font-display font-semibold text-2xl text-ink">
            Kalender Riwayat Rutinitas
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 backdrop-blur-sm shadow-sm border border-pink-100 rounded-2xl p-6">

                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('routine.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
                       class="text-blush-600 hover:underline text-sm">← Sebelumnya</a>
                    <h3 class="font-display font-semibold text-lg text-ink">{{ $startOfMonth->translatedFormat('F Y') }}</h3>
                    <a href="{{ route('routine.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
                       class="text-blush-600 hover:underline text-sm">Berikutnya →</a>
                </div>

                <div class="grid grid-cols-7 gap-2 text-center text-xs text-ink/40 mb-2">
                    <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
                </div>

                <div class="grid grid-cols-7 gap-2">
                    @for ($i = 0; $i < $startOfMonth->dayOfWeek; $i++)
                        <div></div>
                    @endfor

                    @foreach ($days as $day)
                        @php
                            $colorMap = [
                                'complete' => 'bg-sage-100 text-sage-600 border-sage-400/40',
                                'partial'  => 'bg-peach-100 text-peach-600 border-peach-400/40',
                                'missed'   => 'bg-rose-100 text-rose-600 border-rose-400/40',
                                'empty'    => 'bg-blush-50/50 text-ink/30 border-pink-100',
                                'future'   => 'bg-blush-50/50 text-ink/30 border-pink-100',
                            ];
                        @endphp
                        <div class="border rounded-xl py-2 text-sm text-center {{ $colorMap[$day['status']] }}">
                            {{ $day['date']->day }}
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap gap-4 mt-6 text-xs text-ink/60">
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-sage-400 inline-block"></span> Lengkap
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-peach-400 inline-block"></span> Sebagian
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-rose-400 inline-block"></span> Terlewat
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-blush-100 inline-block"></span> Tidak ada data
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>