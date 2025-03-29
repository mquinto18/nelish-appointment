@extends('layouts.user')

@section('title', 'Home')

@section('contents')

<style>
    body {
        background-color: #074F46;
    }

    /* Sticky Header */
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1000;

        display: flex;
        justify-content: flex-start;
        /* Align elements to the left */
        align-items: center;
        padding: 10px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        gap: 20px;
        /* Add spacing between logo and navigation */
    }

    .sticky-header .logo-container {
        display: flex;
        align-items: center;
    }

    .sticky-header .logo {
        height: 40px;
        margin-right: 10px;
    }

    .sticky-header nav {
        display: flex;
    }

    .sticky-header nav ul {
        display: flex;
        list-style: none;
        gap: 15px;
        /* Add spacing between navigation items */
    }

    .sticky-header nav ul li a {
        color: #FFFFFF;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .sticky-header nav ul li a:hover {
        color: #FFCC80;
    }

    .sticky-header .header-right {
        margin-left: auto;
        /* Push the "Book Now!" button and user icon to the far right */
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .sticky-header .book-now {
        background-color: #FF9800;
        color: #FFFFFF;
        padding: 8px 15px;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .sticky-header .book-now:hover {
        background-color: #FFA726;
        transform: scale(1.1);
    }

    .sticky-header .user {
        height: 40px;
    }

    /* Progress Bar */
    .progress-bar {
        display: flex;
        justify-content: space-around;
        background-color: #FFFFF3;
        padding: 10px 0;
    }

    .progress-bar .step {
        font-size: 14px;
        font-weight: bold;
        color: #333333;
    }

    .progress-bar .step.active {
        color: #074F46;
    }

    .progress-bar .step.faded {
        opacity: 0.41;
    }

    /* Main Layout */
    main {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .sidebar {
        width: 100%;

        padding: 20px;
        border-radius: 10px;
    }

    .sidebar h2 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .sidebar .gender {
        margin-bottom: 20px;
    }

    .sidebar .gender label {
        display: block;
        margin-bottom: 5px;
    }

    .sidebar .gender select {
        width: 100%;
        padding: 5px;
        border: none;
        border-radius: 5px;
        background-color: #004d40;
        color: #ffffff;
    }

    .services {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 5px;
    }

    /* Service Box Styles */
    .services .service {
        display: flex;
        align-items: center;
        padding: 10px;
        background-color: #004d40;
        border: 2px solid white;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-bottom: 10px;
    }

    .services .service:hover {
        background-color: #00564d;
    }

    /* Ensures all service images have the same size */
    .services .service img {
        width: 80px;
        /* Fixed width for consistency */
        height: 80px;
        /* Fixed height for consistency */
        margin-right: 10px;
        border-radius: 5px;
        object-fit: cover;
        /* Maintains aspect ratio without distortion */
    }

    .services .service p {
        font-size: 14px;
        color: #ffffff;
    }

    /* Details Section */
    .details {

        width: 100%;
        background-color: #004d40;
        border-radius: 10px;

    }

    .details-container {}

    .details .service-image {
        width: 70%;
        border-radius: 55px;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .details .service-image:hover {
        transform: scale(1.05);
    }

    .details .service-title {
        font-size: 24px;
        margin: 20px 0 10px;
    }

    .details .service-description {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .details .service-price {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .details .booking-options h3 {
        font-size: 16px;
        margin-bottom: 10px;
    }

    .details .quantity-selector {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .details .quantity-selector button {
        padding: 5px 10px;
        font-size: 18px;
        cursor: pointer;
        background-color: #FF9800;
        border: none;
        color: white;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .details .quantity-selector button:hover {
        background-color: #FFC300;
    }

    .details .quantity-selector input {
        width: 50px;
        text-align: center;
    }

    .details .add-services-btn {
        padding: 10px 20px;
        background-color: #FF9800;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 10px;
    }

    .details .add-services-btn:hover {
        background-color: #FFA726;
        transform: scale(1.05);
    }

    .details .next-btn {
        padding: 10px 20px;
        background-color: #FF9800;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        margin-top: 10px;
    }

    .details .next-btn:hover {
        background-color: #FFC300;
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        main {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
        }



        .progress-bar {
            flex-direction: column;
            align-items: center;
        }

        .progress-bar .step {
            margin-bottom: 10px;
        }

    }
</style>
<div>
    @include('appointment.navigation')
    <div class="relative w-full h-[500px] sm:h-[600px] md:h-[700px] text-white">
        <main class="flex mx-10 gap-5">
            <aside class="sidebar">
                <div class="flex justify-between items-center">
                    <div class="quantity-selector flex gap-2 mt-4">
                        <h2>How many people?</h2>
                        <div>
                            <select id="peopleCount" name="people_count" class="w-16 text-center text-black border border-gray-300 rounded py-1">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" id="redoSelection" class="bg-green-500 text-white px-4 py-2 rounded">
                        Redo Selection
                    </button>
                </div>
                <h2>Select Services</h2>
                <div class="services">
                    @foreach ([
                    ['deep-tissue', 'DEEP TISSUE MASSAGE.jpg', 'Deep Tissue Massage'],
                    ['body-scrub', 'BODY SCRUB MASSAGE.jpg', 'Body Scrub'],
                    ['aromatherapy', 'AROMATHERAPY.jfif', 'Aromatherapy'],
                    ['body-scrub-whole', 'BODY_SCRUB.jpg', 'Body Scrub with Whole Body Massage'],
                    ['foot-reflex', 'FOOT REFLEX MASSAGE.jpg', 'Foot Reflex Massage'],
                    ['foot-scrub', 'FOOT_MASSAGE.jpeg', 'Foot Scrub with Massage'],
                    ['head-ear', 'HEAD_CANDLING.jpg', 'Head & Ear Face Massage with Ear Candling'],
                    ['kids-relaxing', 'KIDS_MASSAGE.jpg', 'Kids Relaxing Massage'],
                    ['lava-stone', 'LAVA STONE MASSAGE.jpg', 'Lava Stone Massage'],
                    ['shiatsu-dry', 'Shiatsu_Massage.jpg', 'Shiatsu Dry Massage'],
                    ['ventosa', 'VENTOSA WITH MASSAGE.jpg', 'Ventosa with Massage']
                    ] as $service)
                    <div class="service" data-service="{{ $service[0] }}">
                        <img src="{{ asset('images/' . $service[1]) }}" alt="{{ $service[2] }}">
                        <p>{{ $service[2] }}</p>
                    </div>
                    @endforeach
                </div>
            </aside>
            <form action="{{ route('services.save') }}" method="POST" class="service-booking-form" onsubmit="updateSelectedServices()">
                @csrf
                <div class="bg-[#FFFFDB] my-10 mx-10 w-[500px] rounded-md flex flex-col justify-between min-h-[400px]">
                    <div class="text-black border-b-2 py-6 border-black">
                        <h1 class="text-center text-[30px]">Booking Summary</h1>
                    </div>
                    <div class="p-10 text-black leading-3 flex-grow">
                        <div class="selected-services">
                            <p id="noBookingMessage" class="text-center text-gray-500">No booking yet</p>
                        </div>
                        <div class="mt-4">
                            <p class="font-medium">Choose Duration:</p>
                            <label><input type="radio" name="duration" value="60" checked> 60 minutes</label>
                            <label><input type="radio" name="duration" value="90"> 90 minutes</label>
                        </div>
                        <p class="text-black font-bold mt-4">Total Price: <span class="service-price">₱0.00</span></p>
                    </div>
                    <input type="hidden" name="service_title" id="hiddenServiceTitle">
                    <input type="hidden" name="service_price" id="hiddenServicePrice">
                    <input type="hidden" name="people_count" id="peopleCountInput" value="1">
                    <input type="hidden" name="selected_services" id="selectedServicesInput" value="null">
                    <div class="p-4 border-t border-black text-center">
                        <button type="submit" class="next-btn text-black bg-yellow-400 px-6 py-2 rounded-md">Continue</button>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
<style>
    .service.selected {
        border: 2px solid #FFD700;
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedServices = [];
        const peopleCountSelect = document.getElementById("peopleCount");
        const selectedContainer = document.querySelector(".selected-services");
        let maxSelections = parseInt(peopleCountSelect.value, 10);

        function updateMaxSelections() {
            maxSelections = parseInt(peopleCountSelect.value, 10);
            selectedServices = selectedServices.slice(0, maxSelections);
            updateSelectedServices();
        }

        peopleCountSelect.addEventListener("change", updateMaxSelections);

        document.querySelectorAll(".service").forEach(service => {
            service.addEventListener("click", function() {
                if (selectedServices.length >= maxSelections) {
                    alert(`You can only select ${maxSelections} services.`);
                    return;
                }
                const serviceType = this.getAttribute("data-service");
                const title = this.querySelector("p").innerText;
                const price = getPrice(serviceType);
                selectedServices.push({
                    title,
                    price
                });
                this.classList.add("selected");
                updateSelectedServices();
            });
        });

        function updateSelectedServices() {
            selectedContainer.innerHTML = "";
            let totalPrice = 0;
            let serviceTitles = [];
            selectedServices.forEach((service, index) => {
                const serviceItem = document.createElement("div");
                serviceItem.classList.add("border-b", "py-2");
                serviceItem.innerHTML = `<p class="text-black font-bold">Person ${index + 1}: ${service.title}</p>
                                         <p class="text-black">₱${service.price.toFixed(2)}</p>`;
                selectedContainer.appendChild(serviceItem);
                totalPrice += service.price;
                serviceTitles.push(service.title);
            });
            document.querySelector(".service-price").innerText = `₱${totalPrice.toFixed(2)}`;
            document.getElementById("hiddenServiceTitle").value = JSON.stringify(serviceTitles);
            document.getElementById("hiddenServicePrice").value = totalPrice;
        }

        function getPrice(serviceType) {
            const prices = {
                'deep-tissue': 1980.00,
                'body-scrub': 1500.00,
                'aromatherapy': 1750.00,
                'body-scrub-whole': 2200.00,
                'foot-reflex': 1200.00,
                'foot-scrub': 1150.00,
                'head-ear': 1800.00,
                'kids-relaxing': 1000.00,
                'lava-stone': 2500.00,
                'shiatsu-dry': 1700.00,
                'ventosa': 1600.00
            };
            return prices[serviceType] || 0.00;
        }

        document.getElementById("redoSelection").addEventListener("click", function() {
            selectedServices = [];
            document.querySelectorAll(".service").forEach(service => service.classList.remove("selected"));
            updateSelectedServices();
        });

        document.getElementById("peopleCount").addEventListener("change", function() {
            document.getElementById("peopleCountInput").value = this.value;
        });
    });
</script>

@endsection