@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{ activeTab: 'general' }">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">System Settings</h1>
            <p class="text-gray-500 mt-1">Configure your POS system preferences and global configurations.</p>
        </div>
        
        <!-- Category Selector (Dropdown) -->
        <div class="relative w-full md:w-72">
            <label class="block text-xs font-bold text-indigo-600 uppercase tracking-widest mb-1.5 ml-1">Select Category</label>
            <select 
                x-model="activeTab"
                class="w-full bg-white border-gray-200 rounded-2xl py-3.5 pl-4 pr-10 text-sm font-bold text-gray-700 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all appearance-none cursor-pointer"
            >
                <option value="general"> General Settings</option>
                <option value="pos"> POS Settings</option>
                <option value="invoice"> Invoice Settings</option>
                <option value="tax"> Tax Settings</option>
                <option value="email"> Email Settings</option>
                <option value="printer"> Printer Settings</option>
                <option value="notifications"> Notifications</option>
                <option value="security"> Security Settings</option>
                <option value="maintenance"> Maintenance</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pt-6 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-indigo-100/50 border border-gray-100 overflow-hidden">
        <!-- Content Area -->
        <div class="p-8 md:p-12">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
                @csrf
                
                <!-- General Settings -->
                <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">General Settings</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Store Name</label>
                            <input type="text" name="store_name" value="{{ $settings['store_name'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Company Name</label>
                            <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Email Address</label>
                            <input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Phone Number</label>
                            <input type="text" name="phone" value="{{ $settings['phone'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Address</label>
                            <textarea name="address" rows="3" class="w-full bg-gray-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">{{ $settings['address'] ?? '' }}</textarea>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">GST/VAT Number</label>
                            <input type="text" name="vat_number" value="{{ $settings['vat_number'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Currency</label>
                            <select name="currency" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                                <option value="USD" {{ ($settings['currency'] ?? '') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                                <option value="INR" {{ ($settings['currency'] ?? '') == 'INR' ? 'selected' : '' }}>INR (₹)</option>
                                <option value="EUR" {{ ($settings['currency'] ?? '') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                            </select>
                        </div>
                    </div>

                    <!-- Logo Uploads -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-10">
                        <div class="p-6 bg-gray-50 rounded-[2rem] border border-dashed border-gray-200">
                            <label class="text-xs font-bold text-gray-500 uppercase mb-4 block">Store Logo</label>
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-32 h-32 rounded-3xl bg-white shadow-sm flex items-center justify-center overflow-hidden border border-gray-100">
                                    @if(isset($settings['store_logo']))
                                        <img src="{{ asset('storage/'.$settings['store_logo']) }}" class="w-full h-full object-contain p-2">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <input type="file" name="store_logo" class="text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                            </div>
                        </div>
                        <div class="p-6 bg-gray-50 rounded-[2rem] border border-dashed border-gray-200">
                            <label class="text-xs font-bold text-gray-500 uppercase mb-4 block">Favicon</label>
                            <div class="flex flex-col items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-white shadow-sm flex items-center justify-center overflow-hidden border border-gray-100">
                                    @if(isset($settings['favicon']))
                                        <img src="{{ asset('storage/'.$settings['favicon']) }}" class="w-full h-full object-contain p-1">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <input type="file" name="favicon" class="text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-all cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- POS Settings -->
                <div x-show="activeTab === 'pos'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">POS Interface Settings</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @php
                            $pos_toggles = [
                                ['id' => 'enable_barcode', 'title' => 'Barcode Scanner', 'desc' => 'Allow using barcode scanner in POS'],
                                ['id' => 'enable_sound', 'title' => 'Sound on Scan', 'desc' => 'Play beep sound when scanning'],
                                ['id' => 'auto_focus', 'title' => 'Auto Focus Search', 'desc' => 'Automatically focus on search input'],
                                ['id' => 'auto_print', 'title' => 'Auto Print Invoice', 'desc' => 'Print immediately after sale'],
                            ];
                        @endphp

                        @foreach($pos_toggles as $toggle)
                        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem] border border-transparent hover:border-indigo-100 hover:bg-white transition-all group">
                            <div>
                                <p class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $toggle['title'] }}</p>
                                <p class="text-xs text-gray-500">{{ $toggle['desc'] }}</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="{{ $toggle['id'] }}" value="0">
                                <input type="checkbox" name="{{ $toggle['id'] }}" value="1" {{ ($settings[$toggle['id']] ?? '') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Other sections... (Reduced for brevity but including all required sections) -->
                
                <!-- Invoice Settings -->
                <div x-show="activeTab === 'invoice'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Invoice Settings</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Invoice Type</label>
                            <select name="invoice_type" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                                <option value="a4" {{ ($settings['invoice_type'] ?? '') == 'a4' ? 'selected' : '' }}>Standard A4</option>
                                <option value="thermal" {{ ($settings['invoice_type'] ?? '') == 'thermal' ? 'selected' : '' }}>Thermal Receipt (80mm)</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Invoice Prefix</label>
                            <input type="text" name="invoice_prefix" value="{{ $settings['invoice_prefix'] ?? 'INV-' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="md:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Invoice Footer Note</label>
                            <textarea name="invoice_footer" rows="2" class="w-full bg-gray-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">{{ $settings['invoice_footer'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Tax Settings -->
                <div x-show="activeTab === 'tax'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Tax Configurations</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem]">
                            <div>
                                <p class="font-bold text-gray-800">Enable Global Tax</p>
                                <p class="text-xs text-gray-500">Apply tax to all sales</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="enable_tax" value="0">
                                <input type="checkbox" name="enable_tax" value="1" {{ ($settings['enable_tax'] ?? '') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Default Tax Rate (%)</label>
                            <input type="number" name="default_tax" value="{{ $settings['default_tax'] ?? '0' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div x-show="activeTab === 'email'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Email SMTP Settings</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">SMTP Host</label>
                            <input type="text" name="smtp_host" value="{{ $settings['smtp_host'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">SMTP Port</label>
                            <input type="text" name="smtp_port" value="{{ $settings['smtp_port'] ?? '587' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">SMTP Username</label>
                            <input type="text" name="smtp_username" value="{{ $settings['smtp_username'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">SMTP Password</label>
                            <input type="password" name="smtp_password" value="{{ $settings['smtp_password'] ?? '' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                    </div>
                </div>

                <!-- Printer Settings -->
                <div x-show="activeTab === 'printer'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Printer & Hardware</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Printer Connection</label>
                            <select name="printer_connection" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                                <option value="browser" {{ ($settings['printer_connection'] ?? '') == 'browser' ? 'selected' : '' }}>Browser Default</option>
                                <option value="network" {{ ($settings['printer_connection'] ?? '') == 'network' ? 'selected' : '' }}>Network / IP Printer</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Thermal Paper Width</label>
                            <select name="paper_width" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                                <option value="80" {{ ($settings['paper_width'] ?? '') == '80' ? 'selected' : '' }}>80mm</option>
                                <option value="58" {{ ($settings['paper_width'] ?? '') == '58' ? 'selected' : '' }}>58mm</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Notifications -->
                <div x-show="activeTab === 'notifications'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Notification Alerts</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="space-y-6">
                        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem]">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-orange-50 text-orange-600 rounded-2xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.268 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                </div>
                                <p class="font-bold text-gray-800">Low Stock Alert</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="low_stock_alert" value="0">
                                <input type="checkbox" name="low_stock_alert" value="1" {{ ($settings['low_stock_alert'] ?? '') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Security Settings -->
                <div x-show="activeTab === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Security & Access</h2>
                        </div>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-2xl hover:bg-indigo-700 transition-all font-bold shadow-lg shadow-indigo-200">Save Changes</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-gray-500 uppercase ml-1">Session Timeout (min)</label>
                            <input type="number" name="session_timeout" value="{{ $settings['session_timeout'] ?? '120' }}" class="w-full bg-gray-50 border-transparent rounded-2xl py-3.5 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        </div>
                        <div class="flex items-center justify-between p-6 bg-gray-50 rounded-[2rem]">
                            <p class="font-bold text-gray-800">Force Two-Factor</p>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="force_2fa" value="0">
                                <input type="checkbox" name="force_2fa" value="1" {{ ($settings['force_2fa'] ?? '') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Maintenance -->
                <div x-show="activeTab === 'maintenance'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4" x-transition:enter-end="opacity-100 transform translate-y-0" x-cloak class="space-y-8">
                    <div class="flex justify-between items-center pb-6 border-b border-gray-50">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Maintenance Tools</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="p-8 bg-indigo-50 rounded-[2.5rem] border border-indigo-100">
                            <h3 class="font-bold text-indigo-900 mb-2">System Cache</h3>
                            <p class="text-sm text-indigo-700 mb-6">Clear all cached views, routes, and application data.</p>
                            <button type="button" 
                                    @click="fetch('{{ route('settings.clear-cache') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(r => r.json()).then(d => toastr.success(d.message))"
                                    class="w-full bg-indigo-600 text-white px-4 py-3.5 rounded-2xl text-sm font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                                Clear Cache Now
                            </button>
                        </div>
                        <div class="p-8 bg-gray-50 rounded-[2.5rem] border border-gray-200">
                            <h3 class="font-bold text-gray-900 mb-2">Clean Logs</h3>
                            <p class="text-sm text-gray-600 mb-6">Wipe out the system log files to start troubleshooting fresh.</p>
                            <button type="button" 
                                    @click="fetch('{{ route('settings.clear-logs') }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(r => r.json()).then(d => toastr.success(d.message))"
                                    class="w-full bg-gray-800 text-white px-4 py-3.5 rounded-2xl text-sm font-bold hover:bg-gray-900 transition-all shadow-lg shadow-gray-200">
                                Clear System Logs
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    /* Custom styling for the dropdown to make it look premium */
    select {
        background-image: none !important;
    }
</style>
@endsection
