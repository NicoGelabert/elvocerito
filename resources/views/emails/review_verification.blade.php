@component('mail::message')
# Hola {{ $name }},

Gracias por dejar tu review. Para confirmar que es tuya, por favor haz clic en el botón de abajo:

@component('mail::button', ['url' => $verificationUrl])
Verificar Review
@endcomponent

Si no realizaste esta acción, puedes ignorar este email.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
