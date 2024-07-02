@extends('layouts.app')
@section('title', 'Apartments')

@section('content')
<section>
    <div class="d-flex justify-content-between align-items-center py-4">
        <h1>Apartments</h1>
        <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Add new Apartment</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
              <th scope="col">Id</th>
              <th scope="col">user_id</th>
              <th scope="col">slug</th>
              <th scope="col">title</th>
              <th scope="col">beds_num</th>
              <th scope="col">rooms_num</th>
              <th scope="col">bathrooms_num</th>
              <th scope="col">square_meters</th>
              <th scope="col">Address</th>
              <th scope="col">latitude</th>
              <th scope="col">longitude</th>
              <th scope="col">image</th>
              <th scope="col">visibility</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($apartments as $apartment)
            <tr>
                <td>{{$apartment->id}}</td>
                <td>{{$apartment->user_id}}</td>
                <td>{{$apartment->slug}}</td>
                <td>{{$apartment->title}}</td>
                <td>{{$apartment->beds_num}}</td>
                <td>{{$apartment->rooms_num}}</td>
                <td>{{$apartment->bathrooms_num}}</td>
                <td>{{$apartment->square_meters}}</td>
                <td>{{$apartment->address}}</td>
                <td>{{$apartment->latitude}}</td>
                <td>{{$apartment->longitude}}</td>
                <td>{{$apartment->image}}</td>
                <td>{{$apartment->visibility}}</td>
                <td>{{$apartment->created_at}}</td>
                <td>{{$apartment->updated_at}}</td>
                <td>
                    <a href="{{route('admin.apartments.show', $apartment->slug)}}"><i class="fa-solid fa-eye"></i></a>
                    <a href="{{route('admin.apartments.edit', $apartment->slug)}}"><i class="fa-solid fa-pen"></i></a>
                    <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST" class="d-inline-block">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="delete-button border-0 bg-transparent"  data-item-title="{{ $apartment->title }}">
                        <i class="fa-solid fa-trash"></i>
                      </button>

                    </form>
                </td>
              </tr>
            @endforeach


          </tbody>
      </table>
</section>
@include('partials.modal-delete')
@endsection