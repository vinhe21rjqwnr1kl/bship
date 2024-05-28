'use strict';

let formatter = new Intl.NumberFormat('vi-VN', {style: 'currency', currency: 'VND'});

function renderTableInfo(data) {
    var restaurantName = exampleModal.querySelector('.restaurant-name');
    var restaurantAddress = exampleModal.querySelector('.restaurant-address');
    var restaurantPhone = exampleModal.querySelector('.restaurant-phone');
    var totalOrderPrice = exampleModal.querySelector('#total-order-price');
    totalOrderPrice.textContent = '';
    totalOrderPrice.textContent = formatter.format(data.totalOrderPrice);
    restaurantName.textContent = '';
    restaurantAddress.textContent = '';
    restaurantPhone.textContent = '';
    restaurantName.textContent = data.food_order.restaurant.name;
    restaurantAddress.textContent = data.food_order.restaurant.address;
    restaurantPhone.textContent = data.food_order.restaurant.phone;
}

function renderTableProductsOrder(data) {
    var tableBody = document.querySelector('#prrductsOrder tbody');
    tableBody.textContent = '';

    data.forEach(function (item) {
        var row = document.createElement('tr');
        row.innerHTML =
            '<td>' + item.product.name + '</td>' +
            '<td>' + item.size_name + '</td>' +
            '<td>' + item.quantity + '</td>' +
            '<td>' + formatter.format(item.price) + '</td>' +
            '<td><img src="' + item.product.img_url + '" alt="' + item.product.name + '"class="img-fluid rounded" style="max-width: 150px;"></td>';
        tableBody.appendChild(row);
    });
}

async function renderImage(imageUrls) {
    var container = document.getElementById('image-container');
    container.innerHTML = '';
    if (imageUrls) {
        var cleanedJsonString = imageUrls.replace(/\\/g, '');
        var jsonObject = JSON.parse(cleanedJsonString);

        try {
            var promises = [];
            for (let imageUrl of Object.values(jsonObject)) {
                if (imageUrl !== '') {
                    var imgPromise = new Promise((resolve, reject) => {
                        var imgElement = document.createElement('img');
                        imgElement.onload = function () {
                            resolve(imgElement);
                        };
                        imgElement.onerror = function () {
                            reject(new Error('Failed to load image: ' + imageUrl));
                        };
                        imgElement.src = imageUrl;
                    });
                    promises.push(imgPromise);
                }
            }
            var images = await Promise.all(promises);
            images.forEach(imgElement => {
                imgElement.classList.add('rounded', 'my-2', 'mx-2', 'col-md-9');
                container.appendChild(imgElement);
            });
        } catch (error) {
            console.error(error);
        }
    }
}

function renderDeliveryGoInfo(data) {
    var name = receiverGoInfoModal.querySelector('.receiver-name');
    var phone = receiverGoInfoModal.querySelector('.receiver-phone');
    var address = receiverGoInfoModal.querySelector('.receiver-address');
    var size = receiverGoInfoModal.querySelector('.product-size');
    var weight = receiverGoInfoModal.querySelector('.product-weight');
    var category = receiverGoInfoModal.querySelector('.product-category');
    name.textContent = "";
    phone.textContent = "";
    address.textContent = "";
    size.textContent = "";
    weight.textContent = "";
    category.textContent = "";
    if (data) {
        name.textContent = data.receiver_name;
        phone.textContent = data.receiver_phone;
        address.textContent = data.receiver_address;
        size.textContent = data.product_size;
        weight.textContent = data.product_weight;
        category.textContent = data.product_category;
    }
}

async function handleService(service, api
) {
    try {
        $.ajax({
            url: api,
            type: 'GET',
            success: function (response) {
                if (service == 'food') {
                    renderTableInfo(response.data);
                    renderTableProductsOrder(response.data.food_order.items);
                } else if (service == 'delivery') {
                    renderDeliveryGoInfo(response.data);
                    renderImage(response.data.product_image);
                } else {
                    console.error('Unknown serviceId:', serviceId);
                }
            }
        })


    } catch (error) {
        // Handle errors
    }
}

var exampleModal = document.getElementById('exampleModal');
var receiverGoInfoModal = document.getElementById('receiverGoInfoModal');

receiverGoInfoModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var service = button.getAttribute('data-bs-service');
    var id = button.getAttribute('data-bs-id');
    // var apiTemp = '{{ route("trip.admin.detail", ["service" => ":service", "go_id" => ":id"] ) }}';
    var api = apiTemp.replace(':service', service).replace(':id', id);

    if (service == 'food' || service == 'delivery') {
        handleService(service, api);
    } else {
        console.error('Invalid service:', service);
    }
})

exampleModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var service = button.getAttribute('data-bs-service');
    var id = button.getAttribute('data-bs-id');
    // var apiTemp = '{{ route("trip.admin.detail", ["service" => ":service", "go_id" => ":id"] ) }}';
    var api = apiTemp.replace(':service', service).replace(':id', id);

    if (service == 'food' || service == 'delivery') {
        handleService(service, api);
    } else {
        console.error('Invalid service:', service);
    }
})

