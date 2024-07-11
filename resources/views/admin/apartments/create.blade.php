@extends('layouts.app')

@section('title', 'Create Apartment')

<div id="loader">
@section('content')
<section>
    <div class="container">
        <h2>Create New Apartment</h2>
        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- title --}}
            <div class="mb-3">
                <label for="title" class="form-label">
                    <h5 class="mt-2">Title *</h5>
                </label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                    value="{{ old('title') }}" required minlength="5" maxlength="255">
                <div class="invalid-feedback" id="titleError"></div>
                @error('title')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- beds_num --}}
            <div class="mb-3">
                <label for="beds_num" class="form-label">
                    <h5 class="mt-2">Number of Beds *</h5>
                </label>
                <input type="number" class="form-control @error('beds_num') is-invalid @enderror" name="beds_num"
                    value="{{ old('beds_num') }}" required min="1" max="15" id="beds_num">
                <div class="invalid-feedback" id="bedsError"></div>
                @error('beds_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- rooms_num --}}
            <div class="mb-3">
                <label for="rooms_num" class="form-label">
                    <h5 class="mt-2">Number of Rooms *</h5>
                </label>
                <input type="number" class="form-control @error('rooms_num') is-invalid @enderror" name="rooms_num"
                    value="{{ old('rooms_num') }}" required min="1" max="15" id="rooms_num">
                <div class="invalid-feedback" id="roomsError"></div>
                @error('rooms_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- bathrooms_num --}}
            <div class="mb-3">
                <label for="bathrooms_num" class="form-label">
                    <h5 class="mt-2">Number of Bathrooms *</h5>
                </label>
                <input type="number" class="form-control @error('bathrooms_num') is-invalid @enderror"
                    name="bathrooms_num" value="{{ old('bathrooms_num') }}" required min="1" max="15"
                    id="bathrooms_num">
                <div class="invalid-feedback" id="bathsError"></div>
                @error('bathrooms_num')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- square_meters --}}
            <div class="mb-3">
                <label for="square_meters" class="form-label">
                    <h5 class="mt-2">Square Meters *</h5>
                </label>
                <input type="number" class="form-control @error('square_meters') is-invalid @enderror"
                    name="square_meters" value="{{ old('square_meters') }}" required min="1" max="1000"
                    id="square_meters">
                <div class="invalid-feedback" id="metersError"></div>
                @error('square_meters')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{-- address --}}
           
            <div class="mb-3" id="adressform">
                <label for="address" class="form-label">
                    <h5 class="mt-2">Address *</h5>
                </label>
                <input list="locality"  class="form-control  @error('address') is-invalid @enderror" id="address"
                    name="address" required minlength="10" maxlength="255">{{ old('address') }}
                    <datalist id="locality">
                       
                    </datalist>
                    <div id="autocompleteError" class="text-danger"></div>
                    <div class="invalid-feedback" id="addressError"></div> 
                @error('address')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror

                <div id="ciao">ciao</div>
            </div>

<!-- <input type="text" list="locality">
<datalist id>
    <option value="">ciao</option>
</datalist> -->

            {{-- image --}}
            <div class="mb-3">
                {{-- <img id="uploadPreview" width="100" src="/images/placeholder.png"> --}}
                <label for="image" class="form-label">
                    <h5 class="mt-2">Image *</h5>
                </label>
                <input type="file" accept="image/*" multiple="multiple"
                    class="form-control @error('image') is-invalid @enderror" id="uploadImage" name="image[]" required >
                     <div class="invalid-feedback" id="imageError"></div> 
                  
                @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            {{--services--}}

            <h5 class="mt-2">Services *</h5>
            @foreach ($services as $service)
                <div>
                    <input type="checkbox" name="services[]" value="{{ $service->id }}" class="form-check-input checkbox">
                    <label for="" class="form-check-label">{{ $service->name }}</label>
                </div>
            @endforeach
            <div class="invalid-feedback" id="checkError"></div>
            @error('services')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            {{-- visibility --}}
            <div class="form-group mb-3">
                <h5 class="mt-2">Visibility *</h5>
                <label class="switch">
                    <input name="visibility" type="checkbox" value="1" checked>
                    <span class="slider round"></span>
                </label>
            </div>

            {{-- visibility with radio button --}}
            {{-- <div class="form-group mb-3">
                <p>Visibility</p>
                <input type="radio" id="no" name="visibility" value="0">
                <label for="visibility">No</label><br>
                <input type="radio" id="yes" name="visibility" value="1">
                <label for="visibility">Yes</label><br>
                @error('visibility')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div> --}}

            {{-- buttons --}}
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary" id="submitButton">Crea</button>
            </div>
        </form>
    </div>
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
    const uploadImage = document.getElementById('uploadImage');
    const imageError = document.getElementById('imageError');

    function isImageUploaded() {
        return uploadImage.files.length > 0;
    }

    submitButton.addEventListener("click", (event) => {
        let formIsValid = true;

        if (!isImageUploaded()) {
            uploadImage.classList.add('is-invalid');
            imageError.textContent = "You must select at least one image.";
            imageError.style.display = 'block';
            formIsValid = false;
        } else {
            uploadImage.classList.remove('is-invalid');
            imageError.textContent = "";
            imageError.style.display = 'none';
        }

        if (!formIsValid) {
            event.preventDefault();
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
