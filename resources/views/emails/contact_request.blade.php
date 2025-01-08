<!DOCTYPE html>
<html>
<head>
    <title>Nuevo contacto</title>
</head>
<body>
    <h3>Nombre: {{ $contact->name }}</h3>
    <p>Email: {{ $contact->email }}.</p>
    <p>Teléfono {{ $contact->phone }}.</p>
    <p>Mensaje {{ $contact->message }}.</p>
</body>
</html>