@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Apartments')

@section('content')

<section>
  <div class="container p-5">
    <div class="d-flex justify-content-between align-items-center py-4">
      <h1>Apartments</h1>
      <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Add new Apartment</a>
    </div>
    <div class="table100">
      <table>
        <thead>
          <tr class="table100-head">
            <th class="column1" scope="col">Image</th>
            <th class="column2" scope="col">Title</th>
            <th class="column3" scope="col">Visibility</th>
            <th class="column4" scope="col">Sponsorship</th>
            <th class="column5" scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($apartments as $apartment)
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
            <tr>
            <td class="column1body"><img src="{{asset('storage/' . $image)}}" alt="{{$apartment->title}}"></td>
            <td class="column2">{{$apartment->title}}</td>
            <td class="column3">
              @if ($apartment->visibility == 1)
          Visible
        @else
        Not Visible
      @endif</
            td>
            <td class="column4">
              @if ($apartment->sponsorships)
          @foreach ($apartment->sponsorships as $sponsorship)
        @if ($sponsorship->pivot->end_time > now())
      <img src="/img/{{$sponsorship->badge}}" alt="" style="width: 60px; height: 60px;">
    @endif
      @endforeach
        @endif
            </td>
            <td class="column5">
              <div class="d-flex justify-content-end">
              <a href="{{route('admin.apartments.show', $apartment->slug)}}"><i class="fa-solid fa-eye"></i></a>
              <a href="{{route('admin.apartments.edit', $apartment->slug)}}"><i class="fa-solid fa-pen"></i></a>
              <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST">
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
      @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@include('partials.modal-delete')
@endsection