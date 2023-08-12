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
    <div class="bg-gray-300 min-h-screen">
        <div class="flex min-h-screen">
            <div class="m-auto w-2/6">
                @if ($errors->first('error'))
                <div id="error" class="px-5 bg-red-500 text-white py-3 rounded items-center my-3">
                    {{ $errors->first('error') }}
                    <div class="float-right" onclick="closePopup()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor"
                            class="w-6 h-6  hover:rounded-full text-white hover:bg-red-800 hover:cursor-pointer">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>
                @endif
                @if (Session::has('success'))
                <div id="success"
                    class="w-full px-5 bg-green-500 text-white py-3 rounded my-4 items-center">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="bg-white-secondary rounded p-10">

                    <div class="font-semibold text-3xl pb-10">Masuk Akun</div>

                    <form method="POST" action="{{ route('member.login_proses') }}">
                            @csrf
                            <div class="mb-6">
                                <label for="NIP" class="block mb-2 text-sm font-medium ">NIP</label>
                                <input type="text" id="NIP" name="NIP"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    placeholder="NIP" required="">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="block mb-2 text-sm font-medium ">Password</label>
                                <input type="password" name="password" placeholder="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                    required="">
                            </div>
                            <button type="submit"
                                class="text-white bg-red-primary font-medium rounded-lg text-sm w-full block px-5 py-2.5 text-center mt-6">Submit</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
    function closePopup() {
        document.getElementById('error').style.display = 'none';
    }
</script>
