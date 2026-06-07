<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        {{-- @vite(['resources/css/app.css','resources/js/app.js'])  --}}
        @include('partials.head')
        @filamentStyles
        @vite(['./resources/css/app.css','./resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-r border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="mr-5 flex items-center space-x-2" wire:navigate>
                <x-app-logo class="size-8" href="#"></x-app-logo>
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group heading="Platform" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>Dashboard</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group heading="Management" class="grid">
                    {{-- <flux:navlist.item icon="user" :href="route('admin.index')" :current="request()->routeIs('admin.index')" wire:navigate>Admin</flux:navlist.item> --}}
                    <flux:navlist.item icon="user-group" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>Manage Users</flux:navlist.item>
                    <flux:navlist.item icon="user-circle" :href="route('teachers.index')" :current="request()->routeIs('teachers.index')" wire:navigate>Manage Teachers</flux:navlist.item>
                    <flux:navlist.item icon="user-plus" :href="route('teachers.create')" :current="request()->routeIs('teachers.create')" wire:navigate>Create Teacher</flux:navlist.item>
                    <flux:navlist.item icon="academic-cap" :href="route('students.index')" :current="request()->routeIs('students.index')" wire:navigate>Manage Students</flux:navlist.item>
                    <flux:navlist.item icon="academic-cap" :href="route('students.create')" :current="request()->routeIs('students.create')" wire:navigate>Add Student</flux:navlist.item>
                    <flux:navlist.item icon="building-library" :href="route('classes.index')" :current="request()->routeIs('classes.index')" wire:navigate>Manage Classes</flux:navlist.item>
                    <flux:navlist.item icon="building-library" :href="route('sinfs.create')" :current="request()->routeIs('sinfs.create')" wire:navigate>Create Class</flux:navlist.item>
                </flux:navlist.group>
                <flux:navlist.group heading="Finance" class="grid">
                    {{-- <flux:navlist.item icon="banknotes" :href="route('payment.index')" :current="request()->routeIs('payment.index')" wire:navigate>Student Payment</flux:navlist.item>
                    <flux:navlist.item icon="scale" :href="route('salaries.index')" :current="request()->routeIs('salaries.index')" wire:navigate>Teachers Salaries </flux:navlist.item> --}}
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    Repository
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                    Documentation
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-left text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-left text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item href="/settings/profile" icon="cog" wire:navigate>Settings</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        @filamentScripts()
        @vite('resources/css/app.css')
    </body>
</html>
