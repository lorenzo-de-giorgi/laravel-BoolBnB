@extends('layouts.app')
@extends('layouts.loader')
@section('title', 'Apartments')

@section('content')
<section>
  <div class="container vh-100 p-5">
    <div class="d-flex justify-content-between align-items-center py-4">
      <h1>Apartment Sponsorship</h1>
      <a href="{{route('admin.apartment_sponsorship.create')}}" class="btn btn-primary">Add new Sponsorship</a>
    </div>
      <div class="table100">
        <table>
          <thead>
            <tr class="table100-head">
              <th class="column1" scope="col">id</th>
              <th class="column3" scope="col">apartment_id</th>
              <th class="column2" scope="col">sponsorship_id</th>
              <th class="column4" scope="col">name</th>
              <th class="column5" scope="col">start_time</th>
              <th class="column6" scope="col">end_time</th>
              <!-- <th class="column7" scope="col">Image</th> -->
              <th class="column8" scope="col">price</th>
            </tr>
          </thead>
            <tbody>
                @foreach ($apartmentSponsorship as $item)
                    <tr>
                        <td class="column1">{{$item->id}}</td>
                        <td class="column2">{{$item->apartment_id}}</td>
                        <td class="column3">{{$item->sponsorship_id}}</td>
                        <td class="column4">{{$item->name}}</td>
                        <td class="column5">{{$item->start_time}}</td>
                        <td class="column6">{{$item->end_time}}</td>
                        <td class="column8">{{$item->price}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
  </div>
</section>
@include('partials.modal-delete')
@endsection