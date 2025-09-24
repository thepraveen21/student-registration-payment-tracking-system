<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students Dashboard</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 25px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-box input {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            min-width: 250px;
        }
        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: background 0.3s, transform 0.2s;
        }
        .btn-add {
            background: #2563eb;
            color: white;
        }
        .btn-add:hover {
            background: #1e40af;
            transform: scale(1.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table th, table td {
            padding: 12px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background: #e2e8f0;
        }
        table tr:hover {
            background: #f8fafc;
        }
        .qr-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination a, .pagination span {
            padding: 6px 10px;
            margin: 0 2px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }
        .pagination .active {
            background: #2563eb;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>📋 Student Dashboard</h1>

        <div class="top-bar">
            <!-- Search -->
            <form method="GET" action="{{ route('admin.students.index') }}" class="search-box">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, reg no...">
            </form>

            <!-- Add Student -->
            <a href="{{ url('/admin/students/create') }}" class="btn btn-add">➕ Add New Student</a>
        </div>

        <!-- Student Table -->
        <table>
            <thead>
                <tr>
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Student Phone</th>
                    <th>Parent Phone</th>
                    <th>Course</th>
                    <th>Date of Birth</th>
                    <th>QR</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                <tr>
                    <td>{{ $student->registration_number }}</td>
                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->student_phone }}</td>
                    <td>{{ $student->parent_phone }}</td>
                    <td>{{ $student->course_id }}</td>
                    <td>{{ $student->date_of_birth }}</td>
                    <td>
                        @if($student->qr_code_path)
                            <img src="{{ asset($student->qr_code_path) }}" alt="QR Code" class="qr-img">
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:20px;">No students found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            {{ $students->links() }}
        </div>
    </div>

</body>
</html>
