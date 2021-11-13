@extends('layouts.admin')
@section('title','Product List')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('products.index')}}">All Products</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row m-0">
                        <div class="col-6 text-right">
                            <h4 class="card-title">All Products</h4>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{route('products.create')}}" class="btn btn-primary">Add new +</a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Variation</th>
                                    <th class="text-right w-25">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key=> $product)
                                <tr>
                                    <td>{{++$key}}</td>
                                    <td>{{$product->product_code}}</td>
                                    <td>
                                        <img src="{{asset($product->img)}}" alt="" width="100" height="70" style="object-fit: cover">
                                    </td>
                                    <td>{{$product->title}}</td>
                                    <td>{{$product->price}}</td>
                                    <td>{{$product->quantity}}</td>
                                    @if ($product->variation == '1')
                                        <td>Has variation</td>
                                    @else
                                        <td>No variation</td>
                                    @endif


                                    <td class="text-right">
                                        <a href="{{route('products.edit',$product->id)}}"><button class="btn btn-info text-white">Update</button></a>
                                        <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('products.destroy',$product->id) }}','{{route('products.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
                                        {{-- <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('categories.destroy',$category->id) }}','{{route('categories.index')}}','delete','Are you sure you want to delete?','');">Delete</button> --}}
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->


@endsection


@section('script')
    <script src="{{asset('assets/template/plugins/tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/template/plugins/tables/js/datatable-init/datatable-basic.min.js')}}"></script>
@endsection
