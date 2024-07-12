@extends('layouts.app')

@section('title', 'Create Project')

<div id="loader">
@section('content')
<section>
    <h2>Create a new Apartment</h2>
    <form id="update" action="{{ route('admin.apartments.update', $apartment->slug) }}" method="POST" enctype="multipart/form-data" onsubmit="return validaForm()">
        @csrf
        @method('PUT')
        {{-- title --}}
        <div class="mb-3">
            <label for="title" class="form-label">Title *</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{old('title', $apartment->title)}}" required minlength="5" maxlength="255">
            <div class="invalid-feedback" id="titleError"></div>
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- beds_num --}}
        <div class="mb-3">
            <label for="beds_num" class="form-label">Number of Beds *</label>
            <input type="number" class="form-control" name="beds_num" value="{{old('beds_num', $apartment->beds_num)}}" required min="0" max="15" id="beds_num">
            <div class="invalid-feedback" id="bedsError"></div>
            @error('beds_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- rooms_num --}}
        <div class="mb-3">
            <label for="rooms_num" class="form-label">Number of rooms *</label>
            <input type="number" class="form-control" name="rooms_num" value="{{ old('rooms_num', $apartment->rooms_num) }}" required min="0" max="15"  id="rooms_num">
            <div class="invalid-feedback" id="roomsError"></div>
            @error('rooms_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- bathrooms_num --}}
        <div class="mb-3">
            <label for="bathrooms_num" class="form-label">Number of Bathroom *</label>
            <input type="number" class="form-control" name="bathrooms_num" value="{{ old('bathrooms_num', $apartment->bathrooms_num) }}" required min="0" max="15"  id="bathrooms_num">
            <div class="invalid-feedback" id="bathsError"></div>
            @error('bathrooms_num')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- square_meters --}}
        <div class="mb-3">
            <label for="square_meters" class="form-label">Square meters *</label>
            <input type="number" class="form-control" name="square_meters" value="{{ old('square_meters', $apartment->square_meters) }}" required min="0" max="1000" id="square_meters">
            <div class="invalid-feedback" id="metersError"></div>
            @error('square_meters')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        {{-- address --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address *</label>
            <input list="locality" type="text" class="form-control  @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $apartment->address) }}" required minlength="10" maxlength="255">
            <datalist id="locality">
         </datalist>
            <div class="invalid-feedback" id="addressError"></div>
            @error('address')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
       
        {{-- image --}}
        <div class="mb-3">
            {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
            <label for="image" class="form-label">Image *</label>
            <input type="file" multiple accept="image/*" class="form-control @error('image') is-invalid @enderror"
            id="uploadImage" name="image[]" value="{{ old('image', $apartment->image) }}" maxlength="255">
            <div class="media me-4">
                @if($apartment->image)
                    <img class="shadow" width="100" src="{{asset('storage/' . $apartment->image)}}"
                        alt="{{$apartment->title}}" id="uploadPreview">
                @endif
            </div>
            <div class="invalid-feedback" id="imageError"></div> 
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
{{--anteprima--}}

        @php
            $images = json_decode($apartment->image, true);
        @endphp
<div class="d-flex flex-wrap gap-4">
      
        @foreach ($images as $image)
            @php $index = array_search($image, $images); @endphp
            
                <img src="{{ asset('storage/' . $image) }}" alt="Immagine dell'appartamento" class="deletedImages" id="{{$index}}"
                     style="width: 200px; height: 200px; object-fit: cover;">
                    
            
        @endforeach
       
        
        </div>
        <input type="text" value="" id="toDelete" name="toDelete">

          {{--services--}}
          <h5 class="mt-2">Services *</h5>
            @foreach ($services as $service)
                <div>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input checkbox" 
                    {{ $apartment->services->contains($service->id) ? 'checked' : '' }}>
                    <label for="" class="form-check-label">{{ $service->name }}</label>
                </div>
            @endforeach
            <div class="invalid-feedback" id="checkError"></div>

        {{-- visibility --}}
        {{-- <div class="form-group mb-3">
            <p>Visibility</p>
            <input type="radio" id="no" name="visibility" value="0">
            <label for="visibility">No</label><br>
            <input type="radio" id="yes" name="visibility" value="1">
            <label for="visibility">Yes</label><br>
        </div> --}}

        <div class="form-group mb-3">
            <h5 class="mt-2">Visibility *</h5>
            <label class="switch">
                <input id="visibility" name="visibility" type="checkbox" value="1" {{ $apartment->visibility == 0 ? '' : 'checked' }}>
                <span class="slider round"></span>
            </label>
            
            @error('visibility')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- buttons --}}
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary" id="submitButton">Update</button>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('update');
            form.addEventListener('submit', function() {
                const checkbox = document.getElementById('visibility');
                if (!checkbox.checked) {
                    checkbox.checked = true;
                    checkbox.value = 0;
                }
            });
        });           
    </script>
</section>

@endsection
</div>
<script>
// STAMPA DEGLI ERRORI

document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const title = document.getElementById("title");
        const titleError = document.getElementById("titleError");
        title.addEventListener("input", (event) => {
            if (title.value.length < 5) {
                title.classList.add('is-invalid');
                titleError.textContent = "The title must be at least 5 characters long!";
            } else {
               
                title.classList.remove('is-invalid');
                titleError.textContent = "";
            }
        });
        submitButton.addEventListener("click", (event) => {
            if (title.value.length < 5) {
               
                title.classList.add('is-invalid');
                titleError.textContent = "The title must be at least 5 characters long!";
            } else {
               
                title.classList.remove('is-invalid');
                titleError.textContent = "";
            }
        })
    })

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const beds_num = document.getElementById("beds_num");
        const bedsError = document.getElementById("bedsError");
        beds_num.addEventListener("input", (event) => {
            if (beds_num.value < 1 || beds_num.value > 15) {
               
                beds_num.classList.add('is-invalid');
                bedsError.textContent = "The number of beds must be between 1 to 15";
            } else {
                
                beds_num.classList.remove('is-invalid');
                bedsrror.textContent = "";
            }
        });

        submitButton.addEventListener("click", (event) => {
            if (beds_num.value < 1 || beds_num.value > 15) {
               
                beds_num.classList.add('is-invalid');
                bedsError.textContent = "The number of beds must be between 1 to 15";
            } else {
                
                beds_num.classList.remove('is-invalid');
                bedsError.textContent = "";
            }

        })
    })

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const rooms_num = document.getElementById("rooms_num");
        const roomsError = document.getElementById("roomsError");
        rooms_num.addEventListener("input", (event) => {
            if (rooms_num.value < 1 || rooms_num.value > 15) {
               
                rooms_num.classList.add('is-invalid');
                roomsError.textContent = "The number of rooms must be between 1 to 15";
            } else {
              
                rooms_num.classList.remove('is-invalid');
                roomsError.textContent = "";
            }
        });
        submitButton.addEventListener("click", (event) => {
            if (rooms_num.value < 1 || rooms_num.value > 15) {
               
                rooms_num.classList.add('is-invalid');
                roomsError.textContent = "The number of rooms must be between 1 to 15";
            } else {
               
                rooms_num.classList.remove('is-invalid');
                roomsError.textContent = "";
            }

        })
    })

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const bathrooms_num = document.getElementById("bathrooms_num");
        const bathsError = document.getElementById("bathsError");
        bathrooms_num.addEventListener("input", (event) => {
            if (bathrooms_num.value < 1 || bathrooms_num.value > 15) {
                
                bathrooms_num.classList.add('is-invalid');
                bathsError.textContent = "The number of bathrooms must be between 1 to 15";
            } else {
              
                bathrooms_num.classList.remove('is-invalid');
                bathsError.textContent = "";
            }
        });
        submitButton.addEventListener("click", (event) => {
            if (bathrooms_num.value < 1 || bathrooms_num.value > 15) {
               
                bathrooms_num.classList.add('is-invalid');
                bathsError.textContent = "The number of bathrooms must be between 1 to 15";
            } else {
               
                bathrooms_num.classList.remove('is-invalid');
                bathsError.textContent = "";
            }

        })
    })

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const square_meters = document.getElementById("square_meters");
        const metersError = document.getElementById("metersError");
        square_meters.addEventListener("input", (event) => {
            if (square_meters.value < 1 || square_meters.value > 1000) {
              
                square_meters.classList.add('is-invalid');
                metersError.textContent = "the apartment must be between 1 to 1000 square meters.";
            } else {
                
                square_meters.classList.remove('is-invalid');
                metersError.textContent = "";
            }
        });
        submitButton.addEventListener("click", (event) => {
            if (square_meters.value < 1 || square_meters.value > 1000) {
               
                square_meters.classList.add('is-invalid');
                metersError.textContent = "the apartment must be between 1 to 1000 square meters.";
            } else {
               
                square_meters.classList.remove('is-invalid');
                metersError.textContent = "";
            }
        })
    })

    document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('myForm');
    const submitButton = document.getElementById('submitButton');
    const checkboxes = document.querySelectorAll('.checkbox');
    const checkError = document.getElementById('checkError');
    
    function isAnyCheckboxChecked() {
        let isChecked = false;
        for (let checkbox of checkboxes) {
            if (checkbox.checked) {
                isChecked = true;
            }
        }
        return isChecked;
    }

    if (!isAnyCheckboxChecked()) {
           
            checkboxes.forEach(checkbox => {
                checkbox.classList.add('is-invalid');
                
            });
           
            checkError.textContent = "select at least one service.";
            checkError.style.display = 'block'; 
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.classList.remove('is-invalid');
                
            });
            
            checkError.style.display = 'none';
        }

   

    submitButton.addEventListener("click", (event) => {
        if (!isAnyCheckboxChecked()) {
            event.preventDefault();
            checkboxes.forEach(checkbox => {
                checkbox.classList.add('is-invalid');
                
            });
           
            checkError.textContent = "select at least one service.";
            checkError.style.display = 'block'; 
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.classList.remove('is-invalid');
                
            });
            
            checkError.style.display = 'none';
        }
    });

   
});

    


document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('myForm');
        const submitButton = document.getElementById('submitButton');
        const address = document.getElementById("address");
        const addressError = document.getElementById("addressError");
        address.addEventListener("input", (event) => {
            if (address.value.length < 1) {
                address.classList.add('is-invalid');
                addressError.textContent = "you must insert an address!";
            } else {
               
                address.classList.remove('is-invalid');
                addressError.textContent = "";
            }
        });
        submitButton.addEventListener("click", (event) => {
            if (address.value.length < 1) {
               
                address.classList.add('is-invalid');
                addressError.textContent = "you must insert an address!";
            } else {
               
                address.classList.remove('is-invalid');
                addressError.textContent = "";
            }
        })
    })

</script>