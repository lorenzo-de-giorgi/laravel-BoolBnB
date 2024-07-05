@extends('layouts.app')
@section('title', 'Apartments')

@section('content')
<section>
  <div class="container vh-100 p-5">
    <div class="d-flex justify-content-between align-items-center py-4">
      <h1 class="text-white">Apartment Sponsorship</h1>
      <a href="{{route('admin.apartments.create')}}" class="btn btn-primary">Add new Sponsorship</a>
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
              <th class="column9" scope="col">Created at</th>
              <th class="column10" scope="col">Updated at</th>
              <th class="column11" scope="col">Actions</th>
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
                        <td class="column9">{{$item->created_at}}</td>
                        <td class="column10">{{$item->updated_at}}</td>
                        <td class="column11">
                            {{-- <a href="{{route('admin.apartments.show', $item->slug)}}"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{route('admin.apartments.edit', $item->slug)}}"><i class="fa-solid fa-pen"></i></a> --}}
                            <form action="{{route('admin.apartments.destroy', $apartment->slug)}}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-button border-0 bg-transparent"
                                data-item-title="{{ $item->id }}">
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