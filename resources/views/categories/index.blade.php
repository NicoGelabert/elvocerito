<x-app-layout>
    <div>
        <div>
            <h2>Explorá las categorías</h3>
        </div>
        <div>
            <ul>
                @foreach ($categories as $category)
                <li><a href="{{ route('categories.view', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>