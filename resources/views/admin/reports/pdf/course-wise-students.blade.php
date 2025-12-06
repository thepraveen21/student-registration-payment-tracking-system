<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Course-wise Student Report</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
        }
        .course-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .course-table th, .course-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .course-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .student-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .student-table th, .student-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }
        .student-table th {
            background-color: #e6e6e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Course-wise Student Report</h1>
            <p>Generated on: {{ date('Y-m-d') }}</p>
        </div>

        @foreach ($courses as $course)
            <h2>{{ $course->name }} ({{ $course->students_count }} Students)</h2>
            @if($course->students->count() > 0)
                <table class="student-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($course->students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->full_name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ ucfirst($student->status) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No students enrolled in this course.</p>
            @endif
        @endforeach
    </div>
</body>
</html>
