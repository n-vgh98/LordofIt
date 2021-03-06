<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view("admin.users.index", compact("users"));
    }

    // safe haye har role ro miare 
    public function normal()
    {
        $users = User::all();
        return view("admin.users.normal", compact("users"));
    }


    public function writer()
    {
        $users = User::all();
        // dd($users[0]->roles()->exists("admin"));
        return view("admin.users.writer", compact("users"));
    }


    public function admin()
    {
        $users = User::all();
        // dd($users[0]->roles()->exists("admin"));
        return view("admin.users.admin", compact("users"));
    }
    // safe haye har role ro miare 




    // give admin access
    public function promotetoadmin($id)
    {
        $user = User::find($id);
        $role = Role::where("name", "admin")->first();
        $user->roles()->attach($role->id);
        return redirect()->back()->with("success", " دسترسی مدریرت به کاربر داده شد");
    }

    // remove admin access
    public function demoteadmin($id)
    {
        $user = User::find($id);
        $role = Role::where("name", "admin")->first();
        $user->roles()->detach($role->id);
        return redirect()->back()->with("success", " دسترسی مدیریت از کاربر گرفته شد");
    }


    // give writer access
    public function promotetowriter($id)
    {
        $user = User::find($id);
        $role = Role::where("name", "writer")->first();
        $user->roles()->attach($role->id);
        return redirect()->back()->with("success", " دسترسی نویسندگی به کاربر داده شد");
    }


    // remove writer access
    public function demotewriter($id)
    {
        $user = User::find($id);
        $role = Role::where("name", "writer")->first();
        $user->roles()->detach($role->id);
        return redirect()->back()->with("success", " دسترسی نویسندگی از کاربر گرفته شد");
    }

    // remove all access
    public function clearroles($id)
    {
        $user = User::find($id);
        $role = Role::where("name", "user")->first();
        $user->roles()->sync($role->id);
        return redirect()->back()->with("success", "تمامی دسترسی ها از کاربر گرفته شد");
    }


    public function block($id)
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
        return redirect()->back();
    }

    public function unblock($id)
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();
        return redirect()->back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with("success", ".کاربر شما با موفقیت اضافه شد");
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
        //
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password !== null) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return redirect()->back()->with("success", "تغیرات شما با موفقیت انجام شد");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with("success", "کاربر شما با موفقیت حذف شد");
    }
}
