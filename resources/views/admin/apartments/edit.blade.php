@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
<section>
    <h2>Create a new Apartment</h2>
    <form id="update" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" enctype="multipart/form-data" onsubmit="return validaForm()">
        @csrf
        @method('PUT')
        {{-- title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $apartment->title)}}" required minlength="5" maxlength="255">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- beds_num --}}
        <div class="mb-3">
            <label for="beds_num" class="form-label">Number of Beds</label>
            <input type="number" class="form-control" name="beds_num" value="{{old('beds_num', $apartment->beds_num)}}" required min="0" max="15">
            @error('beds_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- rooms_num --}}
        <div class="mb-3">
            <label for="rooms_num" class="form-label">Number of rooms</label>
            <input type="number" class="form-control" name="rooms_num" value="{{ old('rooms_num', $apartment->rooms_num) }}" required min="0" max="15">
            @error('rooms_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- bathrooms_num --}}
        <div class="mb-3">
            <label for="bathrooms_num" class="form-label">Number of Bathroom</label>
            <input type="number" class="form-control" name="bathrooms_num" value="{{ old('bathrooms_num', $apartment->bathrooms_num) }}" required min="0" max="15">
            @error('bathrooms_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- square_meters --}}
        <div class="mb-3">
            <label for="square_meters" class="form-label">metri quadri</label>
            <input type="number" class="form-control" name="square_meters" value="{{ old('square_meters', $apartment->square_meters) }}" required min="0" max="1000">
            @error('square_meters')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- address --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control  @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $apartment->address) }}" required minlength="10" maxlength="255">
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
       
        {{-- image --}}
        <div class="mb-3">
            {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
            <label for="image" class="form-label">Image</label>
            <input type="file" multiple accept="image/*" class="form-control @error('image') is-invalid @enderror"
            id="uploadImage" name="image[]" value="{{ old('image', $apartment->image) }}" maxlength="255">
            <div class="media me-4">
                @if($apartment->image)
                    <img class="shadow" width="100" src="{{asset('storage/' . $apartment->image)}}"
                        alt="{{$apartment->title}}" id="uploadPreview">
                @endif
            </div>
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
{{--anteprima--}}

        @php
            $images = json_decode($apartment->image, true);
        @endphp

      
        @foreach ($images as $image)
            @php $index = array_search($image, $images); @endphp
            <div class="d-flex">
                <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento" class="deletedImages" id="{{$index}}"
                    style="max-width: 50%; height: auto;">
                    
            </div>
        @endforeach
        <input type="text" value="" id="toDelete" name="toDelete">
        


          {{--services--}}
            @foreach ($services as $service)
                <div>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                    {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                    <label for="" class="form-check-label">{{ $service->name }}</label>
                </div>
            @endforeach
        {{-- visibility --}}
        {{-- <div class="form-group mb-3">
            <p>Visibility</p>
            <input type="radio" id="no" name="visibility" value="0">
            <label for="visibility">No</label><br>
            <input type="radio" id="yes" name="visibility" value="1">
            <label for="visibility">Yes</label><br>
        </div> --}}

        <div class="form-group mb-3">
            <h5 class="mt-2">Visibility</h5>
            <label class="switch">
                <input id="visibility" name="visibility" type="checkbox" value="1" {{ $apartment->visibility == 0 ? '' : 'checked' }}>
                <span class="slider round"></span>
            </label>
            @error('visibility')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- buttons --}}
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary" id="resetDelete">Update</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('update');
            form.addEventListener('submit', function() {
                const checkbox = document.getElementById('visibility');
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    checkbox.value = 0;
                }
            });
        });           
    </script>
</section>

@endsection