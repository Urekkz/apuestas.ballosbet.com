@extends($activeTemplate . 'layouts.app')
@section('content')
    @yield('frontend')
    @include($activeTemplate . 'partials.footer')
@endsection