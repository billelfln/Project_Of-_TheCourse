# RTL (Right-to-Left) Support Guide

## Overview
This Laravel application now has comprehensive RTL support for Arabic language, ensuring tables, layouts, and UI elements work correctly in both LTR (Left-to-Right) and RTL modes.

## Key Changes Made

### 1. HTML Direction Attribute
- **Location**: `resources/views/layouts/app.blade.php`
- **Implementation**: Automatic `dir="rtl"` for Arabic and `dir="ltr"` for other languages
```blade
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
```

### 2. Tailwind CSS RTL Plugin
- **Installed**: `tailwindcss-rtl` plugin for better RTL utilities
- **Configuration**: Added to `tailwind.config.js`
```javascript
import rtl from 'tailwindcss-rtl';
// ...
plugins: [forms, rtl],
```

### 3. Table RTL Fixes
- **Changed**: `text-left` → `text-start` for automatic direction adaptation
- **Updated**: Action buttons use `flex gap-2 rtl:flex-row-reverse` for proper RTL ordering
- **Enhanced**: Navigation uses `border-e` (border-end) instead of `border-r` (border-right)

### 4. Font Support
- **Added**: Arabic font class to body when Arabic is selected
- **Fonts**: Noto Sans Arabic for proper Arabic text rendering

## RTL-Aware Classes Used

### Text Alignment
- `text-start` - Aligns text to the start (left in LTR, right in RTL)
- `text-end` - Aligns text to the end (right in LTR, left in RTL)

### Spacing & Layout
- `ps-4` - Padding start (left in LTR, right in RTL)
- `pe-4` - Padding end (right in LTR, left in RTL)
- `ms-4` - Margin start
- `me-4` - Margin end
- `border-e` - Border end
- `border-s` - Border start

### Flexbox
- `rtl:flex-row-reverse` - Reverses flex direction in RTL mode
- `gap-2` - Uniform gap (better than space-x-2 for RTL)

## Component Examples

### RTL-Compatible Table
```blade
<table class="w-full border-collapse border border-gray-200 rounded-lg shadow">
    <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
        <tr>
            <th class="px-6 py-3 text-start text-sm font-semibold">#</th>
            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('common.title') }}</th>
            <th class="px-6 py-3 text-start text-sm font-semibold">{{ __('app.actions') }}</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm">1</td>
            <td class="px-6 py-4 text-sm font-medium">Sample Title</td>
            <td class="px-6 py-4 text-sm">
                <div class="flex gap-2 rtl:flex-row-reverse">
                    <button class="px-3 py-1 bg-blue-500 text-white rounded">Edit</button>
                    <button class="px-3 py-1 bg-red-500 text-white rounded">Delete</button>
                </div>
            </td>
        </tr>
    </tbody>
</table>
```

### RTL-Compatible Navigation
```blade
<nav class="w-[250px] h-screen bg-white border-e border-gray-200">
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-14 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>
</nav>
```

## Best Practices for RTL Development

### 1. Use Logical Properties
- Prefer `text-start`/`text-end` over `text-left`/`text-right`
- Use `ps-*`/`pe-*` over `pl-*`/`pr-*`
- Use `ms-*`/`me-*` over `ml-*`/`mr-*`

### 2. Flexbox & Grid
- Use `gap-*` instead of `space-x-*` for consistent spacing
- Use `rtl:flex-row-reverse` when order matters in RTL
- Consider grid layouts for complex arrangements

### 3. Borders & Positioning
- Use `border-s`/`border-e` over `border-l`/`border-r`
- Use `start-*`/`end-*` over `left-*`/`right-*` for positioning

### 4. Testing
- Always test both LTR and RTL layouts
- Verify table alignments, button orders, and text flow
- Check responsive behavior in both directions

## Files Updated for RTL Support

1. **Layout Files**
   - `resources/views/layouts/app.blade.php` - HTML dir attribute, font classes
   - `resources/views/layouts/navigation.blade.php` - RTL navigation

2. **Table Views**
   - `resources/views/job_vacancy/index.blade.php` - RTL table fixes
   - `resources/views/components/dashboard-table.blade.php` - Dashboard tables

3. **Configuration**
   - `tailwind.config.js` - RTL plugin configuration
   - `package.json` - RTL plugin dependency

4. **Components**
   - `resources/views/components/rtl-table.blade.php` - RTL table component example

## Testing RTL Layout

1. Switch language to Arabic using the language switcher
2. Verify table headers align to the right
3. Check that action buttons are in correct order (Edit, then Delete from right to left)
4. Ensure navigation elements are properly positioned
5. Test responsive behavior on different screen sizes

## Troubleshooting Common RTL Issues

### Table Misalignment
- Ensure using `text-start` instead of `text-left`
- Check that `dir="rtl"` is set on HTML element
- Verify Tailwind CSS includes RTL plugin

### Button Order Issues
- Use `flex gap-2 rtl:flex-row-reverse` for action buttons
- Avoid `space-x-*` classes in RTL contexts

### Border/Spacing Issues
- Replace directional classes (`pl-*`, `border-l`) with logical ones (`ps-*`, `border-s`)
- Use the RTL plugin utilities for complex layouts

## Performance Notes
- RTL plugin adds minimal overhead to CSS bundle
- Font loading is conditional (Arabic fonts only load for Arabic locale)
- No JavaScript required for RTL functionality