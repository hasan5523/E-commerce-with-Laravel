@extends('layouts.front')
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
                <div class="row">
                    <div class="col-md-7">
                        <div class="card mb-4 box-shadow">
                            <img class="card-img-top img-thumbnail img-responsive" src="{{asset($product->thumbnail)}}" alt="">
                            
                        </div>
                    </div>
                    <div class="col-md-5">

                        <div class="">
                        <h2>  {{$product->title}}</h2>
                        <p class="card-text">{!! $product->description !!}</p>
                                <div class="btn-group">
                                <a  href="" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                                </div>
                                
                        </div>
                        
                    </div>
                </div>
            </div>
        
        </div>
        </div>
    </div>

</main>
@endsection