@section('title')
    CRM-BGOC
@endsection

<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact Index') }}
        </h2>
    </x-slot> --}}

    <div class="py-2">
        <div class="mx-auto sm:px-6 lg:px-2 w-full md:px-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
                <div class="p-2 bg-yellow-100 border-b">
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
