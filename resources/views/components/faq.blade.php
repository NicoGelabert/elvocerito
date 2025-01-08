<div id="faqs">
    <div class="flex flex-col w-full justify-between gap-8">
        <h3 class="text-center">{{__('Faq´s')}}</h3>
        <div class="w-full questions">
            @foreach ($faqs as $faq)
                <div class="border rounded-xl py-4 px-4 question" x-data="{expanded: false}">
                    <div class="flex w-full justify-between items-baseline">
                        <p class="small-text subtitle">{{ __($faq -> question)}}</p>
                        <p class="text-right">
                            <a
                                @click="expanded = !expanded"
                                href="javascript:void(0)"
                            >
                                <svg class="shrink-0 fill-primary" width="16" height="16" xmlns="http://www.w3.org/2000/svg">
                                    <rect y="7" width="16" height="2" rx="1" class="transform origin-center transition duration-200 ease-out" :class="{'!rotate-180': expanded}" />
                                    <rect y="7" width="16" height="2" rx="1" class="transform origin-center rotate-90 transition duration-200 ease-out" :class="{'!rotate-180': expanded}" />
                                </svg>
                            </a>
                        </p>
                    </div>
                    <div
                        x-show="expanded"
                        x-collapse.min.0
                        class="text-gray-500 dark:text-gray-300 wysiwyg-content"
                    >
                        <p class="small-text font-light pt-4">{{ __($faq -> answer)}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>