<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the roles.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page_title = __('All Roles');
        $resultQuery = Role::query();

        if($request->input('todo') == 'Filter')
        {
            if($request->filled('name')) {
                $resultQuery->where('name', 'like', "%{$request->input('name')}%");
            }
        }

        $sortBy = $request->get('sort') ? $request->get('sort') : 'created_at';
        $direction = $request->get('direction') ? $request->get('direction') : 'desc';
        $resultQuery->orderBy($sortBy, $direction);

        $roles = $resultQuery->paginate(config('Reading.nodes_per_page'));
        return view('admin.roles.index', ['roles' => $roles], compact('page_title'));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = __('Add New Role');
        return view('admin.roles.create',compact('page_title'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'name'        => 'required|unique:roles',
            ],
        );

        Role::create([
            'name'  => $request->input('name'),
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.roles.index')->with('success', __('Role added successfully'));

    }

    /**
     * Show the form for editing the specified role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page_title = __('Edit Role');
        $role = Role::findorFail($id);
        return view('admin.roles.edit', ['role' => $role], compact('page_title'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
                'name'              => 'required|unique:roles,name,'.$id,
            ],
        );
        $role = Role::findorFail($id);
        $role->name = $request->input('name');
        $role->save();

        return redirect()->route('admin.roles.index')->with('success', __('Role updated successfully'));
    }

    /**
     * Remove the specified role from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::findorFail($id);
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', __('Role deleted successfully'));
    }
}
