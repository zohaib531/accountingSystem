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
        $subCategories = SubCategory::all();
        return view('admin.subCategory.index',compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subCategory.create',compact('categories'));
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
        // $category = Category::where('id',$id)->first();
        // return view('admin.subCategory.edit',compact('category'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        if(SubCategory::where('id',$id)->delete()){
            return response()->json(['success' => true, 'message' =>'Sub category has been deleted successfully']);
        }
    }
}
