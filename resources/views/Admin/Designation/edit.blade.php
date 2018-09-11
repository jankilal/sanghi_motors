@extends('layouts.admin.admin_layout')
@section('title')
Admin | Designation
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Designation Edit</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('designation.index') }}" class="btn btn-dark pull-right" type="button">Back</a>
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
                            <form role="form" enctype="multipart/form-data" id="designation-form" method="post" action="{{ route('designation.store') }}" novalidate="novalidate">
                                {{ csrf_field() }}
                                {{ Form::hidden('id', isset($designation) ? $designation->id : '') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('designation_name') ? 'has-error' : '' }}">
                                            <label>Designation Name<span class="text-danger">*</span></label>
                                            {{Form::text('designation_name',old('designation_name', isset($designation) ? $designation->designation_name : ''),['class' => 'form-control required','placeholder'=>'Designation Name'])}}
                                            <span class="text-danger">{{ $errors->first('designation_name') }}</span>
                                        </div>
                                    </div> 
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('designation_code') ? 'has-error' : '' }}">
                                            <label>Designation Code<span class="text-danger">*</span></label>
                                            {{Form::text('designation_code',old('designation_code', isset($designation) ? $designation->designation_code : ''),['class' => 'form-control required','placeholder'=>'Designation Code'])}}
                                            <span class="text-danger">{{ $errors->first('designation_code') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                            <label>Status<span class="text-danger">*</span></label>
                                             {{Form::select('is_active',['Active'=>'Active','Inactive'=>'Inactive'], old('status', isset($designation) ? $designation->is_active : ''), ['class' => 'form-control select'])}}
                                            <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-sm btn-default m-t-n-xs" href="{{ url('admin/designation') }}"><strong>Cancel</strong></a>
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
         $("#designation-form").validate({
             rules: {
                 name: {
                     required: true,
                 },
                 is_active: {
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