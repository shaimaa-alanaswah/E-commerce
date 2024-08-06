@extends('layouts.app')
@section('content')

<section class="container-fluid mt-5 my-3 py-5">
    <div class="container mt-2 text-center">
        <h4>Payment</h4>
        @if (Session::has('total') && Session::get('total') != null)
            @if (Session::has('order_id') && Session::get('order_id') != null)
                <h4 style="color: blue" class="my-5">Total: ${{ Session::get('total') }}</h4>
                <center>
                    <a href="{{ route('paypal.payment') }}" class="btn btn-success"  id="paypal-button-container" style="max-width:300px;">Pay with PayPal</a>
                </center>
            @endif
        @endif
    </div>
</section>

<div class="card-body">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ $message }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


</div>








@endsection
