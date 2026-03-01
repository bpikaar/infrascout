@props(['id', 'name', 'label'])

<div class="mt-6 md:col-span-2 space-y-2">
    <x-input-label :for="$id" :value="$label" />
    <input type="file" id="{{ $id }}" name="{{ $name }}" accept="image/*,.heic" multiple class="block w-full text-sm text-gray-500 dark:text-gray-400
                  file:mr-4 file:py-2 file:px-4
                  file:rounded-md file:border-0
                  file:text-sm file:font-semibold
                  file:bg-indigo-50 file:text-indigo-700
                  hover:file:bg-indigo-100
                  dark:file:bg-indigo-900 dark:file:text-indigo-300">
    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Meerdere afbeeldingen mogelijk (JPG, PNG, HEIC)</p>
</div>