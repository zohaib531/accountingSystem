@extends('layouts.admin')
@section('title','Update Role')
@section('content')

    {{-- <div class="row page-titles mx-0">
        <div class="col p-md-0">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                @can('create-role')<li class="breadcrumb-item active"><a href="#">Update Role</a></li>@endcan
            </ol>
        </div>
    </div>
    <!-- row --> --}}

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-validation">

                            <form method="post" id="update-form">
                                @csrf
                                @method('put')
                                <fieldset>
                                    <div class="row mb-xl-1 mb-9">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="aboutTextarea" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                    Name
                                                </label>
                                                <input type="text" name="name" value="{{ $role->name  }}"  placeholder="Enter Name" class="form-control h-px-48" readonly/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-xl-1 mb-9">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="aboutTextarea" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">Permissions</label>
                                                @foreach($permission as $value)
                                                    <label class="col-md-4" ><input class="mr-3" {{ (in_array($value->id, $rolePermissions) ? "checked" : "")  }} type="checkbox" name="permission[]" value="{{ $value->name  }}" /> {{ $value->name  }}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-lg-8 ml-auto">
                                            <button type="button" class="btn btn-primary" onclick="commonFunction(false,'{{ route('roles.update',$role->id) }}','{{route('roles.index')}}','post','','update-form');">Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #/ container -->

@endsection

