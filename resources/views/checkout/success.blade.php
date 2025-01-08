<x-app-layout>
    <x-confeti />
    <div class="h-screen flex items-center">
        <div class="w-[400px] mx-auto text-center">
            <h2>{{$customer->name}},</h2>
            <p>Your order has been completed!!</p>
            <p class="small font-bold">Your tracking code</p>
            <p>#00{{ $payment->id }}-{{ \Carbon\Carbon::parse($payment->created_at)->format('dm-Y') }}</p>
            <hr class="my-8 h-px border-t-0 bg-transparent bg-gradient-to-r from-transparent via-neutral-500 to-transparent opacity-25 dark:opacity-100" />
            <div class="flex justify-center gap-6">
                <a href="#" 
                data-payment-id="{{ $payment->id }}" 
                data-created-at="{{ \Carbon\Carbon::parse($payment->created_at)->format('dm-Y') }}" 
                onclick="openWhatsApp(this)"
                class="h-10 w-10 aspect-square rounded-md bg-black/5 p-2 ring-1 ring-black/10" >
                    <i class="flex text-2xl leading-none fi fi-brands-whatsapp"></i>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
<script>
function openWhatsApp(element) {
    var paymentId = element.dataset.paymentId;
    var createdAt = element.dataset.createdAt;
    var message = encodeURIComponent("Hola! hice un pedido. El número de seguimiento es: #00" + paymentId + "-" + createdAt);
    var whatsappLink = "https://wa.me/34623037048?text=" + message;
    
    window.open(whatsappLink, "_blank");
}
</script>