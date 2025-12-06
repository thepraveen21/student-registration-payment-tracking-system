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
            <p>Generated on: <?php echo e(date('Y-m-d')); ?></p>
        </div>

        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <h2><?php echo e($course->name); ?> (<?php echo e($course->students_count); ?> Students)</h2>
            <?php if($course->students->count() > 0): ?>
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
                        <?php $__currentLoopData = $course->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($student->id); ?></td>
                                <td><?php echo e($student->full_name); ?></td>
                                <td><?php echo e($student->email); ?></td>
                                <td><?php echo e(ucfirst($student->status)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No students enrolled in this course.</p>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</body>
</html>
<?php /**PATH G:\Projects\innovior info\Student Management System\resources\views/admin/reports/pdf/course-wise-students.blade.php ENDPATH**/ ?>