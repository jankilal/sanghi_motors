@extends('layouts.admin.admin_layout')
@section('title')
Admin | Designation
@endsection
@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Designation List</h3>
      </div>
      <div class="title_right">
          <a href="{{ route('designation.create') }}" class="btn btn-dark pull-right" type="button">Add New</a>
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
          <!-- <h2>Designation</h2> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table id="designation-listing" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Designation Name</th>
                <th>Designation Code</th>
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
    $dataTable = $('#designation-listing').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order : [[ 2, "desc" ]],
        ajax: '{!! route('load-designation-data') !!}',
        columns: [
            {data: 'designation_name', name: 'designation_name'},
            {data: 'designation_code', name: 'designation_code'},
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
              toastr["success"]("{!! trans('admin.designation_delete_success_msg') !!}", "{!! trans('admin.success') !!}");
          }
          else if(response.success == false && response.status_code == '2')
          {
              toastr["error"]("{!! trans('admin.designation_delete_error_msg') !!}", "{!! trans('admin.error') !!}");
          }
          else
          {
              toastr["success"]("{!! trans('admin.designation_delete_success_msg') !!}", "{!! trans('admin.success') !!}");
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