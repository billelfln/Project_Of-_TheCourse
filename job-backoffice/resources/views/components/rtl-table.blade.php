{{-- RTL-Aware Table Component --}}
@props(['headers' => [], 'colspan' => '1'])

<div class="overflow-x-auto">
    <table class="w-full border-collapse border border-gray-200 rounded-lg shadow">
        <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
            <tr>
                @foreach($headers as $header)
                    <th class="px-6 py-3 text-start text-sm font-semibold whitespace-nowrap">
                        {{ $header }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            {{ $slot }}
        </tbody>
    </table>
</div>

{{-- Example usage in a Blade template:
<x-rtl-table :headers="['#', __('common.title'), __('app.location'), __('app.actions')]">
    @foreach($items as $item)
    <tr class="hover:bg-gray-50 transition">
        <td class="px-6 py-4 text-sm">{{ $loop->iteration }}</td>
        <td class="px-6 py-4 text-sm font-medium">{{ $item->title }}</td>
        <td class="px-6 py-4 text-sm">{{ $item->location }}</td>
        <td class="px-6 py-4 text-sm">
            <div class="flex gap-2 rtl:flex-row-reverse">
                <button class="px-3 py-1 bg-blue-500 text-white rounded">Edit</button>
                <button class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
            </div>
        </td>
    </tr>
    @endforeach
</x-rtl-table>
--}}