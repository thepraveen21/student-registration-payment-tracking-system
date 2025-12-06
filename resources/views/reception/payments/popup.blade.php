<div class="payment-modal">

    <div class="modal-content">

        <h3 class="modal-title">Record Payment</h3>

        <div class="student-details">
            <strong>Student:</strong> {{ $student->first_name }} {{ $student->last_name }}<br>
            <strong>Student ID:</strong> {{ $student->student_id }}<br>
            <strong>Course:</strong> {{ $student->course->name ?? 'N/A' }}<br>
            <strong>Center:</strong> {{ $student->center->name ?? 'N/A' }}
        </div>

        <form id="paymentForm">

            <input type="hidden" name="student_id" value="{{ $student->id }}">

            <label>Amount</label>
            <input type="number" name="amount" class="form-control" required>

            <label>Payment Method</label>
            <select name="payment_method" class="form-control" required>
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            <label>Payment Date</label>
            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">

            <label>Notes (Optional)</label>
            <textarea name="notes" class="form-control"></textarea>

            <button type="submit" class="btn btn-primary w-100 mt-3">Save Payment</button>

        </form>

    </div>

</div>

<style>
.payment-modal {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    display: flex; align-items: center; justify-content: center;
    padding: 20px;
    z-index: 99999;
}

.modal-content {
    background: white;
    padding: 25px;
    width: 420px;
    border-radius: 12px;
    animation: fadeIn .3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.modal-title {
    font-size: 20px;
    margin-bottom: 15px;
}

.student-details {
    background: #f1f1f1;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    font-size: 14px;
}
</style>

<script>
document.querySelector("#paymentForm").addEventListener("submit", function(e) {
    e.preventDefault();

    fetch("{{ route('reception.payments.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json",
        },
        body: JSON.stringify(Object.fromEntries(new FormData(this))),
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert("Payment saved successfully.");
            location.reload();
        } else {
            alert(data.message || "Error saving payment.");
        }
    });
});
</script>
