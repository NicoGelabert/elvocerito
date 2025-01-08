<x-app-layout>
    <div class="h-screen flex items-center">
        <div class="services-container">
            @foreach($services as $service)
                <div class="service-item" style="background-image:url({{ $service->image }})">
                    <a href="{{ route('service.view', $service->slug) }}">
                        <h1 class="text-white drop-shadow-md">{{ $service->title }}</h1>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

</x-app-layout>