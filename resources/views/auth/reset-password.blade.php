<x-app-layout>
    <div class="h-screen flex justify-center items-center backlogin p-8">
        <div class="bg-form">
            <form
            action="{{ route('password.update') }}"
            method="POST"
            class="max-w-[700px] mx-auto p-6 md:p-12"
            >
                @csrf
        
                <div class="title mb-8 ">
                    <h3>{{ __('Enter your new password') }}</h3>
                </div>
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
        
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
                <!-- Email Address -->
                <div>
                    <!-- <x-label for="email" :value="__('Email')" class="small-text mb-3"/> -->
        
                    <x-input id="email" class="w-full account" type="email" name="email" :value="old('email', $request->email)" required autofocus placeholder="{{ __('Your email') }}" />
                </div>
        
                <!-- Password -->
                <div class="mt-4">
                    <!-- <x-label for="password" :value="__('Password')" class="small-text mb-3" /> -->
        
                    <x-input id="password" class="w-full account" type="password" name="password" required placeholder="{{ __('Your password') }}"  />
                </div>
        
                <!-- Confirm Password -->
                <div class="mt-4">
                    <!-- <x-label for="password_confirmation" :value="__('Confirm Password')" class="small-text mb-3"/> -->
        
                    <x-input id="password_confirmation"  class="w-full account"
                    type="password"
                    name="password_confirmation" required placeholder="{{ __('Confirm your password') }}" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Reset password') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
