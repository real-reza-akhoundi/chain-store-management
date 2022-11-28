<header class="{{ config('backpack.base.header_class') }}">
  {{-- Logo --}}

  <a class="navbar-brand" href="{{ url(config('backpack.base.home_link')) }}" title="{{ config('backpack.base.project_name') }}">
    {!! config('backpack.base.project_logo') !!}
  </a>
 

  @include(backpack_view('inc.menu'))
</header>
