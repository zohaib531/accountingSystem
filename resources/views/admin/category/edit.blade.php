@extends('layouts.admin')
@section('content')

<div class="row page-titles mx-0">
    <div class="col p-md-0">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="{{route('categories.create')}}">Create user</a></li>
        </ol>
    </div>
</div>
<!-- row -->

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Update Category</h4>
                    <div class="form-validation">
                        <form class="form-valide" id="edit-form">
                            @csrf
                            @method('put')
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label text-right" for="val-category">Category title<span class="text-danger">*</span>
                                </label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" id="val-category" name="title" value="{{ $category->title }}" placeholder="Enter a category title..">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-8 ml-auto">
                                    <button type="button" class="btn btn-primary" onclick="edit_resource({{ $category->id }});">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #/ container -->

@endsection

@section('script')
<script src="{{asset('assets/template/plugins/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/template/plugins/validation/jquery.validate-init.js')}}"></script>


<script>
    function edit_resource(id) {
        var myform = document.getElementById("edit-form");
        var fd = new FormData(myform);
        fd.append("_token", "{{ csrf_token() }}");
        var c_url = '{{ route("categories.update", ":id") }}';
        c_url = c_url.replace(':id',id);
        $.ajax({
            url: c_url,
            type: "post",
            processData: false,
            contentType: false,
            data: fd,
            success: function(data) {
                if (data.success == true) {
                        window.location = "{{ route('categories.index') }}";
                } else {
                        console.log('chal rha');
                    if (data.hasOwnProperty("message")) {
                        var wrapper = document.createElement("div");
                        var err = "";
                        $.each(data.message, function(i, e) {
                            err += "<p>" + e + "</p>";
                        });
                        wrapper.innerHTML = err;
                    }
                }
            },
        });
    }
</script>

@endsection
