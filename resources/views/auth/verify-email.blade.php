<x-app-layout>
    <div class="h-screen flex justify-center items-center backlogin p-8">
        <div class="bg-form">
            <div class="max-w-[700px] mx-auto p-6 md:p-12">
                <div class="mb-4 text-sm text-gray-600">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>
    
                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif
    
                <div class="mt-4 flex flex-wrap items-center justify-between">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
    
                        <div>
                            <x-button>
                                {{ __('Resend Email') }}
                            </x-button>
                        </div>
                    </form>
    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
    
                        <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
