<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - <?php echo e($qr->code); ?></title>
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>QR: <?php echo e($qr->code); ?></h1>

    <?php if(! $student): ?>
        <div class="alert alert-warning">This QR code is not assigned to any student.</div>
        <div>
            <img src="<?php echo e(asset($qr->qr_image_path)); ?>" alt="QR" style="max-width:300px;">
        </div>
    <?php else: ?>

    <div class="card mb-3">
        <div class="card-body">
            <h2><?php echo e($student->full_name); ?> (<?php echo e($student->registration_number); ?>)</h2>
            <p><strong>Course:</strong> <?php echo e(optional($student->course)->name); ?></p>
            <p><strong>Email:</strong> <?php echo e($student->email); ?></p>
            <p><strong>Phone:</strong> <?php echo e($student->student_phone); ?></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Payments</div>
                <div class="card-body">
                    <p><strong>Total Paid:</strong> <?php echo e(number_format($totalPaid, 2)); ?></p>
                    <table class="table table-sm">
                        <thead><tr><th>Date</th><th>Amount</th><th>Method</th></tr></thead>
                        <tbody>
                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($p->payment_date ? \Carbon\Carbon::parse($p->payment_date)->format('Y-m-d') : '-'); ?></td>
                                <td><?php echo e(number_format($p->amount, 2)); ?></td>
                                <td><?php echo e($p->payment_method); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header">Attendance</div>
                <div class="card-body">
                    <?php if($latestAttendance): ?>
                        <p><strong>Last:</strong> <?php echo e($latestAttendance->attended_at ? \Carbon\Carbon::parse($latestAttendance->attended_at)->format('Y-m-d H:i') : '-'); ?> (<?php echo e($latestAttendance->status); ?>)</p>
                        <p><?php echo e($latestAttendance->notes); ?></p>
                    <?php else: ?>
                        <p>No attendance records yet.</p>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('qr.attendance', $qr->code)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="status">Mark as</label>
                            <select name="status" id="status" class="form-control">
                                <option value="present">Present</option>
                                <option value="absent">Absent</option>
                                <option value="late">Late</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control"></textarea>
                        </div>
                        <button class="btn btn-primary mt-2">Mark Attendance</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">QR Image</div>
                <div class="card-body">
                    <img src="<?php echo e(asset($qr->qr_image_path)); ?>" alt="QR" style="max-width:250px;">
                </div>
            </div>
        </div>
    </div>
</div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\Innovior\Student Management System\resources\views/qr/show.blade.php ENDPATH**/ ?>