<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Lihat Role', ['only' => ['index']]);
        $this->middleware('permission:Tambah Role', ['only' => ['new', 'create']]);
        $this->middleware('permission:Ubah Role', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Hapus Role', ['only' => ['delete']]);
        $this->middleware('permission:Pengaturan Role Permission', ['only' => ['permission','givePermission']]);
    }

    public function index(Request $request)
    {
        $roles = [];
        if ($request->ajax()) {
            $roles = Role::all();
            return DataTables::of($roles)
                ->addColumn('no', function ($roles) {
                    return 'ini nomor';
                })
                ->addColumn('name', function ($roles) {
                    return $roles->name;
                })
                ->addColumn('action', function ($roles) {
                    $btnDetail = '';
                    $btnEdit   = '';
                    $btnDelete = '';
                    if (Auth::user()->hasPermissionTo('Pengaturan Role Permission')) {
                        $btnDetail = '<a href="' . route('role.permission', $roles->id) . '" class="btn btn-sm btn-success" title="Permission"><i class="fas fa-tag"></i></a>';
                    }
                    if (Auth::user()->hasPermissionTo('Ubah Role')) {
                        $btnEdit = '<a href="' . route('role.edit', $roles->id) . '" class="btn btn-sm btn-warning" title="Ubah"><i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->hasPermissionTo('Hapus Role')) {
                        $btnDelete = '<button class="btn btn-sm btn-danger" onclick="modalDelete(' . $roles->id . ')" title="Hapus"><i class="fas fa-times"></i></button>';
                    }
                    return '
                        <div class="btn-group btn-group-sm" role="group">
                            '.$btnDetail.'
                            '.$btnEdit.'
                            '.$btnDelete.'
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['roles'] = $roles;
        return view('role.index', $data);
    }

    public function new()
    {
        return view('role.new');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|unique:roles,name',
        ]);

        if ($validator->passes()) {
            $role = new Role();
            $role->name = trim($request->name);
            $role->save();

            session()->flash('success', 'Data role telah ditambahkan.');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $data['role'] = $role;
        return view('role.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|unique:roles,name,' . $role->id . ',id',
        ]);

        if ($validator->passes()) {
            $role->name = trim($request->name);
            $role->save();

            session()->flash('success', 'Data role telah diubah.');

            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function delete(Request $request)
    {
        $role = Role::findOrFail($request->id);
        if ($role) $role->delete();
        session()->flash('success', 'Data role telah dihapus.');
        return redirect()->route('role');
    }

    public function permission($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')->where('role_id', $role->id)->pluck('permission_id', 'permission_id')->all();
        $data['role']            = $role;
        $data['permissions']     = $permissions;
        $data['rolePermissions'] = $rolePermissions;
        return view('role.permission', $data);
    }

    public function givePermission(Request $request, $id)
    {
        $permissions = $request->permissions;

        $role = Role::findOrFail($id);
        $role->syncPermissions($permissions);

        session()->flash('success', 'Data role permission telah disimpan.');

        return response()->json([
            'status' => true,
            'errors' => [],
        ]);
    }
}
