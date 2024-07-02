@extends('layouts.app')

@section('title', 'Create Apartment')

@section('content')
    <section>
        <div class="container">
            <h2>Create New Apartment</h2>
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data" onsubmit="return validaForm()">
                @csrf
                {{-- title --}}
                <div class="mb-3">
                    <label for="title" class="form-label"><h5 class="mt-2">Title</h5></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required minlength="5" maxlength="255">
                    <div id="titleHelp" class="form-text">Inserire minimo 5 caratteri e massimo 255</div>
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- beds_num --}}
                <div class="mb-3">
                    <label for="beds_num" class="form-label"><h5 class="mt-2">Number of Beds</h5></label>
                    <input type="number"  class="form-control @error('beds_num') is-invalid @enderror" name="beds_num" value="{{ old('beds_num') }}" required min="0" max="15">
                    <div id="titleHelp" class="form-text">Inserire un numero maggiore o uguale a 0</div>
                    @error('beds_num')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- rooms_num --}}
                <div class="mb-3">
                    <label for="rooms_num" class="form-label"><h5 class="mt-2">Number of Rooms</h5></label>
                    <input type="number"  class="form-control @error('rooms_num') is-invalid @enderror" name="rooms_num" value="{{ old('rooms_num') }}" required min="0" max="15">
                    <div id="titleHelp" class="form-text">Inserire un numero maggiore o uguale a 0</div>
                    @error('rooms_num')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- bathrooms_num --}}
                <div class="mb-3">
                    <label for="bathrooms_num" class="form-label"><h5 class="mt-2">Number of Bathrooms</h5></label>
                    <input type="number"  class="form-control @error('bathrooms_num') is-invalid @enderror" name="bathrooms_num" value="{{ old('bathrooms_num') }}" required min="0" max="10">
                    <div id="titleHelp" class="form-text">Inserire un numero maggiore o uguale a 0</div>
                    @error('bathrooms_num')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- square_meters --}}
                <div class="mb-3">
                    <label for="square_meters" class="form-label"><h5 class="mt-2">Square Meters</h5></label>
                    <input type="number"  class="form-control @error('square_meters') is-invalid @enderror" name="square_meters" value="{{ old('square_meters') }}" required min="0" max="1000">
                    <div id="titleHelp" class="form-text">Inserire un numero maggiore o uguale a 0</div>
                    @error('square_meters')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- address --}}
                <div class="mb-3">
                    <label for="address" class="form-label"><h5 class="mt-2">Address</h5></label>
                    <input type="text" class="form-control  @error('address') is-invalid @enderror" id="address" name="address" required minlength="10" maxlength="255">{{ old('address') }}
                    @error('address')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{-- image --}}
                <div class="mb-3">
                    {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                    <label for="image" class="form-label"><h5 class="mt-2">Image</h5></label>
                    <input type="file" accept="image/*" multiple="multiple" class="form-control @error('image') is-invalid @enderror" id="uploadImage" name="image[]" maxlength="255">
                    @error('image')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                {{--services--}}
                <h5 class="mt-2">Services</h5>
                @foreach ($services as $service)
                    <div>
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"> 
                        <label for="" class="form-check-label">{{ $service->name }}</label>
                        @error('services')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endforeach

                {{-- visibility --}}
                <div class="form-group mb-3">
                    <h5 class="mt-2">Visibility</h5>
                    <label class="switch">
                        <input name="visibility" type="checkbox" value="1" checked>
                        <span class="slider round"></span>
                    </label>
                </div>

                {{-- visibility with radio button --}}
                {{-- <div class="form-group mb-3">
                    <p>Visibility</p>
                    <input type="radio" id="no" name="visibility" value="0">
                    <label for="visibility">No</label><br>
                    <input type="radio" id="yes" name="visibility" value="1">
                    <label for="visibility">Yes</label><br>
                    @error('visibility')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div> --}}

                {{-- buttons --}}
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Crea</button>
                </div>
            </form>
        </div>
    </section>

@endsection