<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as userRole;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-users', ['only' => ['index']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        $roles = userRole::select('id','name')->get();
        return view('admin.usermanagement.users.index',compact('roles','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.usermanagement.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = Validator::make($request->all(),[
            'username'=>'required',
            'email'=>'required',
            'password'=>'required | min:8',
            'role'=>'required'

        ]);

        if($validations->fails())
        {
            return response()->json(['success' => false, 'message' => $validations->errors()]);
        }
        $role = userRole::find($request->role);
        $user = new User();
        $user->name = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->tb_password = Hash::make($request->password);
        if($user->save()){
            $user->assignRole($role);
            return response()->json(['success' => true, 'message' =>'User has been added successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $user = User::where('id',$id)->first();
        // return view('admin.usermanagement.users.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // $validations = Validator::make($request->all(),[
        //     'username'=>'required',
        //     'email'=>'required',
        //     'password'=>'required | min:8'
        // ]);

        // if($validations->fails())
        // {
        //     return response()->json(['success' => false, 'message' => $validations->errors()]);
        // }

        // $user = User::find($id);
        // $user->name = $request->username;
        // $user->email = $request->email;
        // $user->password = $request->password;
        // if($user->save()){
        //     return response()->json(['success' => true, 'message' =>'User has been updated successfully']);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(User::where('id',$id)->delete()){
            return response()->json(['success' => true, 'message' =>'User has been deleted successfully']);
        }
    }
}
