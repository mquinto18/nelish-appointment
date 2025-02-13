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
        <main>
            <aside class="sidebar">
                <h2>Select Services</h2>
                <div class="gender">
                    <label for="gender">Are you a?</label>
                    <select id="gender">
                        <option value="">Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>


                <div class="services">
                    <div class="service" data-service="deep-tissue">
                        <img src="{{ asset('images/DEEP TISSUE MASSAGE.jpg') }}" alt="Deep Tissue Massage">
                        <p>Deep Tissue Massage</p>
                    </div>
                    <div class="service" data-service="body-scrub">
                        <img src="{{ asset('images/BODY SCRUB MASSAGE.jpg') }}" alt="Body Scrub">
                        <p>Body Scrub</p>
                    </div>
                    <div class="service" data-service="aromatherapy">
                        <img src="{{ asset('images/AROMATHERAPY.jfif') }}" alt="Aromatherapy">
                        <p>Aromatherapy</p>
                    </div>
                    <div class="service" data-service="body-scrub-whole">
                        <img src="{{ asset('images/BODY_SCRUB.jpg') }}" alt="Body Scrub with Whole Body Massage">
                        <p>Body Scrub with Whole Body Massage</p>
                    </div>
                    <div class="service" data-service="foot-reflex">
                        <img src="{{ asset('images/FOOT REFLEX MASSAGE.jpg') }}" alt="Foot Reflex Massage">
                        <p>Foot Reflex Massage</p>
                    </div>
                    <div class="service" data-service="foot-scrub">
                        <img src="{{ asset('images/FOOT_MASSAGE.jpeg') }}" alt="Foot Scrub with Massage">
                        <p>Foot Scrub with Massage</p>
                    </div>
                    <div class="service" data-service="head-ear">
                        <img src="{{ asset('images/HEAD_CANDLING.jpg') }}" alt="Head & Ear Face Massage with Ear Candling">
                        <p>Head & Ear Face Massage with Ear Candling</p>
                    </div>
                    <div class="service" data-service="kids-relaxing">
                        <img src="{{ asset('images/KIDS_MASSAGE.jpg') }}" alt="Kids Relaxing Massage">
                        <p>Kids Relaxing Massage</p>
                    </div>
                    <div class="service" data-service="lava-stone">
                        <img src="{{ asset('images/LAVA STONE MASSAGE.jpg') }}" alt="Lava Stone Massage">
                        <p>Lava Stone Massage</p>
                    </div>
                    <div class="service" data-service="shiatsu-dry">
                        <img src="{{ asset('images/Shiatsu_Massage.jpg') }}" alt="Shiatsu Dry Massage">
                        <p>Shiatsu Dry Massage</p>
                    </div>
                    <div class="service" data-service="ventosa">
                        <img src="{{ asset('images/VENTOSA WITH MASSAGE.jpg') }}" alt="Ventosa with Massage">
                        <p>Ventosa with Massage</p>
                    </div>
                </div>

            </aside>

            <form action="{{ route('services.save') }}" method="POST" class="service-booking-form">
                @csrf
                <section class="details-container">
                    <section class="details">
                        <img src="" alt="" class="service-image">
                        <h1 class="service-title">{{ $serviceTitle ?? '' }}</h1>
                        <p class="service-description"></p>
                        <p class="service-price">{{ $servicePrice ?? '' }}</p>

                        <!-- Choose Duration -->
                        <div class="booking-options">
                            <h3>Choose Duration:</h3>
                            <label>
                                <input type="radio" name="duration" value="60" checked> 60 minutes
                            </label>
                            <label>
                                <input type="radio" name="duration" value="90"> 90 minutes
                            </label>
                            <p class="note">
                                Note: Usage of facilities and preparation time for the next guest is included in the time blocking.
                            </p>

                            <!-- How Many People -->
                            <h3>How Many People?</h3>
                            <div class="quantity-selector">
                                <button type="button" class="decrease" onclick="updateQuantity(-1)">-</button>
                                <input type="number" class="quantity text-black" name="people_count" min="1" value="1" id="peopleCount">
                                <button type="button" class="increase" onclick="updateQuantity(1)">+</button>
                            </div>
                        </div>

                        <!-- Hidden fields to store service title, price, and other data -->
                        <input type="hidden" name="service_title" id="hiddenServiceTitle" value="{{ $serviceTitle ?? '' }}">
                        <input type="hidden" name="service_price" id="hiddenServicePrice" value="{{ $servicePrice ?? '' }}">

                        <button type="submit" class="next-btn">Next</button>
                    </section>
                </section>
            </form>


        </main>



    </div>
</div>
<script>
    function updateQuantity(change) {
        const input = document.getElementById('peopleCount');
        let currentValue = parseInt(input.value, 10) || 1;
        const minValue = parseInt(input.min, 10) || 1;

        currentValue += change;

        // Ensure quantity does not go below the minimum
        if (currentValue < minValue) {
            currentValue = minValue;
        }

        input.value = currentValue;
    }

    document.querySelectorAll('.service').forEach(service => {
        service.addEventListener('click', function() {
            const serviceType = this.getAttribute('data-service');

            // Use fixed image paths
            const imageMap = {
                'deep-tissue': 'DEEP TISSUE MASSAGE.jpg',
                'body-scrub': 'BODY SCRUB MASSAGE.jpg',
                'aromatherapy': 'AROMATHERAPY.jfif',
                'body-scrub-whole': 'BODY_SCRUB.jpg',
                'foot-reflex': 'FOOT REFLEX MASSAGE.jpg',
                'foot-scrub': 'FOOT_MASSAGE.jpeg',
                'head-ear': 'HEAD_CANDLING.jpg',
                'kids-relaxing': 'KIDS_MASSAGE.jpg',
                'lava-stone': 'LAVA STONE MASSAGE.jpg',
                'shiatsu-dry': 'Shiatsu_Massage.jpg',
                'ventosa': 'VENTOSA WITH MASSAGE.jpg'
            };

            const imagePath = `{{ asset('images') }}/${imageMap[serviceType]}`;
            const title = this.querySelector('p').innerText;

            // Update the details section
            document.querySelector('.service-image').src = imagePath;
            document.querySelector('.service-image').alt = title;
            document.querySelector('.service-title').innerText = title;
            document.querySelector('.service-description').innerText = getDescription(serviceType);
            document.querySelector('.service-price').innerText = getPrice(serviceType);

            // Update hidden inputs with the selected service data
            document.getElementById('hiddenServiceTitle').value = title;
            document.getElementById('hiddenServicePrice').value = getPrice(serviceType);

            console.log(`Selected Image Path: ${imagePath}`); // Debug
        });
    });

    // Function to return description based on service type
    function getDescription(serviceType) {
        const descriptions = {
            'deep-tissue': 'Deep tissue massage relieves pain, reduces tension, improves posture, and boosts relaxation, circulation, and recovery.',
            'body-scrub': 'Body scrub exfoliates the skin, removes dead cells, and leaves the skin feeling fresh and rejuvenated.',
            'aromatherapy': 'Aromatherapy uses essential oils to relax, reduce stress, and improve mood.',
            'body-scrub-whole': 'A full-body scrub combined with a relaxing massage to rejuvenate both body and mind.',
            'foot-reflex': 'Foot reflexology helps to improve circulation, relieve tension, and promote overall well-being.',
            'foot-scrub': 'A soothing foot scrub combined with a relaxing massage to revitalize tired feet.',
            'head-ear': 'A calming head and ear massage combined with ear candling for relaxation and mental clarity.',
            'kids-relaxing': 'A gentle massage designed to relax and calm children, promoting well-being.',
            'lava-stone': 'A therapeutic lava stone massage that helps reduce muscle tension and stress.',
            'shiatsu-dry': 'Shiatsu dry massage uses pressure points to relax the body and relieve tension.',
            'ventosa': 'Ventosa is a suction therapy combined with a massage to improve circulation and detoxify the body.'
        };
        return descriptions[serviceType] || 'Service description not available';
    }

    // Function to return price based on service type
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
</script>
@endsection