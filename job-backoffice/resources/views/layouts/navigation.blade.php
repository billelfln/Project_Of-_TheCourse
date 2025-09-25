<nav class="w-[250px] h-screen bg-white border-e border-gray-200">
    {{-- application logo --}}
    <div class="flex items-center px-6 border-b border-gray-200 py-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-14 w-auto fill-current text-gray-800" />
            <span class="text-lg font-semibold text-gray-800">Shaghalni</span>
        </a>
    </div>

    {{-- language switcher --}}
    <div class="px-4 py-3 border-b border-gray-200">
        <x-language-switcher />
    </div>

    {{-- navigation links --}}
    <ul class="flex flex-col px-4 py-6 space-y-2">
        <li>
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('navigation.dashboard') }}
            </x-nav-link>
            @if(auth()->user()->role == 'admin')
                <x-nav-link :href="route('companies.index', ['archived' => 'false'])"
                    :active="request()->routeIs('companies.*')">
                    {{ __('navigation.companies') }}
                </x-nav-link>
            @endif
            @if(auth()->user()->role == 'company-owner')
                <x-nav-link :href="route('mycompany.show', )" :active="request()->routeIs('mycompany.show')">
                    {{ __('navigation.my_company') }}
                </x-nav-link>
            @endif

            <x-nav-link :href="route('job_applications.index', ['archived' => 'false'])"
                :active="request()->routeIs('applications.*')">
                {{ __('navigation.applications') }}
            </x-nav-link>

            @if(auth()->check() && auth()->user()->role == 'admin')
                <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                    {{ __('navigation.categories') }}
                </x-nav-link>
            @endif

            <x-nav-link :href="route('jobVacancies.index', ['archived' => 'false'])"
                :active="request()->routeIs('jobVacancies.*')">
                {{ __('navigation.job_vacancies') }}
            </x-nav-link>

            @if(auth()->check() && auth()->user()->role == 'admin')
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('navigation.users') }}
                </x-nav-link>
            @endif
            <hr>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="text-red-600">
                    {{ __('navigation.log_out') }}
                </x-nav-link>
            </form>

        </li>
    </ul>
</nav>