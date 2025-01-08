<x-app-demo>
    <div class="">
        @foreach($categories as $category)
            <div class="">
                <a href="{{ route('category.view', $category->slug) }}">
                    <h2>{{__($category->title)}}</h2>
                </a>
            </div>
        @endforeach
    </div>
</x-app-demo>