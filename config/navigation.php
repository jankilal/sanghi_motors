<?php
return array (
    // Navigation configuration for Admin Menu
    'admin' => array (
        array (
            'title' => "Dashboard",
            'permission' => "dashboard",
            'common_route' => "admin/home*",
            'icon' => 'fa fa-dashboard',
            'options' => array (
                'action' => "Admin\DashboardController@index"
            ),
            'url' => ''
        ),
        array (
            'title' => "Location",
            'permission' => "location",
            'common_route' => "admin/location*",
            'icon' => 'fa fa-map-marker',
            'options' => array (
                'action' => "Admin\LocationController@index"
            ),
            'url' => ''
        ),
        array (
            'title' => "Line Of Business",
            'permission' => "lobusiness",
            'common_route' => "admin/lobusiness*",
            'icon' => 'fa fa-users',
            'options' => array (
                'action' => "Admin\LOBusinessController@index"
            ),
            'url' => ''
        ),
        array (
            'title' => "Designation",
            'permission' => "designation",
            'common_route' => "admin/designation*",
            'icon' => 'fa fa-users',
            'options' => array (
                'action' => "Admin\DesignationController@index"
            ),
            'url' => ''
        ),
        array (
            'title' => "Dealership",
            'permission' => "dealership",
            'common_route' => "admin/dealership*",
            'icon' => 'fa fa-users',
            'options' => array (
                'action' => "Admin\DealershipController@index"
            ),
            'url' => ''
        ),

        array (
            'title' => "Employee",
            'permission' => "employee",
            'common_route' => "admin/employee*",
            'icon' => 'fa fa-users',
            'options' => array (
                'action' => "Admin\EmployeeController@index"
            ),
            'url' => ''
        )
    )
);