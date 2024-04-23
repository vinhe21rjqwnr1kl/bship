<div class="widget widget_tags">
    <h5 class="widget-title">{{ __('Tags') }}</h5>
    <div class="widget-tag-bx">
        @forelse($tags as $tag)
        <a href="{!! DzHelper::laraBlogTagLink($tag->id); !!}" class="btn bg-primary text-white mb-1">{{ $tag->title }}</a>
        @empty
        <div class="col-md-12">{{ __('No record founds') }}</div>
        @endforelse
    </div>
</div>