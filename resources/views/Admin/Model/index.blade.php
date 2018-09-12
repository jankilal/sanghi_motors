@extends('layouts.admin.admin_layout')
@section('title')
Admin | Model
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Model List</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('model.create') }}" class="btn btn-dark pull-right" type="button">Add New</a>
        <!-- </div> -->
      </div>
    </div>
    <div class="clearfix"></div>
    <div id="msg_div">
      @if(Session::has('flash_message'))
        <div class="alert alert-success"><span class="glyphicon glyphicon-ok"></span><em> {!! session('flash_message') !!}</em></div>
      @endif
    </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <!-- <h2>Model</h2> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="model-listing" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Model Name</th>
                <th>Model Number</th>
                <th>Model Color</th>
                <th>Weight</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>             
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function myFunction() {
      if(!confirm("Are You Sure to delete this"))
      event.preventDefault();
  }
 </script>
<script type="text/javascript">
$(document).ready(function () {
    $.fn.dataTable.ext.errMode = 'throw';
    $dataTable = $('#model-listing').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order : [[ 4, "desc" ]],
        ajax: '{!! route('load-model-data') !!}',
        columns: [
            {data: 'model_name', name: 'model_name'},
            {data: 'model_number', name: 'model_number'},
            {data: 'model_color', name: 'model_color'},
            {data: 'weight', name: 'weight'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
            {data: 'id', name: 'id',visible: false, className: 'hide_me'},
        ],
        "initComplete": function (settings, json) {
          // console.log(json);
        }
    });

    afterDeleteSuccess = function (response) {                    
          if(response.success == true && response.status_code == '1') 
          {
              toastr["success"]("{!! trans('admin.model_delete_success_msg') !!}", "{!! trans('admin.success') !!}");
          }
          else if(response.success == false && response.status_code == '2')
          {
              toastr["error"]("{!! trans('admin.model_delete_error_msg') !!}", "{!! trans('admin.error') !!}");
          }
          else
          {
              toastr["success"]("{!! trans('admin.model_delete_success_msg') !!}", "{!! trans('admin.success') !!}");
              //toastr["error"](response.error, "{!! trans('admin.error') !!}");
          }
          
          // Redraw grid after success
          if($dataTable !== null) {
              $dataTable.draw();
          }
      };
      afterDeleteError = function () {
          toastr["error"]("{!! trans('admin.section_delete_error_msg') !!}", "{!! trans('admin.error') !!}");
      }
});

</script>
@endsection