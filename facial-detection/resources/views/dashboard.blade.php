<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="container text-center max-w-x">

                    <h1>Área para o Dashboard - Pensar Depois</h1>
        
                </div>
            </div>
        </div>
    </div>

    @push('css')
        <style>
            a {
                text-decoration: none !important;
            }
        </style>
    @endpush
</x-app-layout>
