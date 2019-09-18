<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(3);
        return view('admin.category.index',compact('categories'));
    }

    public function trash(){
        $categories = Category::onlyTrashed()->paginate(3);
        return view('admin.category.index',compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.category.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:5',
            'slug'  => 'required|min:5|unique:categories' // here categories is the table name
        ]);

        $categories = Category::create($request->only('title','description','slug'));
        $categories->childrens()->attach($request->parent_id);
        return back()->with('message','Category Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id )->get();
        return view('admin.category.create',['categories'=>$categories, 'category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        $category->title = $request->title;
        $category->description = $request->description;
        $category->slug = $request->slug;
        
        $category->childrens()->detach();
        $category->childrens()->attach($request->parent_id);
        $category->save();
        return back()->with('message','Record successfully updated');
    }
    /**
     * Recover the specified resource from storage.
    
     */

     public function recoverCat($id){
        $category = Category::onlyTrashed()->findOrFail($id);
        if( $category->restore() )
            return back()->with('message','Record successfully Restored');
        else
            return back()->with('message','Error Restoring Category');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if( $category->childrens()->detach() && $category->forceDelete() ){
            return back()->with('message','Category Deleted Successfully');
        }else{
            return back()->with('message','Error Deleting records');
        }
    }

    //remove to trash

    public function remove(Category $category)
    {
        if( $category->delete() ){
            return back()->with('message','Category Trashed Successfully');
        }else{
            return back()->with('message','Error Deleting records');
        }
    }
}
