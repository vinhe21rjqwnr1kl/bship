<div class="widget widget_categories">
    <div class="widget-title">
        <h4 class="title">{{ __('Categories') }}</h4>
    </div>
    <ul>
        @forelse($blogcategories as $blogcategory)
            <li class="cat-item"><a href="{!! DzHelper::laraBlogCategoryLink($blogcategory->id) !!}">{{ $blogcategory->title }} </a> {{ $blogcategory->blog_count; }} </li>
        @empty
            <li class="col-md-12">{{ __('No record found.') }}</li>
        @endforelse
    </ul>
</div>