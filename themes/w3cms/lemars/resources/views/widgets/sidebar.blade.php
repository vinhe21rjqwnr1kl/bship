
@if (!empty(config('Widget.show_sidebar')))
<div class="col-xl-3 col-lg-4 col-md-5 col-sm-12 col-12">
    <div class="side-bar p-l15 m-b0 sticky-top">

        {{-- Widget-Search --}}
        {!! DzHelper::SearchWidget(); !!}
        {{-- Widget-Search --}}

        {{-- recent-blogs --}}
        <div class="widget recent-posts-entry  mb-4">
            <h6 class="widget-title"><span>{{ __('Recent Posts') }}</span></h6>
        </div>
        {!! DzHelper::recentBlogs( array('limit'=>3, 'order'=>'asc', 'orderby'=>'created_at') ); !!}
        {{-- recent-blogs --}}

        {{-- recent-categories --}}
        {!! DzHelper::categoryBlogs( array('limit'=>4, 'order'=>'asc', 'orderby'=>'title')); !!}
        {{-- recent-categories --}}
        
        {{-- recent-archives --}}
        {!! DzHelper::archiveBlogs(); !!}
        {{-- recent-archives --}}

        {{-- BlogTags --}}
        {!! DzHelper::BlogTags(); !!}
        {{-- BlogTags --}}
    </div>
</div>
@endif