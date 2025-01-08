@php
    $espStates = \App\Models\Country::where('code', 'esp')->value('states');
@endphp
<x-app-layout>
    <div x-data="{
            flashMessage: '{{\Illuminate\Support\Facades\Session::get('flash_message')}}',
            init() {
                if (this.flashMessage) {
                    setTimeout(() => this.$dispatch('notify', {message: this.flashMessage}), 200)
                }
            }
        }" class="mx-auto lg:w-3/3 lg:p-8 pt-24 lg:pt-32">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
            <div class="p-3 md:col-span-2 backprofile">
                <form x-data="{
                    countries: {{ json_encode($countries) }},
                    billingAddress: {{ json_encode([
                        'address1' => old('billing.address1', $billingAddress->address1),
                        'address2' => old('billing.address2', $billingAddress->address2),
                        'city' => old('billing.city', $billingAddress->city),
                        'state' => old('billing.state', $billingAddress->state),
                        'country_code' => old('billing.country_code', $billingAddress->country_code),
                        'zipcode' => old('billing.zipcode', $billingAddress->zipcode),
                    ]) }},
                    shippingAddress: {{ json_encode([
                        'address1' => old('shipping.address1', $shippingAddress->address1),
                        'address2' => old('shipping.address2', $shippingAddress->address2),
                        'city' => old('shipping.city', $shippingAddress->city),
                        'state' => old('shipping.state', $shippingAddress->state),
                        'country_code' => old('shipping.country_code', $shippingAddress->country_code),
                        'zipcode' => old('shipping.zipcode', $shippingAddress->zipcode),
                    ]) }},
                    get billingCountryStates() {
                        const country = this.countries.find(c => c.code === this.billingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    },
                    get shippingCountryStates() {
                        const country = this.countries.find(c => c.code === this.shippingAddress.country_code)
                        if (country && country.states) {
                            return JSON.parse(country.states);
                        }
                        return null;
                    }
                }" action="{{ route('profile.update') }}" method="post">
                    @csrf
                    <div class="title mb-4">
                        <h3>{{ __('Profile Details') }}</h3>
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="first_name"
                            value="{{old('first_name', $customer->first_name)}}"
                            placeholder="{{ __('First Name') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="last_name"
                            value="{{old('last_name', $customer->last_name)}}"
                            placeholder="{{ __('Last Name') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="email"
                            value="{{old('email', $user->email)}}"
                            placeholder="{{ __('Your email') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="mb-12">
                        <x-input
                            type="text"
                            name="phone"
                            value="{{old('phone', $customer->phone)}}"
                            placeholder="{{ __('Your phone') }}"
                            class="w-full account"
                        />
                    </div>
                   
                    <div class="title">
                        <h3>{{ __('Shipping Address') }}</h3>
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="shipping[address1]"
                            x-model="shippingAddress.address1"
                            placeholder="{{ __('Address') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div class="col-span-2">
                            <x-input
                                type="text"
                                name="shipping[address2]"
                                x-model="shippingAddress.address2"
                                placeholder="{{ __('Apartment') }}"
                                class="w-full account"
                            />
                        </div>
                        <div>
                            <x-input
                                name="shipping[zipcode]"
                                x-model="shippingAddress.zipcode"
                                type="text"
                                placeholder="{{ __('ZipCode') }}"
                                class="w-full account"
                            />
                        </div>
                    </div>
                    <div class="mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="shipping[city]"
                                x-model="shippingAddress.city"
                                placeholder="{{ __('City') }}"
                                class="w-full account"
                            />
                        </div>
                    </div>
                    <div class="mb-3">
    <x-input type="select"
             name="shipping[country_code]"
             x-model="shippingAddress.country_code"
             class="w-full account">
        <option value="">{{ __('Select Country') }}</option>
        <template x-for="country of countries" :key="country.code">
            <option :selected="country.code === 'esp'"
                    :value="country.code" x-text="country.name"></option>
        </template>
    </x-input>
</div>
<div class="mb-12">
    <template x-if="shippingAddress.country_code === 'esp'">
        <x-input type="select"
                 name="shipping[state]"
                 x-model="shippingAddress.state"
                 x-init="shippingAddress.state = 'MA'"
                 class="w-full account">
            <option value="">{{ __('Select State') }}</option>
            <template x-for="[code, state] of Object.entries(espStates)"
                      :key="code">
                <option :selected="code === 'MA'"
                        :value="code" x-text="state"></option>
            </template>
        </x-input>
    </template>
    <template x-if="shippingAddress.country_code !== 'esp'">
        <x-input
            type="text"
            name="shipping[state]"
            x-model="shippingAddress.state"
            placeholder="{{ __('State') }}"
            class="w-full account"
        />
    </template>
</div>

                    <div class="title mb-4">
                        <h3>{{ __('Billing Address') }}</h3>
                    </div>
                    <label for="sameAsShippingAddress" class="text-gray-700 flex items-center mb-8">
                        <input @change="$event.target.checked ? billingAddress = {...shippingAddress} : ''"
                                id="sameAsShippingAddress" type="checkbox"
                                class="mr-3 rounded border-gray-300 focus:ring-transparent formselect">
                                <span class="small-text">{{ __('Same as Shipping') }}</span>
                    </label>
                    <div class="mb-3">
                        <x-input
                            type="text"
                            name="billing[address1]"
                            x-model="billingAddress.address1"
                            placeholder="{{ __('Address') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-3">
                        <div class="col-span-2">
                            <x-input
                                type="text"
                                name="billing[address2]"
                                x-model="billingAddress.address2"
                                placeholder="{{ __('Apartment') }}"
                                class="w-full account"
                            />
                        </div>
                        <div>
                            <x-input
                                type="text"
                                name="billing[zipcode]"
                                x-model="billingAddress.zipcode"
                                placeholder="{{ __('ZipCode') }}"
                                class="w-full account"
                            />
                        </div>
                    </div>
                    <div class="mb-3">
                        <div>
                            <x-input
                                type="text"
                                name="billing[city]"
                                x-model="billingAddress.city"
                                placeholder="{{ __('City') }}"
                                class="w-full account"
                            />
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-input type="select"
                                    name="billing[country_code]"
                                    x-model="billingAddress.country_code"
                                    class="w-full account">
                            <option value="">{{ __('Select Country') }}</option>
                            <template x-for="country of countries" :key="country.code">
                                <option :selected="country.code === billingAddress.country_code"
                                        :value="country.code" x-text="country.name"></option>
                            </template>
                        </x-input>
                    </div>
                    <div class="mb-12">
                        <template x-if="billingCountryStates">
                            <x-input type="select"
                                        name="billing[state]"
                                        x-model="billingAddress.state"
                                        class="w-full account">
                                <option value="">{{ __('Select State') }}</option>
                                <template x-for="[code, state] of Object.entries(billingCountryStates)"
                                            :key="code">
                                    <option :selected="code === billingAddress.state"
                                            :value="code" x-text="state"></option>
                                </template>
                            </x-input>
                        </template>
                        <template x-if="!billingCountryStates">
                            <x-input
                                type="text"
                                name="billing[state]"
                                x-model="billingAddress.state"
                                placeholder="{{ __('State') }}"
                                class="w-full account"
                            />
                        </template>
                    </div>
                    <div>
                        <x-button class="btn-primary">{{ __('Update') }}</x-button>
                    </div>
                </form>
            </div>
            <div class="backprofile p-3">
                <form action="{{route('profile_password.update')}}" method="post">
                    @csrf
                    <div class="title mb-4">
                        <h3>{{ __('Update Password') }}</h3>
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="old_password"
                            placeholder="{{ __('Your current password') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password"
                            placeholder="{{ __('New password') }}"
                            class="w-full account"
                        />
                    </div>
                    <div class="mb-3">
                        <x-input
                            type="password"
                            name="new_password_confirmation"
                            placeholder="{{ __('Repeat new password') }}"
                            class="w-full account"
                        />
                    </div>
                    <x-button class="btn-primary">{{ __('Update') }}</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
    let espStates = {!! $espStates !!};
</script>