@extends('layouts.admin.admin_layout')
@section('title')
Admin | Employee
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Employee Add</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('employee.index') }}" class="btn btn-dark pull-right" type="button">Back</a>
        <!-- </div> -->
      </div>
    </div>
    <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
               <div class="row">
                <div class="col-md-12">
                    <div class="hpanel">
                        <div class="panel-body">
                            <form role="form" enctype="multipart/form-data" id="employee-form" method="post" action="{{ route('employee.store') }}" novalidate="novalidate">
                                {{ csrf_field() }}
                                 <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('user_code') ? 'has-error' : '' }}">
                                            <label>Empolyee Code<span class="text-danger">*</span></label>
                                            {{Form::text('user_code',old('user_code', ''),['class' => 'form-control required','placeholder'=>'Empolyee Code'])}}
                                            <span class="text-danger">{{ $errors->first('user_code') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                                            <label>First Name<span class="text-danger">*</span></label>
                                            {{Form::text('first_name',old('first_name', ''),['class' => 'form-control required','placeholder'=>'First Name'])}}
                                            <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                                            <label>Last Name<span class="text-danger">*</span></label>
                                            {{Form::text('last_name',old('last_name', ''),['class' => 'form-control required','placeholder'=>'Last Name'])}}
                                            <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                                            <label>Mobile Number<span class="text-danger">*</span></label>
                                            {{Form::text('phone_number',old('phone_number', ''),['class' => 'form-control required','placeholder'=>'Mobile Number'])}}
                                            <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                            <label>Email<span class="text-danger">*</span></label>
                                            {{Form::text('email',old('email', ''),['class' => 'form-control required','placeholder'=>'Email'])}}
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                            <label>Password<span class="text-danger">*</span></label>
                                           {{Form::password('password', ['class' => 'form-control required', 'id'=> 'password'])}}
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                            <label>Confirm Password<span class="text-danger">*</span></label>
                                             {{Form::password('password_confirmation', ['class' => 'form-control required','id'=> 'password_confirmation'])}}
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('user_city') ? 'has-error' : '' }}">
                                            <label>City<span class="text-danger">*</span></label>
                                            {{Form::text('user_city',old('user_city', ''),['class' => 'form-control required','placeholder'=>'City Name'])}}
                                            <span class="text-danger">{{ $errors->first('user_city') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                                            <label>Postal Code<span class="text-danger">*</span></label>
                                            {{Form::text('postal_code',old('postal_code', ''),['class' => 'form-control required','placeholder'=>'Postal Code'])}}
                                            <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('state_id') ? 'has-error' : '' }}">
                                            <label>State<span class="text-danger">*</span></label>
                                            <select required class="form-control" name="state_id" id="state_id">
                                            <option value="{{ old('firstname') }}">Select State</option>
                                            @foreach($state_list as $s_res)
                                                <option value="{{ $s_res->id }}" >{{ $s_res->state_name }}</option>
                                            @endforeach
                                            </select>
                                            <span class="text-danger">{{ $errors->first('state_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                            <label>Status<span class="text-danger">*</span></label>
                                            {{Form::select('is_active',['Active'=>'Active','Inactive'=>'Inactive'], old('status', isset($user) ? $user->is_active : ''), ['class' => 'form-control select'])}}
                                            <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                            <label>Address <span class="text-danger">*</span></label>
                                            {{Form::textarea('address',old('address', ''),['class' => 'form-control','placeholder'=>'Address...'])}}
                                            <span class="text-danger">{{ $errors->first('address') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-sm btn-default m-t-n-xs" href="{{ url('admin/employee') }}"><strong>Cancel</strong></a>
                                    <button class="btn btn-sm btn-primary m-t-n-xs" type="submit"><strong>Submit</strong></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
         $("#employee-form").validate({
             rules: {
                 first_name: {
                     required: true,
                 },
                 last_name: {
                     required: true,
                 },
                 postal_code: {
                     required: true,
                 },
                 state_id: {
                     required: true,
                 },
                 is_active: {
                     required: true,
                 },
                 address: {
                     required: true,
                 },
                 user_city: {
                     required: true,
                 },
                 email: {
                     required: true,
                 },
                 phone_number: {
                     required: true,
                 },
                 password: {
                     required: true,
                 },
                 user_code: {
                     required: true,
                 },
             },
             submitHandler: function(form) {
                 form.submit();
             }
         });
    })
</script>
@endsection