<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Lihat Permission', ['only' => ['index']]);
        $this->middleware('permission:Tambah Permission', ['only' => ['new', 'create']]);
        $this->middleware('permission:Ubah Permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Hapus Permission', ['only' => ['delete']]);
    }
    public function index(Request $request)
    {
        $permissions = [];
        if ($request->ajax()) {
            $permissions = Permission::all();
            return DataTables::of($permissions)
                ->addColumn('no', function ($permissions) {
                    return 'ini nomor';
                })
                ->addColumn('name', function ($permissions) {
                    return $permissions->name;
                })
                ->addColumn('email', function ($permissions) {
                    return $permissions->email;
                })
                ->addColumn('action', function ($permissions) {
                    $btnEdit   = '';
                    $btnDelete = '';
                    if (Auth::user()->hasPermissionTo('Ubah Permission')) {
                        $btnEdit = '<a href="' . route('permission.edit', $permissions->id) . '" class="btn btn-sm btn-warning" title="Ubah"><i class="fas fa-edit"></i></a>';
                    }
                    if (Auth::user()->hasPermissionTo('Hapus Permission')) {
                        $btnDelete = '<button class="btn btn-sm btn-danger" onclick="modalDelete(' . $permissions->id . ')" title="Hapus"><i class="fas fa-times"></i></button>';
                    }
                    return '
                        <div class="btn-group btn-group-sm" role="group">
                            '.$btnEdit.'
                            '.$btnDelete.'
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $data['permissions'] = $permissions;
        return view('permission.index', $data);
    }

    public function new()
    {
        return view('permission.new');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|unique:permissions,name',
        ]);

        if ($validator->passes()) {
            $permission = new Permission();
            $permission->name        = trim($request->name);
            $permission->description = $request->description;
            $permission->save();

            session()->flash('success', 'Data permission telah ditambahkan.');

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
        $permission = Permission::findOrFail($id);
        $data['permission'] = $permission;
        return view('permission.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|string|unique:permissions,name,' . $permission->id . ',id',
        ]);

        if ($validator->passes()) {
            $permission->name        = trim($request->name);
            $permission->description = $request->description;
            $permission->save();

            session()->flash('success', 'Data permission telah diubah.');

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
        $permission = Permission::findOrFail($request->id);
        if ($permission) $permission->delete();
        session()->flash('success', 'Data permission telah dihapus.');
        return redirect()->route('permission');
    }
}
