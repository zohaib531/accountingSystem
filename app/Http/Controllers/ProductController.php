<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-products', ['only' => ['index']]);
        $this->middleware('permission:create-product', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-product', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-product', ['only' => ['destroy']]);
    }

    use ImageUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $categories = Category::all();
        // $sub_categories = SubCategory::all();
        // Product::orderBy('id', 'desc')->first() != null ? $productCode = Product::orderBy('id', 'desc')->first()->id : $productCode = 0;
        // ++$productCode;
        // return view('admin.products.create', compact('categories', 'sub_categories', 'productCode'));

        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(), [
            // 'title' => 'required || unique:products,title,NULL,id,deleted_at,NULL',
            'title' => 'required',
            'narration' => 'required',
            'product_unit' => 'required',
            'unique_product' => 'required || unique:products',
        ]);
        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }
        $products = new Product();
        $products->title = $request->title;
        $products->narration = $request->narration;
        $products->product_unit = $request->product_unit;
        $products->created_by = Auth::user()->id;
        $products->unique_product = $request->unique_product;


        $products->save();

        return response()->json(['success' => true, 'message' => 'Product has been added successfully','data'=>$products]);
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
    public function edit($id)
    {

        $product = Product::where('id', $id)->first();
        return view('admin.products.edit', compact('product'))->render();
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

        $validations = Validator::make($request->all(), [
            // 'title' => 'required || unique:products,title,NULL,id,deleted_at,NULL'.$product->id,
            'title' => 'required',
            'narration' => 'required',
            'product_unit' => 'required',
            'unique_product' => 'required || unique:products',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $product->title = $request->title;
        $product->narration = $request->narration;
        $product->product_unit = $request->product_unit;
        $product->created_by = Auth::user()->id;
        $product->unique_product = $request->unique_product;
        $product->save();

        return response()->json(['success' => true, 'message' => 'Product has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        if (Product::where('id', $product)->delete()) {
            return response()->json(['success' => true, 'message' => 'Product has been deleted successfully']);
        }
    }

}
