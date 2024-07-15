<!-- resources/views/admin/receipt.blade.php -->
@extends('layouts.admin')
@section('title', 'Payment Recipt')
@section('content')
    <div class="container">
        <h1>Payment Recipt</h1>
        <div class="card">
            <div class="card-header">
                Purchase Details
            </div>
            <div class="card-body">
                <p><strong>Apartment:</strong> {{ $apartment->title }}</p>
                <p><strong>Address:</strong> {{ $apartment->address }}</p>
                <p><strong>Sponsorship name:</strong> {{ $sponsorship->name }}</p>
                <p><strong>Price:</strong> €{{ number_format($amount, 2) }}</p>
                <p><strong>Start date:</strong> {{ $start_time->format('d-m-Y H:i:s') }}</p>
                <p><strong>End date:</strong> {{ $end_time->format('d-m-Y H:i:s') }}</p>
                <p><strong>Transaction ID:</strong> {{ $transactionId }}</p>
            </div>
        </div>
        <a href="{{ route('admin.apartments.show', $apartment->slug) }}" class="btn btn-primary mt-3">Torna all'appartamento</a>
    </div>
@endsection