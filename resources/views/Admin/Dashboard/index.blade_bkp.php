@extends('layouts.admin.admin_layout')
@section('title')
Admin | Dashboard
@endsection
@section('style_script')
    <link rel="stylesheet" href="{{ url('AdminTheme/vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('AdminTheme/vendor/datatables.net-bs/css/dataTables.responsive.css') }}" />
@endsection
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12 text-center welcome-message">
            <h2>
                Welcome to Cannanore Cantonment Board
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="hpanel stats">
                <div class="panel-body h-200">
                    <div class="stats-title pull-left">
                        <h4>Users</h4>
                    </div>
                    <div class="stats-icon pull-right">
                        <i class="pe-7s-user fa-4x"></i>
                    </div>
                    <div class="m-t-xl">
                        {{--<h1 class="text-success">{{$count_user}}</h1>--}}
                        <table id="user-total" class="table table-responsive table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>Web User</th>
                                <th>Mobile User</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <h1>{{ @$user_data['web_user'] }}</h1>
                                </td>
                                <td>
                                    <h1>{{ @$user_data['app_user'] }}</h1>
                                </td>

                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-6">
            <div class="hpanel stats">
                <div class="panel-body h-200">
                    <div class="stats-title pull-left">
                        <h4>Total Grievances</h4>
                    </div>
                    <div class="stats-icon pull-right">
                        <i class="fa fa-users fa-4x"></i>
                    </div>
                    <div class="m-t-xl">
                        <table id="grievance-total" class="table table-responsive table-striped table-bordered table-hover" width="100%">
                            <thead>
                            <tr>
                                <th>Total Grievance</th>
                                <th>New</th>
                                <th>In-Progress</th>
                                <th>Resolved</th>
                                <th>Disposed</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <h1 class="text-success">{{$count_grievance}}</h1>
                                </td>
                                <td>
                                    <h1>{{ @$status_grievance_count_main[0] }}</h1>
                                </td>
                                <td>
                                    <h1>{{ @$status_grievance_count_main[1] }}</h1>
                                </td>
                                <td>
                                    <h1>{{ @$status_grievance_count_main[2] }}</h1>
                                </td>
                                <td>
                                    <h1>{{ @$status_grievance_count_main[3] }}</h1>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--<div class="panel-footer">
                    This is standard panel footer
                </div>-->
            </div>
        </div>
    </div>


    <!-- Chart code -->
    @if(array_sum($status_grievance_count_main) > 0)
        <div class="row">

            <div class="col-lg-6">
                <div class="hpanel stats">
                    <div class="panel-body" style="margin: -1px;">
                        <div class="stats-title pull-left">
                            <h4 style="">All Grievance Status wise</h4>

                        </div>
                    </div>

                    <div id="piechart" style="height: 500px; "></div>

                    <!--<div class="panel-footer">
                        This is standard panel footer
                    </div>-->
                </div>
            </div>

     @else
        <div id="piechart" style="display: none  "></div>
     @endif
    <div class="col-lg-6">
        <div class="hpanel stats">
            <div class="panel-body" style="margin: -1px;">
                <div class="stats-title pull-left">
                    <h4 style="">Grievance Disposal Metrics-Bar Chart</h4>

                </div>
            </div>
            <div id="columnchart_material" style="width:100%;height: 500px;"></div>
        </div>
    </div>
<!-- end of chart code -->
</div>

        <div class="row">
            <div class="col-lg-6">
                <div class="hpanel stats">
                    <div class="panel-body h-200">
                        <div class="stats-title pull-left">
                            <h4>Total Overdue GRIEVANCES</h4>
                        </div>
                        <div class="stats-icon pull-right">
                            <i class="fa fa-users fa-4x"></i>
                        </div>
                        <div class="m-t-xl">
                            <h1 class="text-success">{{$overdue_grievance}}</h1>

                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection
@section('footer_script')
    <script src="{{ asset('AdminTheme/vendor/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminTheme/vendor/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('AdminTheme/vendor/datatables.net-bs/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/custom_chart.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            $dataTable = $('#grievance-total').DataTable({
                processing: true,
                serverSide: false,
                responsive: true,
                bPaginate: false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                searching: false,
            });
        });
        google.charts.load('current', {'packages':['corechart','bar']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['New' , {{ @$status_grievance_count_main[0] }}],
                ['In-Progress',{{ @$status_grievance_count_main[1] }}],
                ['Resolved',{{ @$status_grievance_count_main[2] }}],
                ['Disposed',{{ @$status_grievance_count_main[3] }}]
            ]);

            var options = {
                title: '',
                sliceVisibilityThreshold:0,
                legend: { position: 'bottom', alignment: 'center' }
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);

            var data = google.visualization.arrayToDataTable([
                ['Element', 'Grievance', { role: 'style' }, { role: 'annotation' } ],
                ['0-7 Days', {{ @$bar_chart['0to7d'] }}, '#109618', {{ @$bar_chart['0to7d'] }} ],
                ['8-14 Days', {{ @$bar_chart['8to14d'] }}, '#FF9900', {{ @$bar_chart['8to14d'] }} ],
                ['15-22 Days', {{ @$bar_chart['15to22d'] }}, '#3366CC', {{ @$bar_chart['15to22d'] }} ],
                ['>22 Days', {{ @$bar_chart['greater22'] }}, '#DC3912', {{ @$bar_chart['greater22'] }} ]
            ]);
            var options = {
                chart: {
                    title: 'Grievance Disposal Metrics-Bar Chart',
                    subtitle: '.Day v/s No. of Grievances Disposed',

                },
                legend: {position: 'none'},
                vAxis: {
                    format: '#'
                },
                series: {
                    0: {
                        type: 'bars'
                    },
                    1: {
                        type: 'line',
                        color: 'grey',
                        lineWidth: 0,
                        pointSize: 0,

                        visibleInLegend: false
                    }
                },


            };

            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
            chart.draw(data, google.charts.Bar.convertOptions(options));
        }






    </script>
@endsection