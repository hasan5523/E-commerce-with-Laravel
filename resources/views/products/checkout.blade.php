@extends('layouts.front')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill"> @if(isset($cart)) {{$cart->countProducts()}} @else {{'0'}} @endif</span>
        </h4>
        <ul class="list-group mb-3">
            @if(isset($cart))
                @foreach($cart->getContents() as $slug=> $product)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$product['product']->title}}</h6>
                        <small class="text-muted">{!! $product['product']->description !!}</small>
                    </div>
                    <span class="text-muted">{{$product['product']->price}}</span>
                    </li>
                @endforeach
            
            <li class="list-group-item d-flex justify-content-between lh-condensed">
            <span>Total Price </span>  <span>$ {{$cart->getTotalPrice()}}</span>
            @endif
            </li>
        </ul>

            <form class="card p-2">
                @csrf
                <div class="input-group">
                <input type="text" class="form-control" placeholder="Promo code">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-secondary">Redeem</button>
                </div>
                </div>
            </form>
        </div>
            <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" novalidate="" action="{{route('checkout.store')}}" method='post'>
                    @csrf
                    <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName">First name</label>
                        <input type="text" name="billingFirstName" class="form-control" id="firstName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                        Valid first name is required.
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName">Last name</label>
                        <input type="text" name="billingLastName" class="form-control" id="lastName" placeholder="" value="" required="">
                        <div class="invalid-feedback">
                        Valid last name is required.
                        </div>
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                        <span class="input-group-text">@</span>
                        </div>
                        <input type="text" name="billingUserName" class="form-control" id="username" placeholder="Username" required="">
                        <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                        </div>
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                    <input type="email" name="billingEmail" class="form-control" id="email" placeholder="you@example.com">
                    <div class="invalid-feedback">
                        Please enter a valid email address for shipping updates.
                    </div>
                    </div>

                    <div class="mb-3">
                    <label for="address">Address</label>
                    <input type="text" name="billingAddressOne" class="form-control" id="address" placeholder="1234 Main St" required="">
                    
                    </div>

                    <div class="mb-3">
                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                    <input type="text" name="billingAddressTwo" class="form-control" id="address2" placeholder="Apartment or suite">
                    </div>

                    <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">Country</label>
                        <select name="billingCountry" class="custom-select d-block w-100" id="country" required="">
                        <option value="">Choose...</option>
                        <option>United States</option>
                        </select>
                        <div class="invalid-feedback">
                        Please select a valid country.
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="state">State</label>
                        <select name="billingState" class="custom-select d-block w-100" id="state" required="">
                        <option value="">Choose...</option>
                        <option>California</option>
                        </select>
                        <div class="invalid-feedback">
                        Please provide a valid state.
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zip">Zip</label>
                        <input type="text" name="billingZip" class="form-control" id="zip" placeholder="" required="">
                        <div class="invalid-feedback">
                        Zip code required.
                        </div>
                    </div>
                    </div>
                    <hr class="mb-4">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="shippingAddressSame" class="custom-control-input" id="same-address">
                        <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="save-info">
                        <label class="custom-control-label" for="save-info">Save this information for next time</label>
                    </div>
                   

                    <div id="shipping_add">
                    
                    <hr class="mb-4">
                        <h4 class="mb-3">Shipping Address</h4>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                    <input type="text" name="shippingFirstName" class="form-control" id="firstName" placeholder="" value="" required="">
                                    <div class="invalid-feedback">
                                    Valid first name is required.
                                    </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                    <input type="text" name="shippingLastName" class="form-control" id="lastName" placeholder="" value="" required="">
                                    <div class="invalid-feedback">
                                    Valid last name is required.
                                    </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" name="shippingAddressOne" class="form-control" id="address" placeholder="1234 Main St" required="">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                            <input type="text" name="shippingAddressTwo" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>

                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">Country</label>
                                <select name="shippingCountry" class="custom-select d-block w-100" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                                </select>
                                <div class="invalid-feedback">
                                Please select a valid country.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">State</label>
                                    <select name="shippingState" class="custom-select d-block w-100" id="state" required="">
                                        <option value="">Choose...</option>
                                        <option>California</option>
                                    </select>
                                <div class="invalid-feedback">
                                Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Zip</label>
                                <input name="shippingZip" type="text" class="form-control" id="zip" placeholder="" required="">
                                <div class="invalid-feedback">
                                Zip code required.
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function(){
    
    $('#same-address').on('change',function(){
        //alert('x');
        $('#shipping_add').slideToggle(!this.checked);
    });
});
</script>
@endsection