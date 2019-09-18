@extends('admin.app')
@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
  </nav>

@endsection
@section('content')
<div class="category-header">
    <h1>Category</h1>
    <a href="{{route('admin.category.create')}}" class="float-right">Add Category</a>
</div>

<div class="table-responsive mt-2">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Description</th>
              <th>Slug</th>
              <th>Categories</th>
              <th>Date Created</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          @if( $categories )
            @foreach( $categories as $category)
                <tr>
                    <td> {{ $category->id }} </td>
                    <td>{{ $category->title }}</td>
                    <td>{!! $category->description !!}</td>
                    <td>{{ $category->slug }}</td>
                    <td>
                        @if( $category->childrens()->count()>0)
                            @foreach( $category->childrens as $c )
                                {{$c->title}},
                            @endforeach
                        @else
                            <strong>Parent Category</strong>
                        @endif
                    
                    </td>
                    @if($category->trashed())
                    <td>{{$category->deleted_at}}</td>
                    <td>
                    <a class="btn btn-info btn-sm" href="{{route('admin.category.recover',$category->id)}}">Restore</a> | 
                    <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$category->id}}')">Delete</a>
                    <form id="delete-category-{{$category->id}}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: none;">
                    
                    @method('DELETE')
                    @csrf
                  </form>
                  </td>
                  @else
                  <td>{{$category->created_at}}</td>
                  <td>
                  <a class="btn btn-info btn-sm" href="{{route('admin.category.edit',$category->id)}}">Edit</a> |
                   <a id="trash-category-{{$category->id}}" class="btn btn-warning btn-sm" href="{{route('admin.category.remove',$category->id)}}">Trash</a> | 
                   <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$category->id}}')">Delete</a>
                  <form id="delete-category-{{$category->id}}" action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display: none;">
                    
                    @method('DELETE')
                    @csrf
                  </form>
                </td>
                @endif
                </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">No categories found..</td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>

      <div class="col-lg-12 d-flex justify-content-center align-items-center">
          {{$categories->links()}}
      </div>
@endsection

@section('scripts')
<script type="text/javascript"> 
  function confirmDelete(id){
      let choice = confirm('Are you sure?');
      if( choice ){
        document.getElementById('delete-category-'+id).submit();
      }
  }

</script>



@endsection