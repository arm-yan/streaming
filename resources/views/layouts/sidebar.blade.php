@if (Auth::guest())
    @include('auth._login')
@else
    @include('user._menu')
@endif
