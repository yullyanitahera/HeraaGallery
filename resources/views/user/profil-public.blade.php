<!--navbar-->
@extends('layout.main')
@push('cssjsexternal')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
<!--/navbar-->
@section('content')
    <section class="mt-32">
        <div class="items-center max-w-screen-md mx-auto ">
            <h3 class="text-5xl text-center font-hurricane">Gallery Photo</h3>
        </div>
    </section>
    <section>
        <div class="flex flex-col items-center max-w-screen-md px-2 mx-auto mt-4">
            <div>
                <img src="/pic/{{ $foto_profil }}" alt="" class="w-24 h-24 rounded-full">
            </div>
            <h3 class="text-xl font-semibold">
                {{ $username }}
            </h3>
            <small class="text-xs ">{{ $bio }}</small>

        </div>
    </section>
    <section class="mt-10">
        <input type="hidden" value="{{ $user_id }}" id="input-user_id">
        <div class="max-w-screen-md mx-auto">
            <div class="flex flex-wrap items-center flex-container" id="publicfoto">
                <!--postinganuser-->
            </div>
            <div class="mb-28"></div>
        </div>
    </section>
    <script src="/node_modules/flowbite/dist/flowbite.min.js"></script>
@endsection
@push('footerjsexternal')
    <script src="/javascript/profilpublic.js"></script>
@endpush
