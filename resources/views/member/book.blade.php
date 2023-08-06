<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book a Class') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:bg-gray-800 max-w-2xl divide-y">
                    @forelse ($scheduledClasses as $class)
                        <div class="py-6">
                            <div class="flex gap-6 justify-between">
                                <div>
                                    <p class="text-2xl font-bold text-purple-700 dark:text-purple-200">
                                        {{ $class->classType->name }}</p>
                                    <p class="mt-2 text-lg text-slate-600 dark:text-slate-200">
                                        {{ $class->instructor->name }}</p>
                                    <p class="mt-2 mb-4 text-slate-600 dark:text-slate-200">
                                        {{ $class->classType->description }}</p>
                                    <span class="text-sm text-slate-600 dark:text-slate-200">
                                        {{ $class->classType->minutes }}
                                        minutes</span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-lg font-bold text-slate-600 dark:text-slate-200">
                                        {{ $class->date_time->format('g:i a') }}</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-200">
                                        {{ $class->date_time->format('jS M') }}</p>
                                </div>
                            </div>
                            <div class="mt-1 text-right">
                                <form method="post" action="{{ route('booking.store') }}">
                                    @csrf
                                    <input type="hidden" name="scheduled_class_id" value="{{ $class->id }}">
                                    <x-primary-button class="px-3 py-1">Book</x-primary-button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div>
                            <p class="text-xl text-slate-600 dark:text-slate-200">No upcoming classes. Please check back
                                later.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
