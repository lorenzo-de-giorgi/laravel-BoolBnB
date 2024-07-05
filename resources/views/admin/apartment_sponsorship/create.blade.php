@extends('layouts.app')

@section('title', 'Create Apartment')

@section('content')
<section>
    <div class="container">
        <h2>Create New Apartment</h2>
        <form action="{{ route('admin.apartment_sponsorship.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h5 class="mt-2">Apartment *</h5>
            @foreach ($apartments as $apartment)
                <div>
                    <input type="checkbox" name="apartment" value="{{ $apartment->id }}" class="form-check-input checkbox">
                    <label for="apartment" class="form-check-label">{{ $apartment->title }}</label>
                </div>
            @endforeach
            <div class="invalid-feedback" id="checkError"></div>
            @error('apartment')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{--sponsorships--}}
            <h5 class="mt-2">Sponsorships *</h5>
            @foreach ($sponsorships as $sponsorship)
                <div>
                    <input type="checkbox" name="sponsorship" value="{{ $sponsorship->id }}" class="form-check-input checkbox">
                    <label for="sponsorship" class="form-check-label">{{ $sponsorship->name }}</label>
                </div>
            @endforeach
            <div class="invalid-feedback" id="checkError"></div>
            @error('sponsorship')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- buttons --}}
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary" id="submitButton">Crea</button>
            </div>
        </form>
    </div>
</section>

@endsection
