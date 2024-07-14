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
    <div id="mobile">
      <table>
        @foreach ($apartments as $apartment)
          <tbody>
            <tr>
            <th class="column1" scope="row">Image</th>
            <td class="column1body">
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
              <img src="{{asset('storage/' . $image)}}" alt="{{$apartment->title}}" alt="apartment image">
            </td>
            </tr>
            <tr>
            <th class="column2" scope="row">Title</th>
            <td>{{ $apartment->title }}</td>
            </tr>
            <tr>
            <th class="column3" scope="row">Visibility</th>
            <td>
              @if ($apartment->visibility == 1)
          <i class="fa-solid fa-check" style="color: #4ca456;"></i>
        @else
        <i class="fa-solid fa-check" style="color: #4ca456;"></i>
      @endif
            </td>
            </tr>
            <tr>
            <th class="column4" scope="row">Sponsorship</th>
            <td>
              @if ($apartment->sponsorships->isNotEmpty())
          @foreach ($apartment->sponsorships as $sponsorship)
        @if ($sponsorship->pivot->end_time > now())
      <img src="/img/{{$sponsorship->badge}}" alt="Sponsorship Badge" style="width: 60px; height: 60px;">
    @endif
      @endforeach
    @else
    <div class="rounded-pill text-bg-success p-1">Not Sponsored</div>
        @endif
            </td>
            </tr>
            <tr>
            <th class="column5" scope="row">Actions</th>
            <td class="column5">
              <div class="d-flex align-items-center">
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
            </td>
            </tr>
          </tbody>
    @endforeach
      </table>
    </div>
  </div>
</section>
@include('partials.modal-delete')
@endsection