@extends('layouts.admin')

@section('title', 'Create Project')

@section('content')
    <section>
        <h2>Create a new Apartment</h2>
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" minlength="5" maxlength="255" required>
                @error('title')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- beds_num --}}
            <div class="mb-3">
                <label for="beds_num" class="form-label">Number of Beds</label>
                <input type="number"  class="form-control" name="beds_num" value="{{ old('beds_num') }}" required>
                @error('beds_num')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- rooms_num --}}
            <div class="mb-3">
                <label for="rooms_num" class="form-label">Number of rooms</label>
                <input type="number"  class="form-control" name="rooms_num" value="{{ old('rooms_num') }}" required>
                @error('rooms_num')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- bathrooms_num --}}
            <div class="mb-3">
                <label for="bathrooms_num" class="form-label">Number of Bathroom</label>
                <input type="number"  class="form-control" name="bathrooms_num" value="{{ old('bathrooms_num') }}" required>
                @error('bathrooms_num')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- square_meters --}}
            <div class="mb-3">
                <label for="square_meters" class="form-label">metri quadri</label>
                <input type="number"  class="form-control" name="square_meters" value="{{ old('square_meters') }}" required>
                @error('square_meters')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
            {{-- address --}}
            <div class="mb-3">
                <label for="street" class="form-label">Address</label>
                <input type="text" class="form-control  @error('street') is-invalid @enderror" id="street" name="street" minlength="5" maxlength="180" required>{{ old('street') }}
            </div>
            <div class="d-flex">
                {{-- CAP --}}
                <label for="cap" class="form-label">CAP</label>
                <input type="number" class="form-control me-2" id="cap" name="cap" required minlength="5" maxlength="5">
                {{-- citta --}}
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control me-2" id="city" name="city" required minlength="2" maxlength="50">
                {{-- Provincia --}}
                <label for="province" class="form-label">Province</label>
                <input type="text" class="form-control me-2" id="province" name="province" minlength="2" maxlength="2" required>
            </div>
            {{-- image --}}
            <div class="mb-3">
                {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                <label for="image" class="form-label">Image</label>
                <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="uploadImage" name="name="image[]"" value="{{ old('image') }}" maxlength="255" max="1024" required>
                @error('image')
                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
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
                <button type="submit" class="btn btn-primary">Crea</button>
                <button type="reset" class="btn btn-danger">Svuota campi</button>
            </div>
        </form>
    </section>

@endsection
