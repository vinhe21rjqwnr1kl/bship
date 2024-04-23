@php
	$menu_class = !empty($menu_class) ? $menu_class : 'nav navbar-nav'; 
@endphp

<ul class="{{ $menu_class }}">
	@if ($menus)
		@foreach ($menus as $menuitem)
			<li>
				<a href="{{ $menuitem->link }}" {{ ($menuitem->menu_target == 1) ? 'target="_blank"' : '' ; }} class="{{ $menuitem->css_classes }}" title="{{ $menuitem->attribute }}">{{ $menuitem->title }}</a>
				@if ($menuitem->child_menu_items->isNotEmpty())
					@include('elements.nav_menu', ['menus' => $menuitem->child_menu_items, 'menu_class' => 'sub-menu'])
				@endif
			</li>
		@endforeach
	@endif
</ul>