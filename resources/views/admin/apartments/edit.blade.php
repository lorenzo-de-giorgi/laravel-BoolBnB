@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
<section>
    <h2>Create a new Apartment</h2>
    <form action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        {{-- title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $apartment->title)}}" minlength="5" maxlength="255" required>
            @error('title')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- beds_num --}}
        <div class="mb-3">
            <label for="beds_num" class="form-label">Number of Beds</label>
            <input type="number" class="form-control" name="beds_num" value="{{old('beds_num', $apartment->beds_num)}}" required>
            @error('beds_num')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- rooms_num --}}
        <div class="mb-3">
            <label for="rooms_num" class="form-label">Number of rooms</label>
            <input type="number" class="form-control" name="rooms_num" value="{{ old('rooms_num', $apartment->rooms_num) }}" required>
            @error('rooms_num')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- bathrooms_num --}}
        <div class="mb-3">
            <label for="bathrooms_num" class="form-label">Number of Bathroom</label>
            <input type="number" class="form-control" name="bathrooms_num" value="{{ old('bathrooms_num', $apartment->bathrooms_num) }}" required>
            @error('bathrooms_num')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- square_meters --}}
        <div class="mb-3">
            <label for="square_meters" class="form-label">metri quadri</label>
            <input type="number" class="form-control" name="square_meters" value="{{ old('square_meters', $apartment->square_meters) }}" required>
            @error('square_meters')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- address --}}
        <div class="mb-3">
            <label for="street" class="form-label">Address</label>
            <input type="text" class="form-control  @error('street') is-invalid @enderror" id="street" name="street" value="{{ old('street', $array[0]) }}"  minlength="5" maxlength="180" required>
        </div>
        <div class="">
            {{-- CAP --}}
            <label for="cap" class="form-label">CAP</label>
            <input type="number" class="form-control me-2" id="cap" name="cap" value="{{ old('cap', $array[1]) }}" required minlength="5" maxlength="5">
            {{-- citta --}}
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control me-2" id="city" name="city" value="{{ old('city', $array[2]) }}"  required minlength="2" maxlength="50">
            {{-- Provincia --}}
            <label for="province" class="form-label">Province</label>
            <input type="text" maxlength="2" class="form-control me-2" id="province" name="province" value="{{ old('street', $array[3]) }}"  minlength="2" maxlength="2" required>
        </div>
        {{-- image --}}
        <div class="mb-3">
            {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
            <label for="image" class="form-label">Image</label>
            <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="uploadImage" name="image[]" value="{{ old('image', $apartment->image) }}" maxlength="255" max="1024">
            <div class="media me-4">
                @if($apartment->image)
                    <img class="shadow" width="100" src="{{asset('storage/' . $apartment->image)}}"
                        alt="{{$apartment->title}}" id="uploadPreview">
                @endif
            </div>
            @error('image')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
{{--anteprima--}}

        @php
            $images = json_decode($apartment->image, true);
        @endphp
        @foreach ($images as $image)
            <div class="d-flex">
                <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento"
                    style="max-width: 50%; height: auto;">
                    <button>delete</button>
            </div>
            @php $index = array_search($image, $images); @endphp
           <input type="number" value="{{$index}}" name="deleted">
        @endforeach
        
        <input type="text" value="{{$apartment->image}}" class="w-100">

        {{-- visibility --}}
        <div class="form-group mb-3">
            <p>Visibility</p>
            <input type="radio" id="no" name="visibility" value="0">
            <label for="visibility">No</label><br>
            <input type="radio" id="yes" name="visibility" value="1">
            <label for="visibility">Yes</label><br>
            @error('visibility')
                <div class="alert alert-danger mt-2">{{ $message }}</div>
            @enderror
        </div>
        {{-- buttons --}}
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">update</button>
            <button type="reset" class="btn btn-danger">Svuota campi</button>
        </div>
    </form>
</section>

@endsection