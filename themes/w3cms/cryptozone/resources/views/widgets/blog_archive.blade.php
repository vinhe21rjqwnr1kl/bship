<div class="widget widget_categories">
    <div class="widget-title">
        <h4 class="title">{{ __('Archives') }}</h4>
    </div>
    @if($archives->isNotEmpty())
        <ul>
            @foreach($archives as $archive)
                <li><a href="{{ DzHelper::laraBlogArchiveLink($archive->year,$archive->month) }}"> {{ $archive->month_name  }} {{ $archive->year }}</a>  {{ $archive->data  }}  </li>
            @endforeach
        </ul>
    @else
        <p>{{ __('No record found.') }}</p>
    @endif
</div>