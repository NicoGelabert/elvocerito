<x-app-demo>
    <div class="cartview flex flex-col justify-start lg:w-2/3 xl:w-2/3 mx-auto min-h-screen pt-32 pb-16 px-3">
        <h1 class="text-3xl mb-6">{{__('Your Cart Items')}}</h1>

        <div x-data="{
            cartItems: {{
                json_encode(
                    $products->map(fn($product) => [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'title' => $product->title,
                        'price' => $product->prices->first()->number,
                        'quantity' => $cartItems[$product->id]['quantity'],
                        'href' => route('product.view', [$product->categories->first()->slug, $product->slug]),
                        'removeUrl' => route('cart.remove', $product),
                        'updateQuantityUrl' => route('cart.update-quantity', $product)
                    ])
                )
            }},
            get cartTotal() {
                return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2)
            },
        }" class="bg-white p-4 rounded-lg shadow">
            <!-- Product Items -->
            <template x-if="cartItems.length">
                <div class="flex flex-col gap-4">
                    <!-- Product Item -->
                    <template x-for="product of cartItems" :key="product.id">
                        <div x-data="productItem(product)">
                            <div
                                class="w-full flex gap-4 flex-1">
                                <a :href="product.href"
                                   class="w-16 h-auto flex items-start overflow-hidden">
                                    <img :src="product.image" class="object-contain" alt=""/>
                                </a>
                                <div class="flex flex-col justify-between flex-1">
                                    <div class="flex flex-wrap gap-2 justify-between">
                                        <h6 x-text="product.title"></h6>
                                        <span class="text-sm font-semibold">
                                            $<span x-text="product.price"></span>
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            Qty:
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16"
                                            />
                                        </div>
                                        <a
                                            href="#"
                                            @click.prevent="removeItemFromCart()"
                                            class="remove text-purple-600 hover:text-purple-500"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512" fill="current">
                                                <path d="M170.5 51.6L151.5 80h145l-19-28.4c-1.5-2.2-4-3.6-6.7-3.6H177.1c-2.7 0-5.2 1.3-6.7 3.6zm147-26.6L354.2 80H368h48 8c13.3 0 24 10.7 24 24s-10.7 24-24 24h-8V432c0 44.2-35.8 80-80 80H112c-44.2 0-80-35.8-80-80V128H24c-13.3 0-24-10.7-24-24S10.7 80 24 80h8H80 93.8l36.7-55.1C140.9 9.4 158.4 0 177.1 0h93.7c18.7 0 36.2 9.4 46.6 24.9zM80 128V432c0 17.7 14.3 32 32 32H336c17.7 0 32-14.3 32-32V128H80zm80 64V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16zm80 0V400c0 8.8-7.2 16-16 16s-16-7.2-16-16V192c0-8.8 7.2-16 16-16s16 7.2 16 16z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!--/ Product Item -->
                            <hr class="my-5"/>
                        </div>
                    </template>
                    <!-- Product Item -->

                    <div class="pt-4 flex flex-col md:items-end">
                        <div class="w-full flex justify-between">
                            <span class="font-semibold">Subtotal</span>
                            <span id="cartTotal" class="text-xl" x-text="`$${cartTotal}`"></span>
                        </div>
                        <p class="text-gray-500 mb-6">
                            {{__('Shipping and taxes calculated at checkout.')}}
                        </p>
                        @if ($user && !in_array($user->id, $customerIDs))
                            @if ($user->id)
                                <a
                                    href="{{ route('profile') }}"
                                    class="btn-secondary w-auto py-3 text-lg"
                                >
                                    {{ __('Dirección de envío') }}
                                </a>
                            @endif
                        @else
                            <form action="{{route('cart.checkout')}}" method="post">
                                @csrf
                                <button type="submit" class="btn-primary w-auto py-3 text-lg">
                                    {{__('Proceed to Checkout')}}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <!--/ Product Items -->
            </template>
            <template x-if="!cartItems.length">
                <div class="text-center py-8 text-gray-500">
                    You don't have any items in cart
                </div>
            </template>

        </div>
        
    </div>
</x-app-demo>
