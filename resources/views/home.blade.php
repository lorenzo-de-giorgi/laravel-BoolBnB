@extends('layouts.app')
@extends('layouts.loader')

@section('content')
<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container py-5 vh-100">
        <div class="logo_laravel">
            <svg viewBox="0 0 651 192" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-25">
                <!-- SVG content -->
            </svg>
        </div>

        @auth
        <h1 class="display-5 fw-bold">
            Benvenuto, {{ Auth::user()->name }}! 
        </h1>
        @endauth

    </div>
</div>
@endsection