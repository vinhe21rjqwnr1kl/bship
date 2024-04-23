<div class="widget">
    <div class="widget-title">
        <h4 class="title">{{ __('Search') }}</h4>
    </div>
    <div class="search-bx">
        <form action="{{ route('permalink.search') }}" role="search" method="get">
            <div class="input-group">
                <div class="input-skew">
                    <input name="s" class="form-control" placeholder="{{ __('Search..') }}" type="text" required>
                </div>
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary sharp radius-no"><i class="fa-solid fa-magnifying-glass scale3"></i></button>
                </span>
            </div>
        </form>
    </div>
</div>