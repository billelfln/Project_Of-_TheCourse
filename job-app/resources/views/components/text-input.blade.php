@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'block mt-1 w-full bg-white/10 rounded-lg  text-white focus:border-indigo-500']) }}>