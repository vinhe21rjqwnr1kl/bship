<div class="widget style-1 sidebar-widget widget_block widget_search substitute-class">
    <form method="get" action="{{ route('permalink.search') }}" class="d-flex ">
        @csrf
        
        <div class="input-group d-flex">
            <input type="search" id="input_search" class="wp-block-search__input form-control" name="s" placeholder="{{ __('Search...') }}" required>
            <div class="input-group-append">
                <button name="submit" value="Submit" type="submit" class="btn">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </div>
            <div class="dzSubscribeMsg"></div>
        </div>
    </form>
</div>