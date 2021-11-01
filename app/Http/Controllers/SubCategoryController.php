<?php

namespace App\Http\Controllers;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use Validator;

class SubCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-sub-categories', ['only' => ['index']]);
        $this->middleware('permission:create-sub-category', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-sub-category', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-sub-category', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $subCategories = SubCategory::all();
        return view('admin.subcategories.index',compact('categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(),[
            'title'=>'required || unique:categories',
            'category_id'=>'required'
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $subCategories = new SubCategory();
        $subCategories->title = $request->title;
        $subCategories->category_id = str_pad($request->category_id, 2, '0', STR_PAD_LEFT);
        if($subCategories->save()){
            $subCategories->code =  str_pad($subCategories->id, 2, '0', STR_PAD_LEFT);
            $subCategories->save();
            return response()->json(['success' => true, 'message' =>'Sub category has been added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $category = SubCategory::where('id',$id)->first();
        return view('admin.subcategories.edit',compact('categories','category'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $validations = Validator::make($request->all(),[
            'title'=>'required || unique:categories',
            'category_id'=>'required'
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $subCategory->title = $request->title;
        $subCategory->category_id = $request->category_id;
        if($subCategory->save()){

            return response()->json(['success' => true, 'message' =>'Sub category has been updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subCategory)
    {
        if(SubCategory::where('id',$subCategory)->delete()){
            return response()->json(['success' => true, 'message' =>'Sub category has been deleted successfully']);
        }
    }
}
