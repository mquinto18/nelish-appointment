@extends('layouts.admin')

@section('title', 'Appointment')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="shadow-lg shadow-black">
    <div class="p-3">
        <h1 class="text-[30px] text-white">Transaction History</h1>

        <div class="bg-white w-full p-3 rounded-md">
            <!-- Filter Form -->
            <div class="flex justify-between my-3">
                <form method="GET" action="{{ route('transaction.history') }}" class="flex items-center space-x-2 mb-3">
                    <label for="year">Year</label>
                    <select name="year" id="year" class="border p-2 rounded">
                        <option value="">Select Year</option>
                        @foreach (range(date('Y'), 2000) as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>

                    <label for="month">Month</label>
                    <select name="month" id="month" class="border p-2 rounded">
                        <option value="">Select Month</option>
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-[#096156] text-white px-4 py-2 rounded">Apply</button>
                </form>

                <!-- Download Report Button -->
                <button class="float-right border py-2 px-3 rounded-lg mb-3">
                    <a href="{{ route('transaction.download', ['year' => request('year'), 'month' => request('month')]) }}" class="no-underline text-black font-bold">Download Reports</a>
                </button>
            </div>
            

            <!-- Transactions Table -->
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-[#FAFAD2] text-left">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Name</th>
                        <th class="border border-gray-300 px-4 py-2">Gender</th>
                        <th class="border border-gray-300 px-4 py-2">Appointment Date</th>
                        <th class="border border-gray-300 px-4 py-2">Services</th>
                        <th class="border border-gray-300 px-4 py-2">Therapist</th>
                        <th class="border border-gray-300 px-4 py-2">Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($appointments as $appointment)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->gender ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ \Carbon\Carbon::parse($appointment->date)->format('F d, Y') }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ is_array(json_decode($appointment->services, true)) ? implode(', ', json_decode($appointment->services, true)) : $appointment->services }}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">{{ $appointment->therapist ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">₱{{ number_format($appointment->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($appointments->isEmpty())
            <p class="text-center text-gray-500 mt-4">No completed transactions available.</p>
            @endif
        </div>
    </div>
</div>

@endsection
