<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-sm border-b border-pink-100 sticky top-0 z-20">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <span class="text-xl">🌸</span>
                        <span class="font-display font-semibold text-blush-600 text-lg">Skincare Tracker</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-full text-sm font-medium transition
                       {{ request()->routeIs('dashboard') ? 'bg-blush-100 text-blush-700' : 'text-ink/70 hover:bg-blush-50 hover:text-blush-600' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('products.index') }}"
                       class="px-3 py-2 rounded-full text-sm font-medium transition
                       {{ request()->routeIs('products.*') ? 'bg-blush-100 text-blush-700' : 'text-ink/70 hover:bg-blush-50 hover:text-blush-600' }}">
                        Produk
                    </a>
                    <a href="{{ route('routine.today') }}"
                       class="px-3 py-2 rounded-full text-sm font-medium transition
                       {{ request()->routeIs('routine.today') ? 'bg-blush-100 text-blush-700' : 'text-ink/70 hover:bg-blush-50 hover:text-blush-600' }}">
                        Rutinitas Hari Ini
                    </a>
                    <a href="{{ route('routine.calendar') }}"
                       class="px-3 py-2 rounded-full text-sm font-medium transition
                       {{ request()->routeIs('routine.calendar') ? 'bg-blush-100 text-blush-700' : 'text-ink/70 hover:bg-blush-50 hover:text-blush-600' }}">
                        Kalender
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-full text-ink/70 bg-blush-50 hover:bg-blush-100 hover:text-blush-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-blush-400 hover:text-blush-600 hover:bg-blush-50 focus:outline-none focus:bg-blush-50 focus:text-blush-600 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/90 backdrop-blur-sm">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                Produk
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('routine.today')" :active="request()->routeIs('routine.today')">
                Rutinitas Hari Ini
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('routine.calendar')" :active="request()->routeIs('routine.calendar')">
                Kalender
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-pink-100">
            <div class="px-4">
                <div class="font-medium text-base text-ink">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-ink/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>