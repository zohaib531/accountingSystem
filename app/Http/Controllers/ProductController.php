<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\PVariation;
use App\SubCategory;
use Illuminate\Http\Request;
use Validator;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\DB;

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
        return view('admin.products.index', compact('products'));
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
        Product::orderBy('id', 'desc')->first() != null ? $productCode = Product::orderBy('id', 'desc')->first()->id : $productCode = 0;
        ++$productCode;

        return view('admin.products.create', compact('categories', 'sub_categories', 'productCode'));
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'title' => 'required || unique:categories',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);
        if ($validations->fails()) {
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
        $products->variation = isset($request->variation) ? $request->variation : 0;
        $products->img = $request->image;

        $products->save();

        if ($request->variation_color) {
            for ($i = 0; $i < count($request->variation_color); $i++) {
                $PVariation = new PVariation();
                $PVariation->product_id = $products->id;
                $PVariation->name = $request->variation_color[$i] . "-" . $request->variation_size[$i];
                $imageName = time() . '.' . $request->variation_img[$i]->extension();
                $request->variation_img[$i]->move(public_path('admin/uploads/variations'), $imageName);
                $PVariation->img = isset($imageName) ? 'admin/uploads/variations' . $imageName : "";
                $PVariation->color = isset($request->variation_color[$i]) ? $request->variation_color[$i] : '';
                $PVariation->size = isset($request->variation_size[$i]) ? $request->variation_size[$i] : '';
                $PVariation->qty = isset($request->variation_qty[$i]) ? $request->variation_qty[$i] : '';
                $PVariation->price = isset($request->variation_price[$i]) ? $request->variation_price[$i] : '';
                $PVariation->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Product has been added successfully']);
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

        $categories = Category::all();
        $sub_categories = SubCategory::all();
        $product = product::where('id', $id)->first();

        return view('admin.products.edit', compact('categories', 'sub_categories', 'product'))->render();
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
            'category_id' => 'required',
            'sub_category_id' => 'required',
            'title' => 'required || unique:categories',
            'price' => 'required',
            'quantity' => 'required',
            'description' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }

        $product->title = $request->title;
        $product->category_id = $request->category_id;
        $product->sub_category_id = $request->sub_category_id;
        $product->product_code = $request->product_code;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->img = $request->image;
        $product->save();



        if ($request->variation_color) {
            PVariation::where('product_id',$product->id)->delete();
            for ($i = 0; $i < count($request->variation_color); $i++) {
                $PVariation = new PVariation();
                $PVariation->product_id = $product->id;
                $PVariation->name = $request->variation_color[$i] . "-" . $request->variation_size[$i];
                $imageName = time() . '.' . $request->variation_img[$i]->extension();
                $request->variation_img[$i]->move(public_path('admin/uploads/variations'), $imageName);
                $PVariation->img = isset($imageName) ? 'admin/uploads/variations' . $imageName : "";
                $PVariation->color = isset($request->variation_color[$i]) ? $request->variation_color[$i] : '';
                $PVariation->size = isset($request->variation_size[$i]) ? $request->variation_size[$i] : '';
                $PVariation->qty = isset($request->variation_qty[$i]) ? $request->variation_qty[$i] : '';
                $PVariation->price = isset($request->variation_price[$i]) ? $request->variation_price[$i] : '';
                $PVariation->save();
            }
        }
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

    // upload file using ajax with progress bar
    public function uploadAllFiles(Request $request)
    {

        $path = $this->uploadImage('file', $request->upload_path, $request);
        return response()->json(['status' => true, 'path' => $path]);
    }
}
