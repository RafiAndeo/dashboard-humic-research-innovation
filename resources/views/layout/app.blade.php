<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  {{-- <link rel="stylesheet" href="{{ URL::asset('build/assets/app.89ec1456.css') }}"> --}}
  @yield('head')
  <title>Research & Innovation - HUMIC RC</title>
</head>
<body class="font-poppins">
    <div class="w-full bg-red-primary py-1 fixed z-10">
        <div class="flex justify-between px-10 items-center">
            <div class="text-xl font-bold w-2/12 text-white">Research and Innovation HUMIC RC</div>
            @guest
            <a href="{{route('member.login_index')}}" class="rounded-md bg-blue-700 text-white hover:bg-blue-800 hover:text-white px-5 py-2">
                Login
            </a>
            @endguest
            @auth
            <div class="flex space-x-4 items-center">
                <div class="text-white font-medium">Halo,
                    <span class="underline">{{Auth::user()->nama}}</span>
                </div>
                <div class="rounded-md bg-white-secondary text-red-primary hover:bg-black/30 hover:text-white px-5 py-2">
                    <form action="{{route('member.logout')}}" method="POST">
                        @csrf
                        <button>Logout</button>
                    </form>
                </div>
            </div>
            @endauth
        </div>
    </div>
    <div class="flex min-h-screen pt-10">
        <x-sidebar/>
        <div class="w-10/12 bg-white-secondary px-10 py-10">
            @if (Session::has('success'))
            <div id="success"
                class="w-full px-5 bg-green-500 text-white py-3 rounded my-4 items-center">
                {{ Session::get('success') }}
            </div>
            @endif

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
