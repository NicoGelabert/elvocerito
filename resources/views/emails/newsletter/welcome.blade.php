<x-mail::message>
# ¡Bienvenido/a!

Gracias por suscribirte. Para empezar a recibir novedades, confirmá tu dirección de correo haciendo clic en el botón.

<x-mail::button :url="$confirmUrl" color="primary">
Confirmar suscripción
</x-mail::button>

Si no solicitaste esta suscripción, podés ignorar este mail o
[darte de baja]({{ $unsubscribeUrl }}) directamente.

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>