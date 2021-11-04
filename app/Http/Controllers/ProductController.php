<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ImageUploadTrait;


class ProductController extends Controller
{
    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $sub_categories = SubCategory::all();
        Product::orderBy('id','desc')->first()!=null?$productCode=Product::orderBy('id','desc')->first()->id:$productCode=0;
        ++$productCode;
        return view('admin.products.create',compact('categories','sub_categories','productCode'));
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
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'title'=>'required || unique:categories',
            'price'=>'required',
            'quantity'=>'required',
            'description'=>'required',
            'image'=>'required',
        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $products = new Product();
        $products->title = $request->title;
        $products->category_id = $request->category_id;
        $products->sub_category_id = $request->sub_category_id;
        $products->product_code = $request->product_code;
        $products->price = $request->price;
        $products->quantity = $request->quantity;
        $products->description = $request->description;
        $products->img = $request->image;
        if($products->save()){
            return response()->json(['success' => true, 'message' =>'Sub category has been added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

     // upload file using ajax with progress bar
     public function uploadAllFiles(Request $request){
        $path = $this->uploadImage('file',$request->upload_path,$request);
        return response()->json(['status'=>true,'path'=>$path]);
    }
}

