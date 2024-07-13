@extends('layouts.app')

<div id="loader">
@section('content')
<div class="container vh-100">
    <header class="py-3 mb-4 border-bottom">
        <h1>Dashboard</h1>
    </header>
    <nav>
        
    </nav>
   
    <main>
        ciao
       
        <div style="width: 75%;">
    {!! $chartjs->render() !!}
</div>
    </main>
</div>
</div>
@endsection
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
