@include('layouts.includes.head')
<body>
    <div class="container h-100 " style="box-shadow: 0 0 1px rgb(90, 88, 88); background:#f4f4f4">
        @include('layouts.frontend.header')
        @yield('content')
    </div>
</body>
@include('layouts.includes.footer')