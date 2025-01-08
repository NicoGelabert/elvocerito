<!DOCTYPE html>
<html>
<head>
    <title>Pedido de Cotización</title>
</head>
<body>
    <h3>Nombre: {{ $quotation->name }}</h3>
    <p>Consulta sobre:</p>
    <ul>
        @foreach ($quotation->tags as $tag)
            <li>{{ $tag }}</li>
        @endforeach
    </ul>
    <p>Email: {{ $quotation->email }}.</p>
    <p>Teléfono {{ $quotation->phone }}.</p>
</body>
</html>