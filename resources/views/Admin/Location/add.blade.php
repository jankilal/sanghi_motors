@extends('layouts.admin.admin_layout')
@section('title')
Admin | Location
@endsection

@section('content')
<div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <h3>Location List</h3>
      </div>

      <div class="title_right">
          <a href="{{ route('location.create') }}" class="btn btn-dark pull-right" type="button">Add New</a>
        <!-- </div> -->
      </div>
    </div>
    <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <!-- <h2>Location</h2> -->
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
        
        </div>
      </div>
    </div>
  </div>
</div>

@endsection