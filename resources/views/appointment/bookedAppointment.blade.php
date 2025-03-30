@extends('layouts.user')

@section('title', 'Booked Appointment')

@section('contents')

<style>
    body {
        background-color: #074F46;
    }
</style>


<div class="h-full">
    <div class="h-12 bg-white"></div>

    <div class="mt-10 mx-10">
        <div class="my-5">
            <h1 class="text-[30px] text-white">Booked Appointment</h1>
        </div>

        <div class="bg-white w-full p-3 rounded-md">

            <table class="table table-bordered">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Appointment Date</th>
                        <th class="text-center">Appointment Time</th>
                        <th class="text-center">Services Type</th>
                        <th class="text-center">Therapist</th>
                        <th class="text-center">Total Amount</th>
                        <th class="text-center">Payment Method</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($appointments->isEmpty())
                    <tr>
                        <td colspan="9" class="py-4 text-center text-gray-500">No appointments found.</td>
                    </tr>
                    @else
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td class="py-3 px-4 border-b">
                            {{ $loop->iteration + ($appointments->currentPage() - 1) * $appointments->perPage() }}
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}
                        </td>
                        <td class="py-3 px-4 border-b">
                            {{ is_array(json_decode($appointment->services, true)) ? implode(', ', json_decode($appointment->services, true)) : $appointment->services }}
                        </td>
                        <td class="py-3 px-4 border-b">{{ $appointment->therapist }}</td>
                        <td class="py-3 px-4 border-b">{{ number_format($appointment->amount, 2) }}</td>
                        <td class="py-3 px-4 border-b">{{ $appointment->payment_method }}</td> 
                        <td class="py-3 px-4 border-b">{{ ucfirst($appointment->status) }}</td>
                        <td class="py-3 px-4 border-b relative">
                            <div x-data="{ open: false }" class="relative">
                                <!-- Three-dot button -->
                                <button @click="open = !open" class="text-gray-600 hover:text-gray-900 text-[20px] font-bold">
                                    &#x22EE; <!-- Unicode for vertical ellipsis (three dots) -->
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-32 bg-white shadow-md rounded-md border z-10">
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline"
                                        data-bs-toggle="modal" data-bs-target="#appointmentModal"
                                        data-id="{{ $appointment->id }}"
                                        data-date="{{ \Carbon\Carbon::parse($appointment->date)->format('F j, Y') }}"
                                        data-time="{{ \Carbon\Carbon::parse($appointment->time)->format('h:i A') }}"
                                        data-services="{{ is_array(json_decode($appointment->services, true)) ? implode(', ', json_decode($appointment->services, true)) : $appointment->services }}"
                                        data-therapist="{{ $appointment->therapist }}"
                                        data-amount="{{ number_format($appointment->amount, 2) }}"
                                        data-payment="Card/Cash"
                                        data-status="{{ ucfirst($appointment->status) }}"
                                        onclick="fillModal(this)">View</a>

                                    @if ($appointment->status === 'Pending')
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">Cancel</a>
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">Reschedule</a>
                                    @elseif ($appointment->status === 'Approved')
                                    <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">Cancel</a>
                                    @elseif ($appointment->status === 'Completed')
                                    <a target="_blank" href="{{ route('appointments.receipt', $appointment->id) }}"
                                        class="block px-4 py-2 text-gray-700 hover:bg-gray-100 no-underline">
                                        Receipt 
                                    </a>
                                    @endif

                                    <!-- Delete option added for all statuses -->
                                    <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="block px-4 py-2 text-red-600 hover:bg-gray-100 no-underline w-full text-left">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            <div class="mt-4">
                {{ $appointments->links() }} <!-- Laravel's built-in pagination links -->
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg "> <!-- Added modal-lg for larger width -->
        <div class="modal-content p-3" style="max-width: 900px; width: 100%;"> <!-- Custom width -->
            <!-- Close Button -->
            <button type="button" class="btn-close position-absolute" style="top: 10px; right: 15px;" data-bs-dismiss="modal" aria-label="Close"></button>

            <!-- Modal Header -->
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalLabel">View Appointment Details</h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="fw-bold">Appointment Date</label>
                        <input type="text" class="form-control" id="modalDate" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Appointment Time</label>
                        <input type="text" class="form-control" id="modalTime" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Service Type</label>
                        <textarea class="form-control" id="modalServices" readonly></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Therapist</label>
                        <textarea class="form-control" id="modalTherapist" readonly></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Total Amount</label>
                        <input type="text" class="form-control" id="modalAmount" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold">Payment Method</label>
                        <input type="text" class="form-control" id="modalPayment" readonly>
                    </div>
                    <div class="col-md-12">
                        <label class="fw-bold">Status</label>
                        <input type="text" class="form-control" id="modalStatus" readonly>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>



<script>
    function fillModal(element) {
        document.getElementById("modalDate").value = element.getAttribute("data-date");
        document.getElementById("modalTime").value = element.getAttribute("data-time");
        document.getElementById("modalServices").value = element.getAttribute("data-services");
        document.getElementById("modalTherapist").value = element.getAttribute("data-therapist");
        document.getElementById("modalAmount").value = element.getAttribute("data-amount");
        document.getElementById("modalPayment").value = element.getAttribute("data-payment");
        document.getElementById("modalStatus").value = element.getAttribute("data-status");
    }
</script>
@endsection