@extends('layouts.admin')

@section('style')
    <link href="{{asset('assets/template/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection

@section('content')



<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('categories.index')}}">All categories</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">All users</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered zero-configuration">
                            <thead>
                                <tr>
                                    <th>Sr</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key=> $category)
                                <tr>

                                    <td>{{$category->id}}</td>
                                    <td>{{$category->title}}</td>
                                    <td>
                                        {{-- <button class="btn btn-info" >Update</button> --}}
                                        <a href="{{url('admin/categories/'.$category->id.'/edit')}}"><button class="btn btn-success text-white">Update</button></a>
                                        <button class="btn btn-danger" onclick="commonFunction(true,'{{ route('categories.destroy',$category->id) }}','{{route('categories.index')}}','delete','Are you sure you want to delete?','');">Delete</button>
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
