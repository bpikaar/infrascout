@props([
    'client' => null
])
<div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
    <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">{{ __('client.contact_section') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Contact with autocomplete -->
        <div class="relative">
            <x-input-label for="contact" :value="__('client.contact')" />
            <input type="hidden" id="contact_id" name="contact_id" value="{{ old('contact_id') ?? $client->contact_id ?? '' }}">
            <x-text-input id="contact"
                          class="block mt-1 w-full"
                          type="text"
                          name="contact"
                          :value="old('contact') ?? ($client->contact?->name ?? '')"
                          autocomplete="off"
                          required />
            <x-input-error :messages="$errors->get('contact')" class="mt-2" />

            <!-- Suggestions -->
            <div id="contact-suggestions" class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 border dark:text-white border-gray-200 dark:border-gray-700 rounded-md shadow-lg hidden"></div>
        </div>

        <!-- Phone (optional) -->
        <div>
            <x-input-label for="phone" :value="__('client.phone_optional')" />
            <x-text-input id="phone"
                          class="block mt-1 w-full"
                          type="text"
                          name="phone"
                          :value="old('phone') ?? ($client->contact?->phone ?? '')" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Mail (optional) -->
        <div>
            <x-input-label for="mail" :value="__('client.mail_optional')" />
            <x-text-input id="mail"
                          class="block mt-1 w-full"
                          type="email"
                          name="mail"
                          :value="old('mail') ?? ($client->contact?->email ?? '')" />
            <x-input-error :messages="$errors->get('mail')" class="mt-2" />
        </div>

        <!-- Street (optional) -->
        <div class="md:col-span-2">
            <x-input-label for="street" :value="__('client.street_optional')" />
            <x-text-input id="street"
                          class="block mt-1 w-full"
                          type="text"
                          name="street"
                          :value="old('street') ?? ($client->contact?->street ?? '')" />
            <x-input-error :messages="$errors->get('street')" class="mt-2" />
        </div>

        <!-- Zipcode (optional) -->
        <div>
            <x-input-label for="zipcode" :value="__('client.zipcode_optional')" />
            <x-text-input id="zipcode"
                          class="block mt-1 w-full"
                          type="text"
                          name="zipcode"
                          :value="old('zipcode') ?? ($client->contact?->zipcode ?? '')" />
            <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
        </div>

        <!-- City (optional) -->
        <div>
            <x-input-label for="city" :value="__('client.city_optional')" />
            <x-text-input id="city"
                          class="block mt-1 w-full"
                          type="text"
                          name="city"
                          :value="old('city') ?? ($client->contact?->city ?? '')" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
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
        const streetInput = document.getElementById('street');
        const zipcodeInput = document.getElementById('zipcode');
        const cityInput = document.getElementById('city');
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
                    streetInput.value = item.street ?? '';
                    zipcodeInput.value = item.zipcode ?? '';
                    cityInput.value = item.city ?? '';
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
