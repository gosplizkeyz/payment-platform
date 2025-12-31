<!DOCTYPE html>
<html>
<head>
    <title>Payment Page</title>
</head>
<body>
    <h1>Make a Payment</h1>

    @if(session('success'))
        <p style="color: green;">Payment Successful! Reference: {{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul style="color: red;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form method="POST" action="/pay">
        @csrf
        <label>Business ID:</label>
        <input type="number" name="business_id" value="1" required><br><br>

        <label>Amount (in kobo):</label>
        <input type="number" name="amount" value="100000" required><br><br>

        <button type="submit">Pay</button>
    </form>
</body>
</html>
