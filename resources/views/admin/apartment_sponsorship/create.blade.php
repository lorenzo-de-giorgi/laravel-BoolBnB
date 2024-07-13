@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Create Apartment')

@section('content')
<section>
    <div class="container">
        <h2>Create New Apartment</h2>
        <form action="{{ route('admin.payment') }}" method="GET">
            @csrf

            <h5 class="mt-2">Apartment: {{ $apartment->title }}</h5>
            <div>
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
            </div>
            <div class="invalid-feedback" id="checkError"></div>
            @error('apartment_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{--sponsorships--}}
            <h5 class="mt-2">Sponsorships *</h5>
            @foreach ($sponsorships as $sponsorship)
                <div>
                    <input type="radio" name="sponsorship_id" value="{{ $sponsorship->id }}" class="form-check-input checkbox">
                    <label for="sponsorship_id" class="form-check-label">
                        {{ $sponsorship->name }}: {{ $sponsorship->price }}€: {{ explode(':', $sponsorship->duration)[0] }} hours
                    </label>
                </div>
            @endforeach
            <div class="invalid-feedback" id="checkError"></div>
            @error('sponsorship_id')
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
