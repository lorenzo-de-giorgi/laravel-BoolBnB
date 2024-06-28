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
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">
                {{ old('address') }}
              </textarea>
            </div>
            {{-- image --}}
            <div class="mb-3">
                {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                <label for="image" class="form-label">Image</label>
                <input type="file" accept="image/*" class="form-control @error('image') is-invalid @enderror" id="uploadImage"
                    name="image" value="{{ old('image') }}" maxlength="255">
            </div>
            {{-- visibility --}}
            <div class="form-group mb-3">

            </div>
            {{-- buttons --}}
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Crea</button>
                <button type="reset" class="btn btn-danger">Svuota campi</button>
            </div>
        </form>
    </section>

@endsection