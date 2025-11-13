@php
    // Convert slot content to string
    $pageTitle = isset($title) && $title ? trim(strip_tags($title)) : null;
    $pageHeader = isset($header) && $header ? trim(strip_tags($header)) : 'Admin Dashboard';
@endphp

<x-app-layout :title="$pageTitle">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $pageHeader }}
            </h2>
            <a href="{{ url('/') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                View Website →
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Admin Navigation -->
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8 px-6">
                        <a href="{{ route('dashboard') }}" 
                           class="@if(request()->routeIs('dashboard')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.profile') }}" 
                           class="@if(request()->routeIs('admin.profile')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Profile
                        </a>
                        <a href="{{ route('admin.stats') }}" 
                           class="@if(request()->routeIs('admin.stats')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Stats
                        </a>
                        <a href="{{ route('admin.highlights') }}" 
                           class="@if(request()->routeIs('admin.highlights')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Highlights
                        </a>
                        <a href="{{ route('admin.awards') }}" 
                           class="@if(request()->routeIs('admin.awards')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Awards
                        </a>
                        <a href="{{ route('admin.testimonials') }}" 
                           class="@if(request()->routeIs('admin.testimonials')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Testimonials
                        </a>
                        <a href="{{ route('admin.contacts') }}" 
                           class="@if(request()->routeIs('admin.contacts')) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                            Contacts
                        </a>
                    </nav>
                </div>

                <!-- Page Content -->
                <div class="p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
