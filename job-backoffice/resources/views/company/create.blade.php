<!DOCTYPE html>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Company') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                <form action="{{ route('companies.store') }}" method="POST" class="space-y-8">
                    @csrf

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
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Industry -->
                            <div>
                                <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                                <select name="industry" id="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                               focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">-- Select Industry --</option>
                                    @foreach($industries as $industry)
                                        <option value="{{ $industry }}" {{ old('industry') == $industry ? 'selected' : '' }}>
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
                                <input type="url" name="website" id="website" value="{{ old('website') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
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
                                <input type="text" name="owner_name" id="owner_name" value="{{ old('owner_name') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm" required>
                                @error('owner_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Owner Email -->
                            <div>
                                <label for="owner_email" class="block text-sm font-medium text-gray-700">Owner
                                    Email</label>
                                <input type="email" name="owner_email" id="owner_email" value="{{ old('owner_email') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm" required>
                                @error('owner_email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            {{-- <div class="mt-4" x-data="{ show: false }">
                                <x-input-label for="password" :value="__('Password')" />

                                <div class="relative">
                                    <!-- حطينا pr-10 علشان في مساحة للأيقونة -->
                                    <x-text-input id="password" class="block mt-1 w-full pr-10"
                                        x-bind:type="show ? 'text' : 'password'" name="password" required
                                        autocomplete="current-password" />

                                    <!-- الزر داخل الـ input -->
                                    <button type="button" @click="show = !show"
                                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 focus:outline-none">

                                        <!-- Eye closed -->
                                        <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 3l18 18M9.88 9.88A3 3 0 0012 15a3 3 0 002.12-5.12M6.1 6.1A10.97 10.97 0 0012 5c4.48 0 8.27 2.94 9.54 7-.57 1.82-1.68 3.41-3.15 4.6M17.9 17.9A10.97 10.97 0 0112 19c-4.48 0-8.27-2.94-9.54-7a11.03 11.03 0 012.64-4.36" />
                                        </svg>

                                        <!-- Eye open -->
                                        <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15a3 3 0 100-6 3 3 0 000 6z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div> --}}
                            <!-- Owner Password -->
                            <div>
                                <label for="owner_password" class="block text-sm font-medium text-gray-700">Owner
                                    Password</label>
                                <input type="password" name="owner_password" id="owner_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                                              focus:border-yellow-500 focus:ring-yellow-500 sm:text-sm" required>
                                @error('owner_password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3">
                        <a href="{{ route('companies.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-300 transition">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 text-white text-sm font-medium rounded-lg shadow
                                           bg-gradient-to-r from-indigo-500 to-purple-500
                                           hover:from-indigo-600 hover:to-purple-600 transition">
                            Create Company
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>