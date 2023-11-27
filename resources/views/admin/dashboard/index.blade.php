@extends('admin.layouts.master')
  
@section('content') 
<div class="content-wrapper">
  <section class="content">
    <div class="container-fluid">
      <div class="event_header" style="padding: 20px 0px; text-align: end;">
        <div class="button">
          <a href="{{route('users.create')}}">
            <button type="button" class="btn btn-primary">
              <i class="fa fa-plus"></i> Add </button>
          </a>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <table id="user_table" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Country</th>
                <th>State</th>
                <th>City</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </section>
</div>
@endsection
@section('script')
<script>
    
  $(function () {
    $("#user_table").DataTable({
         processing: true,
        serverSide: true,
        ajax: '{{ route("users.index") }}',
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'country_name', name: 'country_name'},
            {data: 'state_name', name: 'state_name'},
            {data: 'city_name', name: 'city_name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}, 
        ],
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });

  
$(document).on('click', '.delete-confirm' ,function (event) {
    event.preventDefault();
    const url = $(this).data('url'); 
      Swal.fire({
        title: 'Are you sure?',
        text: 'This record and its details will be permanently deleted!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
         window.location.href = url;
    });
});

 @if((session()->has('users')) )
      $(document).ready(function(){
          toastr.success("{{session()->get('users')}} .")
       });
@endif 
 @if(session()->has('delete_user'))
      $(document).ready(function(){
          toastr.error( "{{ session()->get('delete_user') }}")
       });
@endif 

 
</script>
@endsection



 