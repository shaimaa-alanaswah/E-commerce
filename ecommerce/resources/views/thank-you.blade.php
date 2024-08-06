@extends('layouts.app')
@section('content')
<section class="container-fluid mt-5 my-3 py-5">
    <div class="container mt-2 text-center">
        <h4>Thank You for Your Order!</h4>
        <p>Your order ID is: {{ $order_id }}</p>
        <p>Estimated Delivery Date: {{ $delivery_date }}</p>
    </div>
</section>
@endsection
