<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\LogActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use Redirect;
// use Yajra\DataTables\DataTables as dt;
use App\Models\User;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Session;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        return view('Admin.Location.index');
    }

    public function create(){

        return view('Admin.Location.addLocation');
    }

    public function UnauthorizedAccess(){
        $data = [];
        return view('Admin.ErrorPage.unauthorized_access',compact('data'));
    }

    public function loadLocationData(){

        return Datatables::of(Location::select('locations.*', 'state.state_name')->join('state', 'locations.state_id', '=', 'state.id'))
            ->addColumn('action', function ($loct) {
                $btnStr = '';
                $btnStr .= '<a  href="'. route('location.destroy',array($loct->id)) . '" data-id="'. $loct->id . '" class="btn btn-xs btn-primary btn-delete"><i class="fa fa-trash"></i> Delete</a>';
                return $btnStr;
            })
            ->make(true);
    }
}
