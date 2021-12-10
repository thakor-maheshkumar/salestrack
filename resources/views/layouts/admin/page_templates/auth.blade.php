<div class="wrapper">

    @include('layouts.admin.navbars.auth')

    <div class="main-panel">
        @include('layouts.admin.navbars.navs.auth')
        @yield('content')
        @include('layouts.admin.footer')
    </div>
</div>
