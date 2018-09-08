@extends('layouts.admin.admin_layout')
@section('title')
Admin | Location
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Location Add</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('location.index') }}" class="btn btn-dark pull-right" type="button">Back</a>
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
                           <!--  @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif -->
                            <form role="form" enctype="multipart/form-data" id="location-form" method="post" action="{{ route('location.store') }}" novalidate="novalidate">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('branch_name') ? 'has-error' : '' }}">
                                            <label>Brance Name<span class="text-danger">*</span></label>
                                            <input required type="text" class="form-control" name="branch_name" id="branch_name" value="{{ old('branch_name') }}">
                                            <span class="text-danger">{{ $errors->first('branch_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                            <label>City<span class="text-danger">*</span></label>
                                            <input required type="text" class="form-control" name="city" id="city" value="{{ old('city') }}">
                                            <span class="text-danger">{{ $errors->first('city') }}</span>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('postal_code') ? 'has-error' : '' }}">
                                            <label>Postal Code<span class="text-danger">*</span></label>
                                            <input required type="text" class="form-control" name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                                            <span class="text-danger">{{ $errors->first('postal_code') }}</span>
                                        </div>
                                    </div>
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
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                            <label>Status<span class="text-danger">*</span></label>
                                            <select required class="form-control" name="status" id="status">
                                                <option value="Active">Active</option>
                                                <option value="InActive">InActive</option>
                                            </select>
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('address_line_1') ? 'has-error' : '' }}">
                                            <label>Address Line 1<span class="text-danger">*</span></label>
                                            <textarea  required class="form-control" name="address_line_1" rows="2">{{ old('address_line_1') }}</textarea>
                                             <span class="text-danger">{{ $errors->first('address_line_1') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('address_line_2') ? 'has-error' : '' }}">
                                            <label>Address Line 2<span class="text-danger">*</span></label>
                                            <textarea required class="form-control" name="address_line_2" rows="2">{{ old('address_line_2') }}</textarea>
                                            <span class="text-danger">{{ $errors->first('address_line_2') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div><br>
                                    <a class="btn btn-sm btn-default m-t-n-xs" href="{{ url('admin/location') }}"><strong>Cancel</strong></a>
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
         $("#location-form").validate({
             rules: {
                 branch_name: {
                     required: true,
                 },
                 city: {
                     required: true,
                 },
                 postal_code: {
                     required: true,
                 },
                 state_id: {
                     required: true,
                 },
                 status: {
                     required: true,
                 },
                 address_line_1: {
                     required: true,
                 },
                 address_line_2: {
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