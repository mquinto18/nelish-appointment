<div class='flex flex-col sm:flex-row gap-2 mb-6 py-2 justify-center bg-white'>
    <a href="{{ url('home/services-appointment') }}" class='no-underline text-black flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment') ? 'font-medium text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>SELECT SERVICES ></span>
    </a>

    <a href="{{ url('home/services-appointment/appointmentDate') }}" class='no-underline text-black flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment/appointmentDate') ? 'font-medium text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>SELECT DATE ></span>
    </a>

    <a href="{{ url('home/services-appointment/appointmentTime') }}" class='no-underline text-black flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('dashboard/appointment/select-therapist-time') ? 'font-medium text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>SELECT THERAPIST AND TIME ></span>
    </a>

    <a href="" class='no-underline text-black flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('dashboard/appointment/confirmDetails') ? 'font-medium text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>CONFIRMATION ></span>
    </a>
</div>
