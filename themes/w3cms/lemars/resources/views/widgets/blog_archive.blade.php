<div class="widget widget_categories">
    <div class="widget-title">
        <h6 class="widget-title"><span>{{ __('Archives') }}</span></h6>
    </div>
    <ul>
        @forelse($archives as $archive)
            <li><a href="{!! DzHelper::laraBlogArchiveLink($archive->year,$archive->month) !!}"> {{ $archive->month_name  }} {{ $archive->year }}</a>  {{ $archive->data  }}  </li>
        @empty
            <li class="col-md-12">{{ __('No record found.') }}</li>
        @endforelse
    </ul>

</div>