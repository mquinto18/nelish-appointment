<div class='flex flex-col sm:flex-row gap-2 mb-6 py-2 justify-center bg-white'>
    <div class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment') || request()->is('home/services-appointment') ? 'font-medium  text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        
        <span>SELECT SERVICES ></span>
    </div>
    <div class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment/appointmentDate') || request()->is('home/services-appointment/appointmentDate') ? 'font-medium  text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
       
        <span>SELECT DATE ></span>
    </div>
    <div class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment/appointmentTime') || request()->is('home/services-appointment/appointmentTime') ? 'font-medium  text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>SELECT THERAPIST AND TIME ></span>
    </div>
    <div class='flex justify-center items-center gap-2 cursor-pointer py-2 px-4 text-lg text-gray {{ request()->is('home/services-appointment/appointmentConfirm') || request()->is('home/services-appointment/appointmentConfirm') ? 'font-medium  text-bold' : 'border-b-2 border-b-transparent hover:border-b-blue-700' }}'>
        <span>CONFIRMATION ></span>
    </div>
</div>