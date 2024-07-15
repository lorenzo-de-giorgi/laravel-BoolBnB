@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Create Project')

@section('content')
<div class="container d-flex justify-content-between align-items-center p-4">
    <a href="{{ route('admin.apartments.index') }}"><i class="fa-solid fa-arrow-left"></i></a>
    <div>
        <h4>Want more visibility?</h4>
        <a href="{{route('admin.apartment_sponsorship.create', $apartment->slug)}}" class="btn btn-success me-2"><i
                class="fa-brands fa-space-awesome"></i> Sponsor</a>
    </div>
</div>
<section class="container bg-white p-5 my-3 rounded">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-12 mb-3 col-xl">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    @php
                        $images = json_decode($apartment->image, true);
                        $first = true; // Flag per identificare la prima immagine
                    @endphp
                    @foreach ($images as $image)
                        <div class="carousel-item {{ $first ? 'active' : '' }}">
                            <img id="showApartment" src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento">
                        </div>
                        @php    $first = false; @endphp
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-6 col-xl ">
            <h2>{{$apartment->title}}</h2>
            <h5>{{$apartment->address}}</h5>
            <div id="services" class="card mt-3 p-3">
                <h4>Available Services</h4>
                <div>
                    @if($apartment->services)
                        @foreach ($apartment->services as $service)
                            <span class="badge text-bg-primary m-1">{{$service->name}}</span>
                        @endforeach
                    @endif
                </div>
                <div id="sponsorship" class="card mt-2 p-2 d-flex justify-content-center align-items-center">
                    <h6 class="text-left fw-bolder">Status Sponsorship</h6>
                    <div class="rounded-pill text-bg-success p-1">
                        @if($apartment->sponsorships->isNotEmpty())
                            @foreach($apartment->sponsorships as $sponsorship)
                                <span class="p-2">{{ $sponsorship->name }}</span>
                            @endforeach
                        @else
                            Not Sponsored
                        @endif
                    </div>
                    <span class="p-2 text-center">
                        <strong>Expire in:</strong>
                        <br>
                        <?php
use Carbon\Carbon;

$currentDateTime = Carbon::now();
$existingSponsorship = $apartment->sponsorships()
    ->wherePivot('end_time', '>', $currentDateTime)
    ->first();
if ($existingSponsorship) {
    $endDateTimeExisting = Carbon::parse($existingSponsorship->pivot->end_time);
    $diffInSeconds = $endDateTimeExisting->diffInSeconds($currentDateTime);
} else {
    $diffInSeconds = 0; // in case no sponsorship active
}
                        ?>
                        <span id="countdown"></span>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl mt-3 w-100">
            <div class="card p-3">
                <h4>Appartment Details</h4>
                <hr>
                <ul class="list-unstyled">
                    <li><strong>Number of rooms:</strong> {{$apartment->rooms_num}}</li>
                    <li><strong>Number of beds:</strong> {{$apartment->beds_num}}</li>
                    <li><strong>Number of bathrooms:</strong> {{$apartment->bathrooms_num}}</li>
                    <li><strong>Square meters:</strong> {{$apartment->square_meters}}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="mt-3">
        @if($messages->isEmpty())
            <div class="card p-3">
                <h4>Client's messages</h4>
                <hr>
                <div class="card p-3 my-3 mx-3">
                    <strong>You have no messages for this apartment.</strong>
                </div>
            </div>
        @else
            <div class="card p-3">
                <h4>Client's messages</h4>
                <hr>
                <ul id="messages"
                    class="list-unstyled {{ $messages->count() >= 3 ? 'vh-100' : '' }}  {{ $messages->count() >= 3 ? 'overflow-y-scroll' : '' }}">
                    @foreach ($messages as $message)
                        <div class="card p-3 my-3 mx-3">
                            <li>
                                <strong>Name: </strong>
                                {{$message->name}} {{$message->surname}}
                            </li>
                            <li>
                                <strong>Email: </strong>
                                {{$message->email}}
                            </li>
                            <li class="card my-2 p-3">
                                <strong>Message: </strong>
                                <br>
                                {{$message->content}}
                            </li>
                            <li>
                                <strong>Sended: </strong>
                                {{$message->created_at}}
                            </li>
                            @if ($message->update_at)
                                <li>
                                    <strong>Last update: </strong>
                                    {{$message->update_at}}
                                </li>
                            @endif
                        </div>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div id="show-buttons" class="mt-3 mb-3">
        <div>
            <a href="{{route('admin.apartment_sponsorship.create', $apartment->slug)}}" class="btn btn-success me-2"><i
                    class="fa-brands fa-space-awesome"></i> Sponsor</a>
        </div>
        <div>
            <a href="{{route('admin.apartments.edit', $apartment->slug)}}" class="btn btn-primary me-2"><i
                    class="fa-solid fa-pen"></i> Edit</a>
        </div>

        <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button border-0 bg-transparent"
                data-item-title="{{ $apartment->title }}">
                <a class="btn btn-danger me-2"><i class="fa-solid fa-trash"></i> Delete</a>
            </button>
        </form>
    </div>
    <script>
        function startCountdown(seconds) {
            function updateCountdown() {
                let days = Math.floor(seconds / (24 * 60 * 60));
                let hours = Math.floor((seconds % (24 * 60 * 60)) / (60 * 60));
                let minutes = Math.floor((seconds % (60 * 60)) / 60);
                let remainingSeconds = seconds % 60;
                document.getElementById('countdown').innerHTML = `${days} days, ${hours} hours, ${minutes} minutes e ${remainingSeconds} seconds`;
                if (seconds > 0) {
                    seconds--;
                } else {
                    clearInterval(interval);
                    document.getElementById('countdown').innerHTML = "Expired";
                }
            }
            updateCountdown();
            var interval = setInterval(updateCountdown, 1000);
        }

        // Inizializza il countdown con il valore calcolato in PHP
        let initialSeconds = <?php echo $diffInSeconds; ?>;
        startCountdown(initialSeconds);
    </script>
    @include('partials.modal-delete')
</section>
@endsection