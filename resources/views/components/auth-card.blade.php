{{-- <div class="min-h-screen flex flex-col sm:justify-center items-center bg-[length:1540px_720px] bg-[url('/storage/images/1.jpg')] sm:pt-0"> --}}
<div
    class="min-h-screen flex flex-col sm:justify-center items-center bg-cover bg-center bg-[url('/storage/images/bluedale_bg.jpg')] sm:pt-0">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg opacity-80">
        {{ $slot }}
    </div>
</div>
