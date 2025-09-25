@php
    if (auth()->user()->role == 'admin')
        $formAction = route('companies.update', [$company->id, 'redirectToList' => request('redirectToList')]);
    else if (auth()->user()->role == 'company-owner')
        $formAction = route('mycompany.update');

@endphp
<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company') }} - {{$company->name}}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form action="{{ $formAction }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- =========================
                    Company Information
                    ========================== --}}
                    <div class="p-6 bg-gray-50 rounded-xl shadow-inner border border-gray-200">
                        <h3 class="text-lg font-semibold text-indigo-600 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 7v10c0 1.1.9 2 2 2h3v-4h8v4h3c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2h-3V1H8v4H5c-1.1 0-2 .9-2 2z" />
                            </svg>
                            Company Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Company Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Company Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" id="address"
                                    value="{{ old('address', $company->address) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                <select name="industry" id="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                               focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                    value="{{old('industry', $company->industry)}}">
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry }}" {{ old('industry', $company->industry) == $industry ? 'selected' : '' }}>
                                            {{ $industry }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('industry')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div>
                                <label for="website" class="block text-sm font-medium text-gray-700">Website
                                    (optional)</label>
                                <input type="url" name="website" id="website"
                                    value="{{ old('website', $company->website) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('website')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- =========================
                    Owner Information
                    ========================== --}}
                    <div class="p-6 bg-yellow-50 rounded-xl shadow-inner border border-yellow-200">
                        <h3 class="text-lg font-semibold text-yellow-600 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A7.5 7.5 0 0112 15.5a7.5 7.5 0 016.879 2.304M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Owner Information
                        </h3>

                        <div class="space-y-4">
                            <!-- Owner Name -->
                            <div>
                                <label for="owner_name" class="block text-sm font-medium text-gray-700">Owner
                                    Name</label>
                                <input type="text" name="owner_name" id="owner_name"
                                    value="{{ old('owner_name', $company->owner->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm" required>
                                @error('owner_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Owner Email (read-only) -->
                            <div>
                                <label for="owner_email" class="block text-sm font-medium text-gray-700">Owner
                                    Email</label>
                                <input type="email" name="owner_email" id="owner_email"
                                    value="{{ old('owner_email', $company->owner->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm bg-gray-100 cursor-not-allowed" readonly>
                                @error('owner_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- current password
                            <div>
                                <label for="owner_password" class="block text-sm font-medium text-gray-700">Owner
                                    current password</label>
                                <input type="password" name="owner_current_password" id="owner_current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm">
                                <p class=" text-xs text-gray-500 mt-1">Leave blank if you don't want to change the
                                    password.</p>
                                @error('owner_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <!-- Owner Password -->

                            <div class="mt-4" x-data="{ show: false }">
                                <label class="block font-medium text-sm text-gray-700" for="password">
                                    Change Password (Optional)
                                </label>

                                <div class="relative">
                                    <!-- حطينا pr-10 علشان في مساحة للأيقونة -->
                                    <input
                                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full pr-10"
                                        id="owner_password" x-bind:type="show ? 'text' : 'password'"
                                        name="owner_password" autocomplete="current-password" type="password">

                                    <!-- الزر داخل الـ input -->
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 focus:outline-none">

                                        <!-- Eye closed -->
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" style="">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3l18 18M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-5.12M6.1 6.1A10.97 10.97 0 0012 5c4.48 0 8.27 2.94 9.54 7-.57 1.82-1.68 3.41-3.15 4.6M17.9 17.9A10.97 10.97 0 0112 19c-4.48 0-8.27-2.94-9.54-7a11.03 11.03 0 012.64-4.36">
                                            </path>
                                        </svg>

                                        <!-- Eye open -->
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" style="display: none;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15a3 3 0 100-6 3 3 0 000 6z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3">
                        @if(auth()->user()->role == 'admin')
                            <a href="{{ route('companies.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                                Cancel
                            </a>
                        @else
                            <a href="{{ route('mycompany.show') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                                Cancel
                            </a>
                        @endif

                        <button type="submit" class="px-4 py-2 text-black text-sm font-medium rounded-lg shadow
                                           bg-gradient-to-r from-yellow-500 to-orange-500
                                           hover:from-yellow-600 hover:to-orange-600 transition">
                            Update Company
                        </button>
                    </div>
                </form>
                @if(session('success'))
                    <div id="success-message" class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        let message = document.getElementById("success-message");
        if (message) {
            setTimeout(() => {
                message.style.transition = "opacity 1s ease";
                message.style.opacity = "0";
                setTimeout(() => message.remove(), 1000); // يحذف العنصر بعد الاختفاء
            }, 3000); // ⏳ يبقى 3 ثواني قبل ما يبدأ يختفي
        }
    });
</script>