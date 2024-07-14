@extends('layouts.app')

<div id="loader">
    @section('content')
    <div class="container vh-100">
        <header class="py-3 mb-4 border-bottom">
            <h1>Viewing trends</h1>
        </header>
        <nav>

        </nav>

        <main class="container">

            @foreach ($charts as $apartmentId => $chart)
                
                {!! $chart->render() !!}
                   
               

            @endforeach 


        </main>
    </div>
</div>
@endsection
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
