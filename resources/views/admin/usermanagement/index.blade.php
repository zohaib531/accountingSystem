@extends('layouts.admin')
@section('style')
<!-- ================= -->
<!-- Datatable css start-->
<link rel="stylesheet" href="{{ asset('assets/css/jquery.dataTables.min.css') }}" />
<!-- Datatable css end-->
<!-- ================= -->
<style>
.row {
    margin: 0px !important;
}

#example1_filter label {
    display: flex;
    width: fit-content;
    margin-left: auto;
}
</style>
@endsection

@section('content')
<div class="px-2 container mt-5">
    @can('user-create') <a href="{{ route('user.create') }}"><button class="mt-3 mb-3 costumButton px-3">Add
            +</button></a>@endcan
    <table id="example1" class="table border-0  ">
        <thead>
            <tr>
                <th>Action</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Contact</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $key => $user)
            <tr class="bg-transparent">
                <td>
                    @can('user-edit')
                    <a href="{{ route('user.edit',$user->id) }}">
                        <i style="cursor: pointer;" class="bi bi-pencil-square"></i>
                    </a>
                    @endcan
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>
                    {{ $user->email }}
                </td>
                <td>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                    @endif
                </td>
                <td>
                    {{ $user->phone }}
                </td>
                <td>
                    {{ date('d-m-y : h:i a',strtotime($user->created_at)) }}
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>




@endsection

@section('script')
<!-- ================= -->
<!-- Datatable js start-->
<script src="{{ asset('assets/plugins/data-tables/script/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/script/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/script/datatables-responsive/js/dataTables.responsive.min.js') }}">
</script>
<script src="{{ asset('assets/plugins/data-tables/script/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
</script>

<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    });
});
</script>
<!-- Datatable js end-->
<!-- ================= -->
@endsection