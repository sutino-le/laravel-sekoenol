<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use DataTables;

class User extends Controller
{
    public function register()
    {
        return view('admin.user.register');
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(ModelsUser::select('*'))
                ->addColumn('action', 'admin.user.user-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.user.viewdata');
    }


    // insert user
    public function store(Request $request)
    {

        $userId = $request->id;

        $user   =   ModelsUser::updateOrCreate(
            [
                'id' => $userId
            ],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]
        );

        return Response()->json($user);
    }

    // tampil edit
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $user  = ModelsUser::where($where)->first();

        return Response()->json($user);
    }

    // delete
    public function destroy(Request $request)
    {
        $user = ModelsUser::where('id', $request->id)->delete();

        return Response()->json($user);
    }
}
