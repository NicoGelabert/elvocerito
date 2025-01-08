<x-app-demo>
    <div class="flex justify-center items-center backlogin py-32">
        <div class="bg-form">
            <form
                action="{{ route('register') }}"
                method="post"
                class="max-w-[700px] mx-auto p-6 md:p-12"
            >
                @csrf
        
                <div class="title mb-8 ">
                    <h3>{{ __('Create an account')}}</h3>
                </div>
                
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')"/>
        
                <div class="mb-4">
                    <x-input placeholder="{{ __('Your name')}}" type="text" name="name" :value="old('name')"  class="w-full account"/>
                </div>
                <div class="mb-4">
                    <x-input placeholder="{{ __('Your email')}}" type="email" name="email" :value="old('email')" class="w-full account" />
                </div>
                <div class="mb-4">
                    <x-input placeholder="{{ __('Password')}}" type="password" name="password" class="w-full account"/>
                </div>
                <div class="mb-4">
                    <x-input placeholder="{{ __('Repeat password')}}" type="password" name="password_confirmation" class="w-full account"/>
                </div>
        
                <div class="flex flex-col">
                    <div class="">
                        <button
                            class="btn-primary w-full"
                        >
                            {{ __('Sign up')}}
                        </button>
                    </div>
                    <hr class="my-8 h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-25 dark:opacity-100" />
                    <div class="flex flex-col gap-4 items-center">
                        <p class="small font-bold">Si ya tienes cuenta</p>
                        <a
                            href="{{ route('login') }}"
                            class="btn-secondary w-full block"
                        >
                            {{ __('Login')}}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-demo>
