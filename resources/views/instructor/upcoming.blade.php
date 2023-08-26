<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upcoming Classes') }}
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
                                    <span
                                        class="text-slate-600 dark:text-slate-200 text-sm">{{ $class->classType->minutes }}
                                        minutes</span>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-lg font-bold text-slate-600 dark:text-slate-200">
                                        {{ $class->date_time->format('g:i a') }}</p>
                                    <p class="text-sm text-slate-600 dark:text-slate-200">
                                        {{ $class->date_time->format('jS M') }}</p>
                                </div>
                            </div>
                            @can('delete', $class)
                                <div class="mt-1 text-right">
                                    <form method="post" action="{{ route('schedule.destroy', $class) }}">
                                        @csrf
                                        @method('delete')
                                        <x-danger-button class="px-3 py-1">Cancel</x-danger-button>
                                    </form>
                                </div>
                            @endcan
                        </div>
                    @empty
                        <div>
                            <p class="text-xl text-slate-600 dark:text-slate-200">You don't have any upcoming classes.
                            </p>
                            <a class="inline-block mt-6 underline text-sm text-slate-600 dark:text-slate-300 hover:text-slate-400"
                                href="{{ route('schedule.create') }}">
                                {{ __('Schedule now') }}
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
