@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-pink-200 focus:border-blush-400 focus:ring-blush-300 rounded-xl shadow-sm']) }}>
