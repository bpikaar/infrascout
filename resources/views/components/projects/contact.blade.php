@props([
    'project'
])
<div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('project.contact_section') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Contact with autocomplete -->
        <div class="relative">
            <x-input-label for="contact" :value="__('project.contact')" />
            <input type="hidden" id="contact_id" name="contact_id" value="{{ old('contact_id') ?? $project->contact_id ?? '' }}">
            <x-text-input id="contact"
                          class="block mt-1 w-full"
                          type="text"
                          name="contact"
                          :value="old('contact') ?? ($project->contact?->name ?? '')"
                          autocomplete="off"
                          required />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />

            <!-- Suggestions -->
            <div id="contact-suggestions" class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border dark:text-white border-gray-200 dark:border-gray-700 rounded-md shadow-lg hidden"></div>
        </div>

        <!-- Phone (optional) -->
        <div>
            <x-input-label for="phone" :value="__('project.phone_optional')" />
            <x-text-input id="phone"
                          class="block mt-1 w-full"
                          type="text"
                          name="phone"
                          :value="old('phone') ?? ($project->contact?->phone ?? '')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Mail (optional) -->
        <div>
            <x-input-label for="mail" :value="__('project.mail_optional')" />
            <x-text-input id="mail"
                          class="block mt-1 w-full"
                          type="email"
                          name="mail"
                          :value="old('mail') ?? ($project->contact?->email ?? '')" />
            <x-input-error :messages="$errors->get('mail')" class="mt-2" />
        </div>

        <!-- Address (optional) -->
        <div class="md:col-span-2">
            <x-input-label for="address" :value="__('project.address_optional')" />
            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address') ?? ($project->contact?->address ?? '') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Contact autocomplete
        const contactInput = document.getElementById('contact');
        const contactIdInput = document.getElementById('contact_id');
        const phoneInput = document.getElementById('phone');
        const mailInput = document.getElementById('mail');
        const addressInput = document.getElementById('address');
        const suggestionsBox = document.getElementById('contact-suggestions');

        let debounceTimer;
        function hideSuggestions() {
            suggestionsBox.classList.add('hidden');
            suggestionsBox.innerHTML = '';
        }
        function showSuggestions(items) {
            if (!items.length) { hideSuggestions(); return; }
            suggestionsBox.innerHTML = items.map(item => `
                        <button type="button" data-id="${item.id}" class="w-full text-left px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <div class="font-medium">${item.name}</div>
                            <div class="text-xs text-gray-500">${item.email ?? ''} ${item.phone ? '• ' + item.phone : ''}</div>
                        </button>
                    `).join('');
            suggestionsBox.classList.remove('hidden');

            Array.from(suggestionsBox.querySelectorAll('button[data-id]')).forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    const item = items.find(x => String(x.id) === String(id));
                    if (!item) return;
                    contactIdInput.value = item.id;
                    contactInput.value = item.name;
                    phoneInput.value = item.phone ?? '';
                    mailInput.value = item.email ?? '';
                    addressInput.value = item.address ?? '';
                    hideSuggestions();
                });
            });
        }
        function searchContacts(q) {
            if (!q || q.length < 2) { hideSuggestions(); return; }
            // Clear current selected id when user types
            contactIdInput.value = '';
            fetch(`{{ route('contacts.search') }}?q=${encodeURIComponent(q)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(r => r.ok ? r.json() : [])
                .then(data => showSuggestions(data))
                .catch(() => hideSuggestions());
        }
        contactInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => searchContacts(contactInput.value.trim()), 200);
        });
        contactInput.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                hideSuggestions();
            }
        });
        document.addEventListener('click', (e) => {
            if (!suggestionsBox.contains(e.target) && e.target !== contactInput) {
                hideSuggestions();
            }
        });
    </script>
@endpush
