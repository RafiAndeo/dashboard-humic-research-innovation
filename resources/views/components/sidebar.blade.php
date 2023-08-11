<div class="w-2/12 border-r border-gray-400 pt-20">
    <div class="px-10">
        <div class="space-y-2">
            <div class="text-sm pb-3">Overview</div>
            <div class="space-y-6">
                <a href="{{route('dashboard')}}" class="flex space-x-4 hover:bg-red-200 px-6 {{ Route::is('dashboard') ? 'bg-red-200 text-red-primary' : '' }} py-2 rounded item-center hover:text-red-primary hover:cursor-pointer duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                    </svg>
                    <div class="font-medium">Dashboard</div>
                </a>
                <div class="flex space-x-4 hover:bg-red-200 px-6 py-2 rounded item-center hover:text-red-primary hover:cursor-pointer duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                    </svg>
                    <div class="font-medium">Publikasi</div>
                </div>
                <a href="{{route('research.index')}}" class="flex space-x-4 {{ Route::is('research.index') ? 'bg-red-200 text-red-primary' : '' }} hover:bg-red-200 px-6 py-2 rounded item-center hover:text-red-primary hover:cursor-pointer duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M8 10a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                        <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.378 2H4.5zm5 5a3 3 0 101.524 5.585l1.196 1.195a.75.75 0 101.06-1.06l-1.195-1.196A3 3 0 009.5 7z" clip-rule="evenodd" />
                      </svg>

                    <div class="font-medium">Research</div>
                </a>
                <div class="flex space-x-4 hover:bg-red-200 px-6 py-2 rounded item-center hover:text-red-primary hover:cursor-pointer duration-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
                    </svg>
                    <div class="font-medium">Anggota</div>
                </div>
            </div>
        </div>
    </div>
</div>
