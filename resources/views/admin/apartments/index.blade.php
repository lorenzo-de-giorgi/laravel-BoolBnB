@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Apartments')

@section('content')

<section>
  <div class="container p-5">
    <div id="title" class="py-4">
      <h1>Apartments</h1>
      <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Add new Apartment</a>
    </div>
    <div class="row g-5">
      @foreach ($apartments as $apartment)


        <!-- COL-5 -->

        <div class="col-sm-12 col-md-6">
        @php
        $imageArray = json_decode($apartment->image, true);
        $image = '';
        if (!empty($imageArray)) {
        foreach ($imageArray as $key => $value) {
        if (!empty($value)) {
        $image = $value;
        break;
        }
        }
        }
       @endphp
        <img src="{{asset('storage/' . $image)}}" alt="{{$apartment->title}}" alt="apartment image"
          class="imgApartment w-100">
        </div>

        <!-- COL-5 -->

        <div class="col-sm-12 col-md-6 d-flex flex-column justify-content-evenly">
        <h2 class="text-center">{{ $apartment->title }}</h2>
        <div class="d-flex align-items-center justify-content-center flex-column">
          <h4>Available</h4>
          @if ($apartment->visibility == 1)
        <i class="fa-solid fa-check fs-2" style="color: #4ca456;"></i>
      @else
      <i class="fa-solid fa-xmark fs-2" style="color: #ff0000;"></i>
    @endif
        </div>
        <div class="d-flex align-items-center justify-content-center flex-column mb-3">
          <h4>Sponsorship</h4>
          @if ($apartment->sponsorships->isNotEmpty())
        @foreach ($apartment->sponsorships as $sponsorship)
      @if ($sponsorship->pivot->end_time > now())
      <img src="/img/{{$sponsorship->badge}}" alt="Sponsorship Badge" style="width: 100px; height: 100px;">
    @endif
    @endforeach
      @else
      <div class="rounded-pill text-bg-danger p-1 text-center d-block">Not Sponsored</div>
    @endif 
        </div>
        <div class="column5 d-flex align-items-center justify-content-center">
          <a href="{{route('admin.apartments.show', $apartment->slug)}}"><i class="fa-solid fa-eye"></i></a>
          <a href="{{route('admin.apartments.edit', $apartment->slug)}}"><i class="fa-solid fa-pen"></i></a>
          <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST" class="m-0">
          @csrf
          @method('DELETE')
          <button type="submit" class="delete-button border-0 bg-transparent"
            data-item-title="{{ $apartment->title }}">
            <i class="fa-solid fa-trash"></i>
          </button>
          </form>
        </div>
        </div>
    @endforeach
    </div>
   
  </div>
</section>
@include('partials.modal-delete')
@endsection