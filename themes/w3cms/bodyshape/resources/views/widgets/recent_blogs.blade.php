<div class="widget recent-posts-entry">
    <div class="widget-title">
        <h4 class="title">{{ __('Recent Post') }}</h4>
        
    </div>
    <div class="widget-post-bx">
        @forelse($blogs as $blog)
            <div class="widget-post clearfix">
                <div class="dz-media"> 
                    @if(optional($blog->feature_img)->value)
                        <img src="{{ asset('storage/blog-images/'.$blog->feature_img->value) }}" alt="{{ __('Blog Image') }}" width="200" height="143">
                    @else
                        <img src="{{ asset('images/noimage.jpg') }}" alt="{{ __('Blog Image') }}" width="200" height="143">
                    @endif
                </div>
                <div class="dz-info">
                    @php
                        if($blog->visibility != 'Pu'){
                            $blog_visibility = $blog->visibility == 'Pr' ? __('Private: ') : __('Protected: ') ;
                        }else {
                            $blog_visibility = '';
                        }

                    @endphp
                    <h6 class="post-title"><a href="{!! DzHelper::laraBlogLink($blog->id) !!}">{{ $blog_visibility }}{{ $blog->title }}</a></h6>
                    <div class="dz-meta">
                        <ul>
                            <li class="post-date"><a href="javascript:void(0);">{{ Carbon\Carbon::parse($blog->publish_on)->format('F j, Y') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
        <div class="col-md-12">{{ __('No record found.') }}</div>
        @endforelse
    </div>
</div>