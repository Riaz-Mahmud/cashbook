<x-app-layout>
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Book</h1>
        <p class="mt-2 text-gray-600">Books help you organize transactions by project, department, or any category you choose.</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('books.store') }}" class="p-6 space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" value="Book Name" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name') }}" required autofocus placeholder="e.g., General Ledger, Marketing Campaign, Q4 Operations" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="description" value="Description (Optional)" />
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe what this book will be used for...">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    <p class="mt-2 text-sm text-gray-500">Provide a brief description to help you and your team understand the purpose of this book.</p>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </a>
                    <x-primary-button>
                        Create Book
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
