<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  {{-- <script src="https://unpkg.com/wavesurfer.js@2.2.1/dist/wavesurfer.min.js"></script> --}}
  {{-- <link rel="stylesheet" href="{{ URL::asset('build/assets/app.89ec1456.css') }}"> --}}
  @yield('head')
  <title>Research & Innovation - HUMIC RC</title>
</head>
<body class="font-poppins">
    <div class="w-full bg-red-primary py-1 fixed">
        <div class="flex justify-between px-10 items-center">
            <div class="text-xl font-bold w-2/12 text-white">Research and Innovation HUMIC RC</div>
            <div>a</div>
        </div>
    </div>
    <div class="flex min-h-screen pt-10">
        <x-sidebar/>
        <div class="w-10/12 bg-white-secondary px-10 pt-10">
            <div class="text-4xl font-bold mb-14">@yield('title')</div>
            @yield('content')
        </div>
    </div>
    {{-- @yield('content')
    @yield('script') --}}
</body>
@yield('script')
@vite('resources/js/app.js')
{{-- <script src="{{ URL::asset('build/assets/app.f40b63e3.js') }}"></script> --}}
</html>
