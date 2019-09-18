
@extends('admin.app')
@section('breadcrumb')
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
      <li class="breadcrumb-item" ><a href="{{route('admin.category.index')}}"> Category</a> </li>
      <li class="breadcrumb-item active" aria-current="page">Create</li>
    </ol>
  </nav>

@endsection
@section('content')
<div class="mb-5 ">
    <h1>Add/Edit Category</h1>
    <div class="col-xs-12">
        @if(session()->has('message'))
        <div class="alert alert-success">
            {{ session('message')}} 
        </div>
        @endif
    </div>
    <form action="@if( isset($category) ) {{route('admin.category.update',$category->id)}}@else {{route('admin.category.store')}} @endif" method="POST" class="mt-5" >
        @csrf
        @if( isset($category) )
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="txturl">Title</label>
            <input type="text" class="form-control" id="txturl" name="title" value="{{@$category->title}}">
            <p class="small">{{config('app.url')}} /{{@$category->title}}<span id="url"></span></p>
            <input type="hidden" name="slug" id="slug" value="{{@$category->title}}">
                @if($errors->has('title'))
                <div class="alert alert-danger">
                    {{ $errors->first('title')}} 
                </div>
                @endif
        </div>
        <div class="form-group">
            <label for="editor">Description</label><br>
            <textarea name="description" id="editor" cols="80" rows="10">{!! @$category->description !!}</textarea>
        </div>
        @php
            $ids = (isset($category->childrens)) ? array_pluck($category->childrens,'id') : null;
        @endphp
        <div class="form-group">
            <label for="sel_cat">Select Category</label><br>
            <select name="parent_id[]" id="parent_id" class="form-control" multiple>
                @if(isset($categories))
                    <option value="0">Top Level</option>
                    @foreach( $categories as $cat)
                        <option value="{{$cat->id}}" @if( isset($ids) && in_array($cat->id,$ids)) {{'selected'}} @endif>{{$cat->title}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        
        @if(isset($category))
        <button type="submit" class="btn btn-primary">Update</button>
        @else
        <button type="submit" class="btn btn-primary">Add Category</button>
        @endif
    </form>
    
</div>
@section('scripts')
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
<script type="text/javascript">
    $(function(){
        $('#parent_id').select2({
            placeholder: "Select a parent category",
            allowClear: true,
            minimumResultsForSearch: Infinity
        });
        CKEDITOR.replace( 'editor' );
        $('#txturl').on('keyup',function(){
            var url = slugify($(this).val());
            $('#url').html(url);
            $('#slug').val(url);
        });
        
    })
    


</script>

@endsection
@endsection