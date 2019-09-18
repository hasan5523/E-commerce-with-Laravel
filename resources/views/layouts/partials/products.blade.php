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
        @if(session()->has('message'))
          <p>
            {{ session()->get('message')}}
          </p>
        @endif
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
            
            @if($products)
              @foreach( $products as $product)
                
              <div class="col-md-4">
                <div class="card mb-4 box-shadow">
                  <img class="card-img-top  img-responsive" height="150" src="{{asset($product->thumbnail)}}" alt="">
                  <div class="card-body">
                    <p class="card-text">{{$product->title}}</p>
                    <p class="card-text">{!! $product->description !!}</p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <a  href="{{route('products.single',$product)}}" class="btn btn-sm btn-outline-secondary">View Product</a>
                        <a  href="{{route('products.addToCart',$product)}}" class="btn btn-sm btn-outline-secondary">Add to Cart</a>
                      </div>
                      <small class="text-danger"><span data-feather="heart"></span></small>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            @endif
            </div>
          </div>
    
          </div>
        </div>
      </div>

    </main>