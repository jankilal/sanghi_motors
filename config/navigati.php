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
            'title' => "Grievances",
            'permission' => "categories.index",
            'common_route' => "admin/categories*",
            'icon' => 'fa fa-life-ring',
            'options' => array (
                'action' => "#"
            ),
            'childrens' => array(
                array (
                    'title' => "Grievance Summary",
                    'permission' => "grievance.index",
                    'common_route' => "admin/grievance*",
                    'icon' => 'fa fa-gavel',
                    'options' => array (
                        'action' => "Admin\GrievanceController@index"
                    ),
                ),
                array (
                    'title' => "Section",
                    'permission' => "sections.index",
                    'common_route' => "admin/sections*",
                    'icon' => 'fa fa-building-o',
                    'options' => array (
                        'action' => "Admin\SectionController@index"
                    )
                ),

                array (
                    'title' => "Ward",
                    'permission' => "wards.index",
                    'common_route' => "admin/wards*",
                    'icon' => 'fa fa-cubes',
                    'options' => array (
                        'action' => "Admin\WardController@index"
                    )
                ),
                
                array (
                    'title' => "Category",
                    'permission' => "categories.index",
                    'common_route' => "admin/categories*",
                    'icon' => 'fa fa-tags',
                    'options' => array (
                        'action' => "Admin\GrievanceCategoryController@index"
                    )
                ),


            )
        ),

        array (
            'title' => "Payments",
            'permission' => "payment-categories.index",
            'common_route' => "admin/payment-categories*",
            'icon' => 'fa fa-credit-card',
            'options' => array (
                'action' => "#"
            ),
            'childrens' => array(
                array (
                    'title' => "Transaction Summary",
                    'permission' => "transactions.index",
                    'common_route' => "admin/transactions*",
                    'icon' => 'fa fa-inr',
                    'options' => array (
                        'action' => "Admin\TransactionController@index"
                    )
                ),
                array (
                    'title' => "Payment Category",
                    'permission' => "payment-categories.index",
                    'common_route' => "admin/payment-categories*",
                    'icon' => 'fa fa-list',
                    'options' => array (
                        'action' => "Admin\PaymentCategoryController@index"
                    )
                )

            ),
        ),

        array (
            'title' => "Report Gallery",
            'permission' => "report-grievance-data",
            'common_route' => "admin/report*",
            'icon' => 'fa fa-file',
            'options' => array (
                'action' => "#"
            ),
            'childrens' => array(
                array (
                    'title' => "Grievance Report",
                    'permission' => "report-grievance-data",
                    'common_route' => "admin/report/grievance",
                    'icon' => 'fa fa-list',
                    'options' => array (
                        'action' => "Admin\ReportController@getGrievanceReport"
                    )
                ),
                array (
                    'title' => "Payment Report",
                    'permission' => "report-transaction-data",
                    'common_route' => "admin/report/report-transactions*",
                    'icon' => 'fa fa-inr',
                    'options' => array (
                        'action' => "Admin\ReportController@ReportTransactions"
                    )
                ),
                array (
                    'title' => "User Activity Log",
                    'permission' => "user-activity",
                    'common_route' => "admin/report/user-activity",
                    'icon' => 'fa fa-history',
                    'options' => array (
                        'action' => "Admin\ReportController@getUserActivityReport"
                    )
                )

            ),
        ),
        array (
            'title' => "User Management",
            'permission' => "users.index",
            'common_route' => "admin/users*",
            'icon' => 'fa fa-cog',
            'options' => array (
                'action' => "#"
            ),
            'childrens' => array(
                array (
                    'title' => "Users",
                    'permission' => "users.index",
                    'common_route' => "admin/users*",
                    'icon' => 'fa fa-users',
                    'options' => array (
                        'action' => "Admin\UserController@index"
                    )
                ),

                array (
                    'title' => "Roles & Permissions",
                    'permission' => "roles.index",
                    'common_route' => "admin/roles*",
                    'icon' => 'fa fa-tasks',
                    'options' => array (
                        'action' => "Admin\RoleController@index"
                    )
                ),
                array (
                    'title' => "Permission",
                    'permission' => "permissions.index",
                    'common_route' => "admin/permissions*",
                    'icon' => 'fa fa-lock',
                    'options' => array (
                        'action' => "Admin\PermissionController@index"
                    )
                ),


            )
        ),

        array (
            'title' => "Settings",
            'permission' => "email-grievance-report",
            'common_route' => "admin/setting/email-grievance-report*",
            'icon' => 'fa fa-cog',
            'options' => array (
                'action' => "#"
            ),
            'childrens' => array(
                array (
                    'title' => "E-Mail Report",
                    'permission' => "email-grievance-report",
                    'common_route' => "admin/setting/email-grievance-report*",
                    'icon' => 'fa fa-lock',
                    'options' => array (
                        'action' => "Admin\SettingController@EmailGrievanceReport"
                    )
                ),
            )
        ),

        array (
                    'title' => "News Circular",
                    'permission' => "news.index",
                    'common_route' => "admin/news*",
                    'icon' => 'fa fa-newspaper-o',
                    'options' => array (
                        'action' => "Admin\NewsController@index"
                    )
                ),
                array (
                    'title' => "Admin Wings",
                    'permission' => "adminwings.index",
                    'common_route' => "admin/adminwings*",
                    'icon' => 'fa fa-newspaper-o',
                    'options' => array (
                        'action' => "Admin\AdminwingsController@index"
                    )
                ),
                array (
                    'title' => "About Us",
                    'permission' => "about.index",
                    'common_route' => "admin/about*",
                    'icon' => 'fa fa-newspaper-o',
                    'options' => array (
                        'action' => "Admin\AboutController@index"
                    )
                ),
                array (
                    'title' => "Citizen facility",
                    'permission' => "citizenfacility.index",
                    'common_route' => "admin/citizenfacility*",
                    'icon' => 'fa fa-newspaper-o',
                    'options' => array (
                        'action' => "Admin\CitizenfacilityController@index"
                    )
                ),
                array (
                    'title' => "Genaral Information",
                    'permission' => "genaratinformation.index",
                    'common_route' => "admin/genaratinformation*",
                    'icon' => 'fa fa-info-circle',
                    'options' => array (
                        'action' => "Admin\GenaralinformationController@index"
                    )
                ),

                array (
                    'title' => "Contact Us",
                    'permission' => "contactus.index",
                    'common_route' => "admin/contactus*",
                    'icon' => 'fa fa-info-circle',
                    'options' => array (
                        'action' => "Admin\ContactusController@index"
                    )
                ),

    )
);