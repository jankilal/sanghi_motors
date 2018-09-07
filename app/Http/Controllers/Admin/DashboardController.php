<?php

namespace App\Http\Controllers\Admin;

use App\Models\OauthAccessToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        return view('Admin.Dashboard.index');
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }
}
