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
                <label for="street" class="form-label">Address</label>
                <input type="text" class="form-control  @error('street') is-invalid @enderror" id="street" name="street">{{ old('street') }}
            </div>
            <div class="d-flex">
                {{-- CAP --}}
                <label for="cap" class="form-label">CAP</label>
                <input type="number" class="form-control me-2" id="cap" name="cap">
                {{-- citta --}}
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control me-2" id="city" name="city">
                {{-- Provincia --}}
                <label for="province" class="form-label">Province</label>
                <input type="text" maxlength="2" class="form-control me-2" id="province" name="province">
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
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input"
                        {{ in_array($service->id, old('service', [])) ? 'checked' : '' }}>
                    <label for="" class="form-check-label">{{ $service->name }}</label>
                </div>
            @endforeach

            {{-- visibility --}}
            <div class="form-group mb-3">
                <p>Visibility</p>
                <input type="radio" id="no" name="visibility" value="0">
                <label for="visibility">No</label><br>
                <input type="radio" id="yes" name="visibility" value="1">
                <label for="visibility">Yes</label><br>
            </div>
            {{-- buttons --}}
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Crea</button>
                <button type="reset" class="btn btn-danger">Svuota campi</button>
            </div>
        </form>
    </section>

@endsection