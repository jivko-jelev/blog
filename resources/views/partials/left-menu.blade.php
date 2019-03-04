<div class="col-sm-2" style="min-width: 100px; padding: 0; ">
    <div class="list-group" style="border-radius: 10px;">
        @foreach(App\Category::all() as $category)
            <a href="{{ strtolower(route('blogs.order1', $category->title)) }}{{ \App\Functions::withPath() }}" style="padding: 10px 10px;" class="list-group-item{{ \App\Functions::isActiveCurrentUri($category->title) }}">{{ $category->title }}
                <span class="badge">{{ count(App\Blog::where('category_id', $category->id)->get()) }}</span></a>
        @endforeach
    </div>
</div>