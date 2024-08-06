@extends('layouts.app')

@section('content')
<div id="products">
    <div class="container">
        <div class="section-header">
            <h2>Get Your Products</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra at massa sit amet ultricies
            </p>
        </div>
        <div class="row align-items-center">
            @foreach ($products as $product)
            <div class="col-md-3 mt-1">
                <div class="product-single">
                    <div class="product-img">
                        <img style="mix-blend-mode: multiply;" src="{{ asset('img/'.$product->image) }}" alt="Product Image">
                    </div>
                    <div class="product-content">
                        <h2><a href="{{ route('single_product', ['id' => $product->id]) }}">{{ $product->name }}</a></h2>
                        @if ($product->sale_price != null)
                        <h3>{{ $product->sale_price }}</h3>
                        <h3 style="text-decoration: line-through;">{{ $product->price }}</h3>
                        @else
                        <h3>{{ $product->price }}</h3>
                        @endif
                        <form method="POST" action="{{ route('add_to_cart') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price" value="{{ $product->price }}">
                            <input type="hidden" name="sale_price" value="{{ $product->sale_price }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="image" value="{{ $product->image }}">
                            <input type="submit" value="Add to Cart" class="btn">
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $products->links() }}

    </div>
</div>



@endsection
