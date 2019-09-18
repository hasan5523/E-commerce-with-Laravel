@extends('admin.app')
@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">product</li>
    </ol>
  </nav>

@endsection
@section('content')
<div class="category-header">
    <h1>All Products</h1>
    <a href="{{route('admin.product.create')}}" class="float-right">Add product</a>
</div>

<div class="table-responsive mt-2">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Image</th>
              <th>Slug</th>
              <th>Categories</th>
              <th>Date Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @if( $products )
            @foreach( $products as $product)
                <tr>
                    <td> {{ $product->id }} </td>
                    <td>{{ $product->title }}</td>
                    <td>{!! $product->description !!}</td>
                    <td><img src="{{asset($product->thumbnail)}}" alt="" width="50" height="50"></td>
                    <td>{{ $product->slug }}</td>
                    <td>
                        @if( $product->categories()->count()>0)
                            @foreach( $product->categories as $p )
                                {{$p->title}},
                            @endforeach
                        @else
                            <strong>No products</strong>
                        @endif
                    
                    </td>
                    @if($product->trashed())
                    <td>{{$product->deleted_at}}</td>
                    <td>
                    <a class="btn btn-info btn-sm" href="{{route('admin.product.recover',$product->id)}}">Restore</a> | 
                    <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$product->id}}')">Delete</a>
                    <form id="delete-product-{{$product->id}}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                    
                    @method('DELETE')
                    @csrf
                  </form>
                  </td>
                  @else
                  <td>{{$product->created_at}}</td>
                  <td>
                  <a class="btn btn-info btn-sm" href="{{route('admin.product.edit',$product->id)}}">Edit</a> |
                   <a id="trash-product-{{$product->id}}" class="btn btn-warning btn-sm" href="{{route('admin.product.remove',$product->id)}}">Trash</a> | 
                   <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$product->id}}')">Delete</a>
                  <form id="delete-product-{{$product->id}}" action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display: none;">
                    
                    @method('DELETE')
                    @csrf
                  </form>
                </td>
                @endif
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">No categories found..</td>product
            </tr>
            @endif
          </tbody>
        </table>
      </div>

      <div class="col-lg-12 d-flex justify-content-center align-items-center">
          {{$products->links()}}
      </div>
@endsection

@section('scripts')
<script type="text/javascript"> 
  function confirmDelete(id){
      let choice = confirm('Are you sure?');
      if( choice ){
        document.getElementById('delete-product-'+id).submit();
      }
  }

</script>



@endsection