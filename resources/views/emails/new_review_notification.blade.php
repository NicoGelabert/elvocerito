@component('mail::message')
# Nueva review para {{ $productName }}

Se ha recibido una nueva review:

**Nombre:** {{ $review->name }} {{ $review->last_name }}  
**Email:** {{ $review->email }}  
**Rating:** {{ $review->rating }}  
**Título:** {{ $review->title }}
**Comentario:**  
{{ $review->comment }}

@component('mail::button', ['url' => url('/admin/reviews')])
Ver en el panel de administración
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
