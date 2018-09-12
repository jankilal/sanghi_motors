@extends('layouts.admin.admin_layout')
@section('title')
Admin | Model
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Model Add</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('model.index') }}" class="btn btn-dark pull-right" type="button">Back</a>
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
                            <form role="form" enctype="multipart/form-data" id="model-form" method="post" action="{{ route('model.store') }}" novalidate="novalidate">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('model_name') ? 'has-error' : '' }}">
                                            <label>Model Name<span class="text-danger">*</span></label>
                                            {{Form::text('model_name',old('model_name', ''),['class' => 'form-control required','placeholder'=>'Model Name'])}}
                                            <span class="text-danger">{{ $errors->first('model_name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('model_number') ? 'has-error' : '' }}">
                                            <label>Model Number<span class="text-danger">*</span></label>
                                            {{Form::text('model_number',old('model_number', ''),['class' => 'form-control required','placeholder'=>'Model Number'])}}
                                            <span class="text-danger">{{ $errors->first('model_number') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('model_color') ? 'has-error' : '' }}">
                                            <label>Model Color<span class="text-danger">*</span></label>
                                            {{Form::text('model_color',old('model_color', ''),['class' => 'form-control required','placeholder'=>'Model Color'])}}
                                            <span class="text-danger">{{ $errors->first('model_color') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group {{ $errors->has('weight') ? 'has-error' : '' }}">
                                            <label>Weight<span class="text-danger">*</span></label>
                                            {{Form::text('weight',old('weight', ''),['class' => 'form-control required','placeholder'=>'Weight'])}}
                                            <span class="text-danger">{{ $errors->first('weight') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('lob_id') ? 'has-error' : '' }}">
                                            <label>Line Of Business<span class="text-danger">*</span></label>
                                            {{Form::select('lob_id',$lob_list, old('status', isset($model) ? $model->lob_id : ''), ['class' => 'form-control select'])}}
                                            <span class="text-danger">{{ $errors->first('lob_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                            <label>Status<span class="text-danger">*</span></label>
                                            {{Form::select('is_active',['Active'=>'Active','Inactive'=>'Inactive'], old('status', isset($model) ? $model->is_active : ''), ['class' => 'form-control select'])}}
                                            <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description</label>
                                            {{Form::textarea('description',old('description', ''),['class' => 'form-control','placeholder'=>'Description...'])}}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a class="btn btn-sm btn-default m-t-n-xs" href="{{ url('admin/model') }}"><strong>Cancel</strong></a>
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
         $("#model-form").validate({
             rules: {
                 model_name: {
                     required: true,
                 },
                 model_number: {
                     required: true,
                 },=
                 lob_id: {
                     required: true,
                 },
                 is_active: {
                     required: true,
                 },=
                 weight: {
                     required: true,
                 },
                 model_color: {
                     required: true,
                 },=
             },
             submitHandler: function(form) {
                 form.submit();
             }
         });
    })
</script>
@endsection