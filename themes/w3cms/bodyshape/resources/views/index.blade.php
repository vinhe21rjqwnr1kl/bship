@if(config('Reading.show_on_front') == 'Page')
    @include('page')
@else
    @include('blog')
@endif
