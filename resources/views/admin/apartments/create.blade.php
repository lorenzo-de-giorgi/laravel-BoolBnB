@extends('layouts.app')

@section('title', 'Create Apartment')

@section('content')
    <section>
<<<<<<< HEAD
        <h2>Create a new Apartment</h2>
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}" minlength="3" maxlength="200">
            </div>
            {{-- beds_num --}}
            <div class="mb-3">
                <label for="beds_num" class="form-label">Number of Beds</label>
                <input type="number"  class="form-control"
                    name="beds_num" value="{{ old('beds_num') }}" maxlength="255">
            </div>
            {{-- rooms_num --}}
            <div class="mb-3">
                <label for="rooms_num" class="form-label">Number of rooms</label>
                <input type="number"  class="form-control"
                    name="rooms_num" value="{{ old('rooms_num') }}" maxlength="255">
            </div>
            {{-- bathrooms_num --}}
            <div class="mb-3">
                <label for="bathrooms_num" class="form-label">Number of Bathroom</label>
                <input type="number"  class="form-control"
                    name="bathrooms_num" value="{{ old('bathrooms_num') }}" maxlength="255">
            </div>
            {{-- square_meters --}}
            <div class="mb-3">
                <label for="square_meters" class="form-label">metri quadri</label>
                <input type="number"  class="form-control"
                    name="square_meters" value="{{ old('square_meters') }}" maxlength="255">r
            </div>
            {{-- address --}}
            <div class="mb-3">
                <label for="street" class="form-label">Address</label>
                <input type="text" class="form-control  @error('street') is-invalid @enderror" id="address" name="address">{{ old('address') }}
            </div>
            
            {{-- image --}}
            <div class="mb-3">
                {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                <label for="image" class="form-label">Image</label>
                <input type="file" accept="image/*" multiple="multiple" class="form-control @error('image') is-invalid @enderror" id="uploadImage"
                    name="image[]" maxlength="255">
            </div>
            {{--services--}}
            @foreach ($services as $service)
                <div>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input">
                        
                    <label for="" class="form-check-label">{{ $service->name }}</label>
=======
        <div class="container">
            <h2>Create New Apartment</h2>
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                {{-- title --}}
                <div class="mb-3">
                    <label for="title" class="form-label"><h5 class="mt-2">Title</h5></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" minlength="5" maxlength="255">
>>>>>>> 1807d69040266e431075e78ee1fd933ffc849fb9
                </div>
                {{-- beds_num --}}
                <div class="mb-3">
                    <label for="beds_num" class="form-label"><h5 class="mt-2">Number of Beds</h5></label>
                    <input type="number"  class="form-control" name="beds_num" value="{{ old('beds_num') }}" required min="0" max="15">
                </div>
                {{-- rooms_num --}}
                <div class="mb-3">
                    <label for="rooms_num" class="form-label"><h5 class="mt-2">Number of Rooms</h5></label>
                    <input type="number"  class="form-control" name="rooms_num" value="{{ old('rooms_num') }}" required min="0" max="15">
                </div>
                {{-- bathrooms_num --}}
                <div class="mb-3">
                    <label for="bathrooms_num" class="form-label"><h5 class="mt-2">Number of Bathrooms</h5></label>
                    <input type="number"  class="form-control" name="bathrooms_num" value="{{ old('bathrooms_num') }}" required min="0" max="10">
                </div>
                {{-- square_meters --}}
                <div class="mb-3">
                    <label for="square_meters" class="form-label"><h5 class="mt-2">Square Meters</h5></label>
                    <input type="number"  class="form-control" name="square_meters" value="{{ old('square_meters') }}" required min="0" max="1000">
                </div>
                {{-- address --}}
                <div class="mb-3">
                    <label for="address" class="form-label"><h5 class="mt-2">Address</h5></label>
                    <input type="text" class="form-control  @error('address') is-invalid @enderror" id="address" name="address" required minlength="10" maxlength="255">{{ old('address') }}
                </div>
                {{-- image --}}
                <div class="mb-3">
                    {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                    <label for="image" class="form-label"><h5 class="mt-2">Image</h5></label>
                    <input type="file" accept="image/*" multiple="multiple" class="form-control @error('image') is-invalid @enderror" id="uploadImage" name="image[]" maxlength="255">
                </div>
                {{--services--}}
                <h5 class="mt-2">Services</h5>
                @foreach ($services as $service)
                    <div>
                        <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input">
                            
                        <label for="" class="form-check-label">{{ $service->name }}</label>
                    </div>
                @endforeach

                {{-- visibility --}}
                <div class="form-group mb-3">
                    <h5 class="mt-2">Visibility</h5>
                    <label class="switch">
                        <input type="checkbox" checked>
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
                </div> --}}

                {{-- buttons --}}
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Crea</button>
                </div>
            </form>
        </div>
    </section>

@endsection