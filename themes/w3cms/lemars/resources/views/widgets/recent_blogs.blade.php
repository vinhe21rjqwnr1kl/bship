<div class="widget recent-posts-entry">
    <div class="widget-post-bx">
        @forelse($blogs as $blog)
        <div class="widget-post clearfix">
            <div class="dlab-post-media"> 
                @if(optional($blog->feature_img)->value)
                    <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}">
                @else
                    <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}">
                @endif
            </div>
            <div class="dlab-post-info">
                <div class="dlab-post-header">
                    <h6 class="post-title">
                        <a href="{{ DzHelper::laraBlogLink($blog->id) }}">{{ Str::limit($blog->title, 24, ' ...') }}</a>
                    </h6>
                </div>
                <div class="dlab-post-meta">
                    <ul>
                        <li class="post-date">{{ Carbon\Carbon::parse($blog->publish_on)->format('F j, Y') }}</li>
                    </ul>
                </div>
            </div>
        </div>
        @empty
        <div class="col-md-12">{{ __('No record found.') }}</div>
        @endforelse
    </div>
</div>