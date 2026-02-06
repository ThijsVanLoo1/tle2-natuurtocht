<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <a href="{{ route('admin.cards.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nieuwe Kaart
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Filters -->
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
                <form action="{{ route('admin.index') }}" method="GET"
                      class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="w-full md:w-1/4">
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Categorie</label>
                        <select name="category" id="category"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Alle Categorien</option>
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="w-full md:w-1/4">
                        <label for="season" class="block text-sm font-medium text-gray-700 mb-1">Seizoen</label>
                        <select name="season" id="season"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Alle seizoenen</option>
                            @foreach($seasons as $season)
                                <option
                                    value="{{ $season->id }}" {{ request('season') == $season->id ? 'selected' : '' }}>
                                    {{ $season->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 transition duration-150 ease-in-out">
                            Filter
                        </button>
                        @if(request('category') || request('season'))
                            <a href="{{ route('admin.index') }}"
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- List View (1x1) -->
            <div class="space-y-4">
                @forelse($cards as $card)
                    <div
                        class="bg-white overflow-hidden shadow-sm rounded-lg hover:shadow-md transition-shadow duration-300 flex flex-col sm:flex-row">

                        <!-- Image Section (Even smaller width on desktop) -->
                        <div class="relative w-full sm:w-24 h-48 sm:h-auto bg-gray-200 flex-shrink-0">
                            @if($card->image_url)
                                <img src="{{ asset('storage/' . $card->image_url) }}" alt="{{ $card->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-1 left-1">
                                <span
                                    class="px-1.5 py-0.5 text-[10px] font-bold text-white bg-black bg-opacity-50 rounded-full backdrop-blur-sm">
                                    {{ $card->category->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="p-4 flex-1 flex flex-col">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-lg font-bold text-gray-900">{{ $card->title }}</h3>
                                <div class="flex space-x-2 ml-4">
                                    <a href="{{ route('admin.cards.edit', $card) }}"
                                       class="text-gray-400 hover:text-indigo-600 transition-colors duration-200 p-1"
                                       title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.cards.destroy', $card) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this card?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1"
                                                title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <p class="text-gray-600 text-sm mb-2 flex-1">
                                {{ $card->description }}
                            </p>

                            <div class="flex items-center pt-2 border-t border-gray-100 mt-auto">
                                <div class="text-xs text-gray-500 flex items-center flex-wrap">
                                    <span class="mr-2 font-semibold">Seasons:</span>
                                    @if($card->seasons->isNotEmpty())
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($card->seasons as $season)
                                                <span
                                                    class="inline-block px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-xs">
                                                    {{ $season->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="italic">No seasons selected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No cards found</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            @if(request('category') || request('season'))
                                Try adjusting your filters.
                            @else
                                Get started by creating a new card.
                            @endif
                        </p>
                        <div class="mt-6">
                            @if(request('category') || request('season'))
                                <a href="{{ route('admin.index') }}"
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Clear Filters
                                </a>
                            @else
                                <a href="{{ route('admin.cards.create') }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Create New Card
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
