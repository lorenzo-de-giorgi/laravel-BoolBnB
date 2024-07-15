@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Add Sponsorship')

@section('content')
<section>
    <div class="container">
        
        <form action="{{ route('admin.payment') }}" method="GET" id="sponsorshipForm">
            @csrf

            <h3 class="mt-2 text-center mb-5 mt-3">choose a sponsorship for {{ $apartment->title }}</h3>
            <div>
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
            </div>
            <div class="invalid-feedback text-center" id="checkError"></div>
            @error('apartment_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- sponsorships --}}
            
            <div class="card-container">
                @foreach ($sponsorships as $sponsorship)
                    @php
                        $class = '';
                        if ($sponsorship->name == 'Bronze') $class = 'bronze-card';
                        if ($sponsorship->name == 'Silver') $class = 'silver-card';
                        if ($sponsorship->name == 'Gold') $class = 'gold-card';
                    @endphp
                    <div class="{{ $class }} card" data-id="{{ $sponsorship->id }}">
                        <label for="sponsorship_id" class="form-check-label">
                            {{ $sponsorship->name }}: {{ $sponsorship->price }}€: {{ explode(':', $sponsorship->duration)[0] }} hours
                        </label>
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="sponsorship_id" id="selectedSponsorshipId">
            <div class="invalid-feedback text-center" id="checkError"></div>
            @error('sponsorship_id')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- buttons --}}
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary mt-5" id="submitButton">Add Sponsorship</button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card');
        cards.forEach(card => {
            card.addEventListener('click', function () {
                cards.forEach(c => c.classList.remove('selected'));
                this.classList.add('selected');
                document.getElementById('selectedSponsorshipId').value = this.getAttribute('data-id');
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    const sponsorshipCards = document.querySelectorAll('.card');
    const selectedSponsorshipIdInput = document.getElementById('selectedSponsorshipId');
    const submitButton = document.getElementById('submitButton');
    const checkError = document.getElementById('checkError');

    sponsorshipCards.forEach(card => {
        card.addEventListener('click', function () {
            sponsorshipCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
            selectedSponsorshipIdInput.value = this.getAttribute('data-id');
            checkError.style.display = 'none';
        });
    });

    submitButton.addEventListener('click', function (event) {
        if (selectedSponsorshipIdInput.value === '') {
            event.preventDefault();
            checkError.textContent = 'Please select a sponsorship.';
            checkError.style.display = 'block';
        }
    });
});

</script>
@endsection
