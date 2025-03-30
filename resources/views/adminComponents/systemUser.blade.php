@extends('layouts.admin')

@section('title', 'Client and Therapist')

@section('contents')
<style>
    body {
        background-color: #096156;
    }
</style>

<div class="shadow-lg shadow-black">
    <div class="p-3">
        <h1 class="text-[30px] text-white">System User</h1>
    </div>

    <div class="p-3">
        <div class="d-flex justify-content-end mb-4">

            <!-- Search Form -->
            <form action="{{ route('systemUser') }}" method="GET" class="d-flex mx-10">
                <input type="text" name="search" class="form-control me-2"
                    placeholder="Search users..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary me-2"><i class="fa-solid fa-magnifying-glass" style="color: #ffffff;"></i></button>
                <a href="{{ route('systemUser') }}" class="btn btn-secondary"><i class="fa-solid fa-rotate-right" style="color: #ffffff;"></i></a>
            </form>
            <!-- Button to trigger modal -->
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                <i class="fa-solid fa-plus" style="color: #096156;"></i>
                Add Employee
            </button>
        </div>

        <div class="bg-white w-full p-3 rounded-md">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr class="text-right">
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->first_name }}</td>
                        <td>{{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role == 'manager' ? 'Therapist' : ($user->role ?? 'N/A') }}</td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="d-flex justify-content-center gap-3">
                                <form action="" method="GET">
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </form>
                                <button type="button" class="text-green-500 hover:text-green-700 view-btn"
                                    data-bs-toggle="modal" data-bs-target="#appointmentModal"
                                    data-id="{{ $user->id }}"
                                    data-name="{{ $user->first_name }} {{ $user->last_name }}"
                                    data-email="{{ $user->email }}"
                                    data-role="{{ $user->role }}">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <form action="" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Bootstrap Modal for Adding Employee -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('save.user') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-3">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" id="password"
                                    placeholder="Enter your password"
                                    required class="form-control"
                                    pattern="^(?=.*[A-Z])(?=.*\d).+$" title="Password must contain at least one uppercase letter and one number.">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Birthday</label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile_number" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <select name="role" class="form-select" required>
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Therapist</option>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS (Ensure Bootstrap is included in your layout) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection