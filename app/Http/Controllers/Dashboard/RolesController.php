<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleAbility;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate();
        return view('dashboard.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create',[
            'role'=>new Role(),
            'abilities'=>config('abilities')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // return $request->abilities['categories.view'];
        $request->validate([
            'name'=>'required:min:3',
            'abilities'=>'required|array'
        ]);
        $role =Role::createWithAbilities($request);

        return redirect()->route('dashboard.roles.index')->with('success','Role Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        $existAbilities = $role->abilities()->pluck('type','ability')->toArray();
        return view('dashboard.roles.edit',[
            'role'=>$role,
            'abilities'=>app('abilities'),
            'existAbilities'=> $existAbilities
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required:min:3',
            'abilities'=>'required|array'
        ]);
        $role->updateWithAbilities($request);

        return redirect()->route('dashboard.roles.index')->with('success','Role Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return back()->with('success','Role Deleted Successfully');
    }
}
