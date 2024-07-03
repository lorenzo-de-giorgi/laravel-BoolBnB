@extends('layouts.app')
@section('title', 'Apartments')

@section('content')
<section>
  <div class="container vh-100 p-5">
    <div class="d-flex justify-content-between align-items-center py-4">
      <h1 class="text-white">Apartments</h1>
      <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Add new Apartment</a>
    </div>
      <div class="table100">
        <table>
          <thead>
            <tr class="table100-head">
              <th class="column1" scope="col">Title</th>
              <th class="column2" scope="col">Beds Number</th>
              <th class="column3" scope="col">Rooms Number</th>
              <th class="column4" scope="col">Bathrooms Number</th>
              <th class="column5" scope="col">Square Meters</th>
              <th class="column6" scope="col">Address</th>
              <!-- <th class="column7" scope="col">Image</th> -->
              <th class="column8" scope="col">Visibility</th>
              <th class="column9" scope="col">Created at</th>
              <th class="column10" scope="col">Updated at</th>
              <th class="column11" scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($apartments as $apartment)
        <tr>

          <td class="column1">{{$apartment->title}}</td>
          <td class="column2">{{$apartment->beds_num}}</td>
          <td class="column3">{{$apartment->rooms_num}}</td>
          <td class="column4">{{$apartment->bathrooms_num}}</td>
          <td class="column5">{{$apartment->square_meters}}</td>
          <td class="column6">{{$apartment->address}}</td>
          <!-- <td class="column7">{{$apartment->image}}</td> -->
          <td class="column8">{{$apartment->visibility}}</td>
          <td class="column9">{{$apartment->created_at}}</td>
          <td class="column10">{{$apartment->updated_at}}</td>
          <td class="column11">
          <a href="{{route('admin.apartments.show', $apartment->slug)}}"><i class="fa-solid fa-eye"></i></a>
          <a href="{{route('admin.apartments.edit', $apartment->slug)}}"><i class="fa-solid fa-pen"></i></a>
          <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST"
            class="d-inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button border-0 bg-transparent"
            data-item-title="{{ $apartment->title }}">
            <i class="fa-solid fa-trash"></i>
            </button>

          </form>
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