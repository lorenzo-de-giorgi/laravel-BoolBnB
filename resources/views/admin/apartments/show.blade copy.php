@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Show Apartment')

@section('content')
<section class="container p-5">
    <div >
        <div >
                <h2>{{$apartment->title}}</h2>
            @php
                $images = json_decode($apartment->image, true);
            @endphp
            @foreach ($images as $image)
                <div id="showimage">
                    <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento">
                </div>
            @endforeach
            <h4>{{$apartment->address}}</h4>
        </div>
        <div >
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">number of rooms</th>
                        <th scope="col">number of beds</th>
                        <th scope="col">number of bathrooms</th>
                        <th scope="col">square meters</th>
                        <th scope="col">services</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr>
                        <th scope="row">{{$apartment->rooms_num}}</th>
                        <td>{{$apartment->beds_num}}</td>
                        <td>{{$apartment->bathrooms_num}}</td>
                        <td>{{$apartment->square_meters}}</td>
                        <td>
                            @if($apartment->services)
                                @foreach ($apartment->services as $service)
                                    <span class="badge text-bg-danger">{{$service->name}}</span>
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div>
                <h3>Messages</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>name</th>
                            <th>surname</th>
                            <th>email</th>
                            <th>content</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td> {{$message->name}}</td>
                                <td> {{$message->surname}}</td>
                                <td> {{$message->email}}</td>
                                <td> {{$message->content}}</td>
                            </tr>
                        @endforeach
                    </tbody>
            </div>
        </div>
    </div>
</section>
<!-- <section>
<div id="slider-container" class="container pt-5 pb-5 mt-5">
    <div id="slider-title" class="px-5 mb-4 mt-3">
      <h2>TITOLO</h2>
    </div>
    <div id="slider">
      <div class="slider-wrapper" tabindex="0" @keyup.up="prevSlide" @keyup.down="nextSlide">
        <div class="item">
          <img :src="slides[activeIndexSlide].image" :alt="slides[activeIndexSlide].title" />
          <div class="text">
            <h3>TITOLO SLIDE ATTIVA</h3>
          </div>
        </div>
        <div class="thumbs">
          <div class="prev" @click="prevSlide"></div>
          <div class="next" @click="nextSlide"></div>
          <div class="thumb" :class="{ active: index === activeIndexSlide }" v-for="(slide, index) in slides"
            :key="index" @mouseover="goToSlide(index)">
            <img :src="slide.image" :alt="slide.title" />
          </div>
        </div>
      </div>
    </div>
    <div id="slider-content" class="d-flex container mt-3">
      <div id="slider-info">
        <p class="address p-4 fs-4">INDIRIZZO</p>
        <ul class="list-group">
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><b>Number of rooms:</b></span>
            <span>NUMERO STANZE</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><b>Number of beds:</b></span>
            <span>NUMERO LETTI</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><b>Number of bathrooms:</b></span>
            <span>NUMERO BAGNI</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center">
            <span><b>Square meters:</b></span>
            <span>METRI QUADRATI</span>
          </li>
        </ul>
        <div id="slider-services" class="border-top border-bottom p-4">
          <h3>Services</h3>
          <div v-for="(service, index) in item.services" :key="index">
            <ul class="d-flex">
              <li><i :class="service.icon"></i></li>
              <li class="mx-3">NOME SERVIZI</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> -->
@endsection