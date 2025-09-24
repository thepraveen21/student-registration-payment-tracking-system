@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-8">
    <div class="py-8">
        <div>
            <h2 class="text-2xl font-semibold leading-tight">Settings</h2>
        </div>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <div class="w-full">
                            <h3 class="text-lg font-semibold">Institution Information</h3>
                            <div class="mt-4">
                                <label for="institution_name" class="block text-sm font-medium text-gray-700">Institution Name</label>
                                <input type="text" name="institution_name" id="institution_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['institution_name'] ?? '' }}">
                            </div>
                            <div class="mt-4">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ $settings['address'] ?? '' }}</textarea>
                            </div>
                            <div class="mt-4">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" id="phone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['phone'] ?? '' }}">
                            </div>
                            <div class="mt-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['email'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <div class="w-full">
                            <h3 class="text-lg font-semibold">Payment Configuration</h3>
                            <div class="mt-4">
                                <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                <input type="text" name="currency" id="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['currency'] ?? '' }}">
                            </div>
                            <div class="mt-4">
                                <label for="payment_gateway" class="block text-sm font-medium text-gray-700">Payment Gateway</label>
                                <input type="text" name="payment_gateway" id="payment_gateway" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['payment_gateway'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <div class="w-full">
                            <h3 class="text-lg font-semibold">Student Registration Settings</h3>
                            <div class="mt-4">
                                <label for="enable_registration" class="block text-sm font-medium text-gray-700">Enable Registration</label>
                                <select name="enable_registration" id="enable_registration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="1" {{ (isset($settings['enable_registration']) && $settings['enable_registration'] == 1) ? 'selected' : '' }}>Enable</option>
                                    <option value="0" {{ (isset($settings['enable_registration']) && $settings['enable_registration'] == 0) ? 'selected' : '' }}>Disable</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="default_course" class="block text-sm font-medium text-gray-700">Default Course</label>
                                <input type="text" name="default_course" id="default_course" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ $settings['default_course'] ?? '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
