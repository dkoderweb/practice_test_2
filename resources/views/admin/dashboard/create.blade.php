@extends('admin.layouts.master')
  
@section('content')
   <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ isset($user) ? 'Update' : 'Add' }} User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <a href="{{url('admin/home')}}">Home</a>
              </li>
              <li class="breadcrumb-item active">Users</li>
            </ol>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- form start -->
              <form action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" method="POST"> @csrf @if(isset($user)) @method('PUT') @endif <div class="card-body row">
                  <div class="form-group col-md-6">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{ old('name', isset($user) ? $user->name : '') }}" required name="name" placeholder="Enter Name"> @error('name') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Email</label>
                    <input type="email" class="form-control" value="{{ old('email', isset($user) ? $user->email : '') }}" required name="email" placeholder="Enter Email"> @error('email') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Password</label>
                    <input type="password" class="form-control" required name="password" placeholder="Enter Password"> @error('password') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Phone</label>
                    <input type="number" class="form-control" value="{{ old('phone', isset($user) ? $user->phone : '') }}" required name="phone" placeholder="Enter Phone"> @error('phone') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>Country</label>
                    <select id="country-dd" required name="country_id" class="form-control">
                      <option value="">Select Country</option> @foreach ($countries as $data) <option value="{{$data->id}}" {{ isset($user) ? $user->country_id == $data->id ? 'selected' : '' : ''}}>
                        {{$data->name}}
                      </option> @endforeach
                    </select> @error('country_id') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>State</label>
                    <select id="state-dd" required name="state_id" class="form-control"></select> @error('state_id') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="form-group col-md-6">
                    <label>City</label>
                    <select id="city-dd" required name="city_id" class="form-control"></select> @error('city_id') <span class="alert-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">{{ isset($user) ? 'Update' : 'Save' }}</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('script')
<script>
 var selectedcountry = @json(isset($user) ? $user -> country_id : null);
var selectedState = @json(isset($user) ? $user -> state_id : null);
var selectedCity = @json(isset($user) ? $user -> city_id : null);
if (selectedState !== null && selectedCity !== null) {
    country_change(selectedState)
    state_change(selectedCity)
}

$('#country-dd').on('change', function() {
    selectedState = null;
    selectedCity = null;
    selectedcountry = null;

    var idCountry = this.value;
    console.log(idCountry)
    country_change(idCountry);
});

$('#state-dd').on('change', function() {
    var idState = this.value;
    state_change(idState);
});

function country_change(id) {
    var idCountry = selectedcountry ? selectedcountry : id;
    $("#state-dd").html('');
    $.ajax({
        url: "{{url('api/fetch-states')}}",
        type: "POST",
        data: {
            country_id: idCountry,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(result) {
            $('#state-dd').html('<option value="">Select State</option>');
            $.each(result.states, function(key, value) {
                $("#state-dd").append(`<option value="${value.id}" ${value.id == selectedState ? 'selected' : ''}>${value.name}</option>`);



            });
            $('#city-dd').html('<option value="">Select City</option>');
        }
    });
}

function state_change(id) {
    var idState = selectedState ? selectedState : id;
    $("#city-dd").html('');
    $.ajax({
        url: "{{url('api/fetch-cities')}}",
        type: "POST",
        data: {
            state_id: idState,
            _token: '{{csrf_token()}}'
        },
        dataType: 'json',
        success: function(res) {
            $('#city-dd').html('<option value="">Select City</option>');
            $.each(res.cities, function(key, value) {
                $("#city-dd").append(`<option value="${value.id}" ${value.id == selectedCity ? 'selected' : ''}>${value.name}</option>`);

            });
        }
    });
}
</script>
@endsection



 