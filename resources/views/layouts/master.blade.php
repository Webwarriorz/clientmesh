@include('layouts.header')
<div id="app">

    @include('layouts.nav')

    <main role="main" class="py-5 mt-5">
        @include('partial.flashMessage')
        @yield('content')
    </main>

</div>
@include('layouts.footer')