<x-app-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Book</h1>
        <p class="mt-2 text-gray-600">Update the details for "{{ $book->name }}".</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('books.update', $book) }}" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Book Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $book->name) }}" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe what this book will be used for...">{{ old('description', $book->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('books.destroy', $book) }}" onsubmit="return confirm('Are you sure you want to delete this book? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Delete Book
                        </button>
                    </form>

                    <div class="flex space-x-3">
                        <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <x-primary-button>
                            Update Book
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
