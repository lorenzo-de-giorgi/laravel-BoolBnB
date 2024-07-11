import './bootstrap';
import '~resources/scss/app.scss';
import '~icons/bootstrap-icons.scss';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
]);
import { TOMTOM_API_KEY } from '../../config';

//prendo la casella di input file
const image = document.getElementById("uploadImage");

//se esiste nella pagina
if (image) {
    image.addEventListener("change", () => {
        //console.log(image.files[0]);
        //prendo l'elemento ing dove voglio la preview
        const preview = document.getElementById("uploadPreview");

        //creo nuoco oggetto file reader
        const oFReader = new FileReader();

        //uso il metodo readAsDataURL dell'oggetto creato per leggere il file
        oFReader.readAsDataURL(image.files[0]);

        //al termine della lettura del file
        oFReader.onload = function (event) {
            //metto nel src della preview l'immagine
            preview.src = event.target.result;
        };
    });
}


let arrayId = [];
let deletedImages = document.querySelectorAll('.deletedImages');
let toDelete = document.getElementById('toDelete');
deletedImages.forEach(function (deletedImage) {
    deletedImage.addEventListener('click', () => {
        let id = deletedImage.id;
        if (!(deletedImage.classList.contains('selected'))) {
            arrayId.push(id);
            deletedImage.classList.add('selected');
        } else {
            deletedImage.classList.remove('selected');
            let index = arrayId.indexOf(id);
            arrayId.splice(index, 1);

        }

        console.log(arrayId);
    })


});

let update = document.getElementById('update');
update.addEventListener('click', () => {
    let string = arrayId.join(' ');
    toDelete.value = string;
});


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('register-form');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password-confirm');
    const passwordMatchError = document.getElementById('password-match-error');
    const birthday = document.getElementById('birthday');

    form.addEventListener('submit', function (event) {
        if (password.value !== passwordConfirm.value) {
            event.preventDefault();
            passwordMatchError.style.display = 'block';
        } else {
            passwordMatchError.style.display = 'none';
        }
    });

    passwordConfirm.addEventListener('input', function () {
        if (password.value !== passwordConfirm.value) {
            passwordConfirm.classList.add('is-invalid');
            passwordMatchError.style.display = 'block';
        } else {
            passwordConfirm.classList.remove('is-invalid');
            passwordMatchError.style.display = 'none';
        }
    });

    const today = new Date();
    const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
    birthday.max = maxDate.toISOString().split('T')[0];
});

const deleteSubmitButtons = document.querySelectorAll(".delete-button");

deleteSubmitButtons.forEach((button) => {
    button.addEventListener("click", (event) => {
        event.preventDefault();

        const dataTitle = button.getAttribute("data-item-title");
        const dataId = button.getAttribute("data-item-id");

        const modal = document.getElementById("deleteModal");

        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();

        const modalItemTitle = modal.querySelector("#modal-item-title");
        modalItemTitle.textContent = dataTitle;

        const buttonDelete = modal.querySelector("button.btn-danger");

        buttonDelete.addEventListener("click", () => {
            button.parentElement.submit();
        });
    });
});

// suggerimenti vie vecchio
const addressInput = document.getElementById('address');
const autocompleteError = document.getElementById('autocompleteError');
const addressForm = document.getElementById('addressForm');
let selectedAddress = false;

addressInput.addEventListener('input', function () {
    let address = addressInput.value;
    const url = `https://api.tomtom.com/search/2/search/${encodeURIComponent(address)}.json?key=${TOMTOM_API_KEY}&countrySet=it-IT&limit=10`;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            let datalist = document.getElementById('locality');
            datalist.innerHTML = ''; // Svuota la datalist

            // Utilizza un Set per tenere traccia degli indirizzi aggiunti
            const addedAddresses = new Set();

            for (let i = 0; i < Math.min(10, data.results.length); i++) {
                const address = data.results[i].address;
                let addressString = '';

                if (address.streetName && address.municipality && address.postalCode) {
                    addressString = `${address.streetName}, ${address.municipality}, ${address.postalCode}`;
                } else if (address.streetName) {
                    addressString = address.streetName;
                } else if (address.municipality) {
                    addressString = address.municipality;
                } else if (address.postalCode) {
                    addressString = address.postalCode;
                }

                // Aggiungi solo indirizzi unici
                if (addressString && !addedAddresses.has(addressString)) {
                    addedAddresses.add(addressString);
                    let suggest = document.createElement('option');
                    suggest.value = addressString;
                    datalist.appendChild(suggest);
                }
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            // Gestisci l'errore qui, ad esempio mostrando un messaggio di errore all'utente
            selectedAddress = false;
        });

    addressInput.addEventListener('change', function() {
        const options = Array.from(datalist.options);
        selectedAddress = options.some(option => option.value === addressInput.value);

        if (selectedAddress) {
            addressInput.classList.remove('is-invalid');
            autocompleteError.textContent = '';
        }
    });
});

addressInput.addEventListener('blur', function() {
    const options = Array.from(document.getElementById('locality').options);
    selectedAddress = options.some(option => option.value === addressInput.value);

    if (!selectedAddress) {
        addressInput.classList.add('is-invalid');
        autocompleteError.textContent = 'you must select a suggest address';
    } else {
        addressInput.classList.remove('is-invalid');
        autocompleteError.textContent = '';
    }
});

addressForm.addEventListener('submit', function(event) {
    const options = Array.from(document.getElementById('locality').options);
    selectedAddress = options.some(option => option.value === addressInput.value);

    if (!selectedAddress) {
        addressInput.classList.add('is-invalid');
        autocompleteError.textContent = 'you must select a suggest address';
        event.preventDefault(); // Impedisce l'invio del modulo
    } else {
        addressInput.classList.remove('is-invalid');
        autocompleteError.textContent = '';
    }
});





