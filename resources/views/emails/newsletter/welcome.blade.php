<!DOCTYPE html>
<html>
<body style="font-family:Arial;background:#f4f4f4;padding:40px">

<table width="100%" style="max-width:600px;background:white;margin:auto;padding:30px;border-radius:8px">

<tr>
<td align="center">

<h1 style="color:#111">Bienvenido 🎉</h1>

<p style="color:#555;font-size:16px">
Gracias por suscribirte a nuestro newsletter.
</p>

<a href="{{ $confirmUrl }}"
   style="background:#000;color:white;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;margin-top:20px">
Confirmar suscripción
</a>

{{-- FOOTER --}}
<p style="margin-top:40px;font-size:12px;color:#999">
Si no deseas recibir más correos:
</p>

<a href="{{ $unsubscribeUrl }}"
   style="color:#999;font-size:12px;text-decoration:underline;">
Cancelar suscripción
</a>

</td>
</tr>

</table>

</body>
</html>
