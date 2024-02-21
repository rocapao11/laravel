<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chirps') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('chirps.store')}}">
                        @csrf
                        <textarea name="message"
                                  class="block w-full rounded-md border-gray-300 bg-white shadow-sm transition-colors duration-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800 dark:text-white dark:focus:border-indigo-300 dark:focus:ring dark:focus:ring-indigo-200 dark:focus:ring-opacity-50"
                                  placeholder="{{ __('What\'s on your mind?') }}"
                        >{{  old('message')}}</textarea>
                        <x-input-error :messages="$errors->get('message')"
                            class="mt-2"
                        />
                        <x-primary-button class="mt-4">
                            {{ __('Chirp') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
            <div class="mt-6 bg-white dark:bg-gray-800 shadow-sm rounded-lg divide-y dark:divide-gray-900">
                @foreach($chirps as $chirp)
                    <div class="p-6 flex space-x-2">

                        <svg class="h-6 w-6 text-gray-600 dark:text-gray-400 -scale-x-100" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"></path>
                          </svg>

                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-gray-800 dark:text-gray-200">
                                        {{ $chirp->user->name }}
                                    </span>
                                    <small class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                    @unless($chirp->created_at->eq($chirp->updated_at))
                                        <small class="text-sm text-gray-600 dark:text-gray-400">&middot; {{__('edited')}}</small>
                                    @endunless

                                </div>
                            </div>
                            <p class="mt-4 text-lg text-gray-900 dark:text-gray-100">{{ $chirp->message }}</p>
                        </div>
                        @can ('update',$chirp)
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <button>
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"></path>
                                        </svg>
                                    </button>
                                </x-slot>
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                        {{ __('Edit Chirp') }}
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('chirps.destroy', $chirp)}}">
                                        @csrf @method('DELETE')
                                        <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                            {{ __('Delete Chirp') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
