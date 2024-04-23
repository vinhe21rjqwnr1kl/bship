<div class="widget widget_categories">
    <div class="widget-title">
        <h4 class="title">{{ __('Categories') }}</h4>
    </div>
    @if($blogcategories->isNotEmpty())
        <ul>
            @foreach($blogcategories as $blogcategory)
                <li class="cat-item"><a href="{{ DzHelper::laraBlogCategoryLink($blogcategory->id) }}">{{ $blogcategory->title }} </a> {{ $blogcategory->blog_count; }} </li>
            @endforeach
        </ul>
    @else
        <p>{{ __('No record found.') }}</p>
    @endif
</div>