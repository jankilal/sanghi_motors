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
        )
    )
);