@extends('layouts.admin.admin_layout')
@section('title')
Admin | Line Of Business
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Line Of Business Edit</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('lobusiness.index') }}" class="btn btn-dark pull-right" type="button">Back</a>
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
                            <form role="form" enctype="multipart/form-data" id="lobusiness-form" method="post" action="{{ route('lobusiness.store') }}" novalidate="novalidate">
                                {{ csrf_field() }}
                                {{ Form::hidden('id', isset($lobusiness) ? $lobusiness->id : '') }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                            <label>Name<span class="text-danger">*</span></label>
                                            {{Form::text('name',old('name', isset($lobusiness) ? $lobusiness->name : ''),['class' => 'form-control required','placeholder'=>'Name'])}}
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group {{ $errors->has('is_active') ? 'has-error' : '' }}">
                                            <label>Status<span class="text-danger">*</span></label>
                                             {{Form::select('is_active',['Active'=>'Active','Inactive'=>'Inactive'], old('status', isset($lobusiness) ? $lobusiness->is_active : ''), ['class' => 'form-control select'])}}
                                            <span class="text-danger">{{ $errors->first('is_active') }}</span>
                                        </div>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label>Description</label>
                                        {{Form::textarea('description',old('description', isset($lobusiness) ? $lobusiness->description : ''),['class' => 'form-control required','placeholder'=>'Description'])}}
                                    </div>
                                </div>
                                <div><br>
                                    <a class="btn btn-sm btn-default m-t-n-xs" href="{{ url('admin/lobusiness') }}"><strong>Cancel</strong></a>
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
         $("#lobusiness-form").validate({
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