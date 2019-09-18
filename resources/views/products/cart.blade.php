@extends('layouts.front')
@section('cart_css')
<style>

.total {
  float: right;
  display: block;
  overflow: auto;
}

.total span {
  color: #07c750;
  display: inline-block;
  margin-left: 20px;
  font-weight:800;
}
</style>
@endsection
@section('content')
<main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Album example</h1>
                <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don't simply skip over it entirely.</p>
                <p>
                    <a href="#" class="btn btn-primary my-2">Main call to action</a>
                    <a href="#" class="btn btn-secondary my-2">Secondary action</a>
                </p>
            </div>
        </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">

            <div class="col-md-3">
                <h2 class="category_head">Top Categories</h2>
                <ul>
                    @if($categories)
                    @foreach( $categories as $category)
                        <li>{{$category->title}}</li>
                    @endforeach
                    @endif
                
                </ul>
            </div>

            <div class="col-md-9">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                        <th scope="col" width="20%">Product Image</th>
                        <th scope="col" width="50%">Name</th>
                        <th scope="col" width="10%">Price</th>
                        <th scope="col" width="10%">Quantity</th>
                        <th width="5%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($cart !== '')
                    @foreach($cart->getContents() as $slug=> $product)
                    
                    
                        <tr>
                            <td><img src="{{asset($product['product']->thumbnail)}}" alt="" width="50" height="50"></td>
                            <td>{{$product['product']->title}}</td>
                            <td>
                            {{$product['price']}}<br>
                            <small>(Each price {{$product['product']->price}})</small>
                            </td>
                            <td>
                            <form method="GET" action="{{route('cart.update',$product)}}">
                            @csrf
                                <input type="number" name="qty" id="" value="{{$product['qty']}}" min="1">
                                <input type="submit" value="Update" class="btn btn-success">
                            </form>
                            </td>
                            <form action="{{route('cart.remove',$product)}}" method="GET">
                                @csrf
                                <td><input type="submit" value="Remove" class="btn btn-danger"></td>
                            </form>
                        </tr>
                    
                    @endforeach 
                    
                    @else

                    <tr>
                        <td>There is no products in cart.</td>
                    </tr>
                    @endif
                    </tbody>
                </table>
                <div class="total">
                @if($cart !== '')
                    <span>Total Quantity: {{$cart->getTotalQty()}}</span>   
                    <span>Total price : {{$cart->getTotalPrice()}}</span> 
                @endif
                
                </div>
            </div>
        
        </div>
        </div>
    </div>

</main>
@endsection