<div class="flex flex-col items-center gap-16 mb-16" id="quotation">
    <div class="w-full md:w-3/4 flex flex-col items-center justify-center gap-8">
        <div class="pretitle">
            <p>Contáctenos</p>
        </div>
        <h3 class="text-center">Estemos en contacto
        </h3>
        <p class="text-center">Seleccione el servicio que necesite y envíenos una consulta sin cargo. Respondemos en menos de 24 horas.</p>
    </div>
    
    <div class="w-full flex flex-col md:flex-row items-start gap-16">
        <form id="quotationForm" action="{{ route('quotation.store') }}" method="post" class="form w-full">
            @csrf
            <div class="flex flex-col gap-8 md:items-center">
                <div class="flex flex-col md:flex-row gap-8 w-full">
                    <div class="flex flex-col gap-6 w-full md:w-1/2">
                        <input id="nameInput" type="text" name="name" placeholder="Su nombre" required >
                        <input id="emailInput" type="email" name="email" placeholder="Su correo electrónico" required >
                        <input id="phoneInput" type="tel" name="phone" placeholder="Su teléfono" required pattern="[0-9]{9}">
                        <textarea id="messageInput" name="message" placeholder="Déjenos un mensaje" rows="4" required ></textarea>
                        <div class="g-recaptcha" data-sitekey="6LcjHtMpAAAAAII4PAM3Vh2hT-0RDntu6B-3a_pH"></div>
                    </div>
                    <div class="flex gap-8 flex-wrap w-full md:w-1/2">
                        <div class="flex flex-wrap gap-4" required>
                            @foreach($tags as $tag)
                            <div class="checkbox-container">
                                <input type="checkbox" name="tags[]" value="{{ $tag->name }}" id="checkbox-{{ $tag->id }}" class="peer hidden">
                                <label for="checkbox-{{ $tag->id }}" class="block bg-slate-100 px-4 py-2 rounded-full text-xs dark:bg-dark_gray">{{ $tag->name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <x-button id="subscribeBtn" type="submit">
                    <i class="fi fi-rr-arrow-right arrow-to-right"></i> <span>{{__('Enviar')}}</span>
                </x-button>
            </div>
            
        </form>
        <div id="successMessage" class="mx-auto" style="display: none;">
            <H4 class="text-center">Mensaje Enviado!</H4>
            <img src="{{ asset('storage/common/mensaje-enviado.gif')}}" alt="Mensaje enviado">
        </div>
        <div id="errorMessage" class="mx-auto" style="display: none;">
            El envío falló. Vuelva a intentar, por favor.
        </div>
    </div>
   
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('quotationForm');
        const successMessage = document.getElementById('successMessage');
        const errorMessage = document.getElementById('errorMessage');
        form.addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent default form submission behavior
        
            const name = document.getElementById('nameInput').value;
            const email = document.getElementById('emailInput').value;
            const phone = document.getElementById('phoneInput').value;
            const checkboxes = document.querySelectorAll('input[name="tags[]"]');
            let selectedTags = Array.from(checkboxes)
            .filter(i => i.checked)
            .map(i => i.value);
            const selectedServices = Array.from(checkboxes).some(checkbox => checkbox.checked);
                if (!selectedServices) {
                    alert('Seleccione al menos un servicio'); // Mostrar un alerta al usuario
                    return; // Detener el envío del formulario
                }
            const message = document.getElementById('messageInput').value;
            console.log(selectedTags)
            console.log(typeof selectedTags)
            try {
                const response = await fetch('{{ route("quotation.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ name, email, phone, tags: selectedTags, message })
                });
                const data = await response.json();
                if (response.ok) {
                    successMessage.style.display = 'block';
                    form.style.display = 'none';
                } else {
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                errorMessage.style.display = 'block';
            }
        });
    });
</script>