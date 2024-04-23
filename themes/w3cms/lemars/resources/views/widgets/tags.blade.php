<div class="widget widget_tag_cloud">
    <div class="widget-title">
        <h6 class="widget-title"><span>{{ __('Popular Tags') }}</span></h6>
    </div>
    <div class="tagcloud">
        @forelse($tags as $tag)
        <a href="{!! DzHelper::laraBlogTagLink($tag->id); !!}"><span>{{ $tag->title }}</span></a>
        @empty
        <div class="col-md-12">{{ __('No record found.') }}</div>
        @endforelse
    </div>
</div>