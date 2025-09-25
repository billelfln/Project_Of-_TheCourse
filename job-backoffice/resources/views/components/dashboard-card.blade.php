<div class="bg-white p-6 rounded-lg shadow text-center">
    <p class="text-gray-500 text-sm">{{ $title }}</p>
    <p class="text-3xl font-bold">{{ $value }}</p>
    @if($subtitle)
        <p class="text-xs text-gray-400">{{ $subtitle }}</p>
    @endif
</div>