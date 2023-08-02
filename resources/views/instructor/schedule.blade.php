<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Schedule a Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 max-w-2xl text-gray-900 dark:text-gray-100">
                    <form action="{{ route('schedule.store') }}" method="POST" class="max-w-lg">
                        @csrf
                        <div class="space-y-6">
                            <div class="max-w-xl">
                                <label class="text-sm">Select a class type</label>
                                <select name="class_type_id" value="{{ old('class_type_id') }}"
                                    class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500 dark:bg-slate-600">
                                    <option disabled value="" {{ !old('class_type_id') ? 'selected' : '' }}>Select
                                        a Class</option>
                                    @foreach ($classTypes as $classType)
                                        <option value="{{ $classType->id }}"
                                            {{ old('class_type_id') == $classType->id ? 'selected' : '' }}>
                                            {{ $classType->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                @error('class_type_id')
                                    <div class="text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="flex gap-6">
                                <div class="flex-1">
                                    <label class="text-sm">Date</label>
                                    <input type="date" name="date" value="{{ old('date') }}"
                                        class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500 dark:bg-slate-600"
                                        min="{{ date('Y-m-d', strtotime('today')) }}">
                                </div>
                                <div class="flex-1">
                                    <label class="text-sm">Time</label>
                                    <select type="time" name="time"
                                        class="block mt-2 w-full border-gray-300 focus:ring-0 focus:border-gray-500 dark:bg-slate-600">
                                        <option disabled value="" {{ !old('time') ? 'selected' : '' }}>Select a
                                            time</option>
                                        <option value="05:00" {{ old('time') === '05:00' ? 'selected' : '' }}>5 am
                                        </option>
                                        <option value="06:00" {{ old('time') === '06:00' ? 'selected' : '' }}>6 am
                                        </option>
                                        <option value="07:00" {{ old('time') === '07:00' ? 'selected' : '' }}>7 am
                                        </option>
                                        <option value="08:00" {{ old('time') === '08:00' ? 'selected' : '' }}>8 am
                                        </option>
                                        <option value="17:00" {{ old('time') === '17:00' ? 'selected' : '' }}>5 pm
                                        </option>
                                        <option value="18:00" {{ old('time') === '18:00' ? 'selected' : '' }}>6 pm
                                        </option>
                                        <option value="19:00" {{ old('time') === '19:00' ? 'selected' : '' }}>7 pm
                                        </option>
                                        <option value="20:00" {{ old('time') === '20:00' ? 'selected' : '' }}>8 pm
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex gap-6">
                                @if ($errors->has('date') || $errors->has('time'))
                                    <div class="flex-1">
                                        @error('date')
                                            <div class="text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="flex-1">
                                        @error('time')
                                            <div class="text-sm text-red-600">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif
                                <div class="flex-2">
                                    @error('date_time')
                                        <div class="text-sm text-red-600">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <x-primary-button>Schedule</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
