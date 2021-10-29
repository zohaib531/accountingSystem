@extends('layouts.admin')
@section('content')
    <div class="container-fluid mt-5" id="dashboard-body">
        <div class="">
       
            <div class=" mb-15 mb-lg-23">
            <div class="row m-0">
                <div class="col-xl-12 px-5">
                    <h4 class="font-size-6 font-weight-semibold C-Heading mb-4">Edit User</h4>
                    <div style="border-top: 4px solid red; box-shadow: 0 9px 7px -1px #707070; border-radius: 15px;padding: 70px 40px;"
                        class="contact-form bg-white shadow-8">
                        @if (Session::has('message'))
                            <p class="alert {{ Session::get('alert-class', 'alert-success') }}">
                                {{ Session::get('message') }}</p>
                        @endif
                        @if ($errors->has('message'))
                            <li>{{ $errors->first('message') }}</li>
                        @endif
                        <form method="post" id="create_user">
                            @csrf
                            @method('PATCH')
                            <fieldset>
                                <div class="row mb-xl-1 mb-9">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="aboutTextarea"
                                                class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                Name:
                                            </label>
                                            <input type="text" value="{{ $user->name }}" name="name"
                                                placeholder="Enter Name" class="form-control h-px-48" />
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="aboutTextarea"
                                                class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                E-mail:
                                            </label>
                                            <input type="email" value="{{ $user->email }}" name="email"
                                                placeholder="Enter email" class="form-control h-px-48" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-xl-1 mb-9">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="aboutTextarea"
                                                class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                Contact #:
                                            </label>
                                            <input type="number" value="{{ $user->phone }}" name="phone"
                                                placeholder="Enter number" class="form-control h-px-48" />
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="aboutTextarea" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                        Password
                                                    </label>
                                                    <input type="text" name="password" placeholder="Enter password" class="form-control h-px-48" />
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="aboutTextarea" class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                      Confirm  Password
                                                    </label>
                                                    <input type="text" name="password_confirmation" placeholder="Enter confirm password" class="form-control h-px-48" />
                                                </div>
                                            </div> --}}



                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="aboutTextarea"
                                                        class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                         Team:
                                                    </label>
                                                    <select name="roles" required=""
                                                        class="form-control pl-0 arrow-3 w-100 font-size-4 d-flex align-items-center w-100">
                                                        @if (count($roles) > 0)
                                                            <option value="" disabled>Select Option</option>
                                                            @foreach ($roles as $role)
                                                                <option {{ in_array($role, $userRole) ? 'selected' : '' }}
                                                                    value="{{ $role }}">{{ $role }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                              <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="aboutTextarea"
                                                    class="d-block text-black-2 font-size-4 font-weight-semibold mb-4">
                                                    Role
                                                </label>
                                                <input type="radio" {{$user->agent ==1 ? 'checked' : ''}} name="agent" value="1" class=" h-px-48" />
                                                Agent
                                                <input type="radio" {{$user->agent ==0 ? 'checked' : ''}} name="agent" value="0" class=" h-px-48"   />
                                                Non-Agent
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-xl-1 mb-9">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <a href="" data-toggle="modal" data-whatever="@getbootstrap"
                                                data-target="#exampleModal_2">Change Password</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" style="background: #dc8627;" value="Save"
                                            class="btn btn-h-60 text-white px-5 py-2 mt-3 rounded text-uppercase" />
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="modal fade" id="exampleModal_2" tabindex="-1" aria-labelledby="exampleModal_2"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form autocomplete="off" action="" method="POST" id="passForm">
                                @csrf
                                <div class="modal-body">
                                    <div class="row mb-xl-1 mb-9 justify-content-center">
                                        <div class="col-lg-12">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <i class="bi bi-key-fill"></i>
                                                Change Password
                                            </h5>
                                            <hr>
                                            <div class="form-group">
                                                <label for="old_password">Old Password*</label>
                                                <input id="old_password" name="old_password" type="password"
                                                    class="form-control " value="{{ old('old_password') }}"
                                                    autocomplete="first_name" placeholder="Enter Old Password">

                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">New Password*</label>
                                                <input id="new_password" name="new_password" type="password"
                                                    class="form-control" value="{{ old('new_password') }}"
                                                    placeholder="Enter New Password" autocomplete="new-password">

                                            </div>
                                            <div class="form-group">
                                                <label for="password-confirm">Confirm New Password*</label>
                                                <input id="new_password_confirmation" type="password" class="form-control"
                                                    name="new_password_confirmation" placeholder="Re-Type New Password"
                                                    autocomplete="new-password">
                                                    <span id="span1" style="color:red" class="d-none">New & Confirm password dont matches</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-xl-1 mb-9 justify-content-center">
                                        <div class="col-lg-10 text-right p-0">
                                            <div class="mt-2">
                                                <div class="form-group">
                                                    <input type="button" value="Change Password" onclick="updatePass()"
                                                        class="btn btn-success btn-h-40 text-white min-width-px-110 rounded-5 text-uppercase" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#create_user').submit(function() {
                $("#loader").show();
                var data = new FormData(this);
                $.ajax({
                    url: "{{ Route('user.update', $user->id) }}",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(res) {
                        if (res.success == true) {

                            swal("{{ __('Success') }}", res.message, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if (res.success == false) {
                            swal("{{ __('Warning') }}", res.message, 'error');
                        }

                        $("#loader").hide();
                    },
                    error: function() {
                        $("#loader").hide();
                    }
                });


                return false;
            })
        });

        function updatePass() {
            var form = document.querySelector("#passForm");
            console.log($('#new_password').val() );
            console.log($('#new_password_confirmation').val() );
            if ($('#new_password').val() != $('#new_password_confirmation').val()) {
                $('#span1').removeClass('d-none');
                $('#span1').addClass('d-block');
            } else {
                $('#span1').addClass('d-none');
                $('#span1').removeClass('d-block');
                var data = new FormData(form);
                $.ajax({
                    url: "{{ Route('updatePassword') }}",
                    data: data,
                    contentType: false,
                    processData: false,
                    type: 'POST',
                    success: function(res) {
                        if (res.success == true) {

                            swal("{{ __('Success') }}", res.message, 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else if (res.success == false) {
                            swal("{{ __('Warning') }}", res.message, 'error');
                        }

                        $("#loader").hide();
                    },
                    error: function() {
                        $("#loader").hide();
                    }
                });

            }
        }
    </script>
@endsection
