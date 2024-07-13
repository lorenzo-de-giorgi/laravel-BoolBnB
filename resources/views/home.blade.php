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
        <h1 class="display-5 fw-bold text-center">
            Welcome {{ Auth::user()->name }}! 
        </h1>
        <div class="text-center">
        <a href="{{route('admin.apartments.index')}}" class="btn btn-primary">go to yours apartments</a>
        </div>
        @endauth

        <div class="text-center mt-5 ">
            <a href="http://localhost:5174/" class="btn btn-Warning">go back to boolbnb</a>
        </div>
    </div>
</div>
@endsection