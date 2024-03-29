<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Lihat Pengguna', ['only' => ['index','serverside']]);
        $this->middleware('permission:Tambah Pengguna', ['only' => ['new','create']]);
        $this->middleware('permission:Ubah Pengguna', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Hapus Pengguna', ['only' => ['delete']]);
        $this->middleware('permission:Upload Pengguna', ['only' => ['import','importProcess']]);
    }

    public function index()
    {
        $data['users'] = User::all();
        return view('user.index', $data);
    }

    public function serverside(Request $request)
    {
        $users = [];
        if ($request->ajax()) {
            $users = User::all();
            return DataTables::of($users)
                ->addColumn('no', function($users){
                    return 'ini nomor';
                })
                ->addColumn('photo', function ($users) {
                    if ($users->image) {
                        return '<img alt="image" src="'. asset('storage/photo/' . $users->image) .'" class="rounded-circle" width="50">';
                    } else {
                        return '<img alt="image" src="'. asset('assets/img/avatar.png') .'" class="rounded-circle" width="50">';
                    }
                })
                ->addColumn('name', function ($users) {
                    return $users->name;
                })
                ->addColumn('email', function ($users) {
                    return $users->email;
                })
                ->addColumn('action', function ($users) {
                    return '
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="'. route('users.edit', $users->id) .'" class="btn btn-sm btn-warning" title="Ubah"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger" onclick="modalDelete('. $users->id .')" title="Hapus"><i class="fas fa-times"></i></button>
                        </div>
                    ';
                })
                ->rawColumns(['photo','action'])
                ->make(true);
        }
        $data['users']   = $users;
        $data['request'] = $request;
        return view('user.serverside', $data);
    }

    public function new()
    {
        $data['roles'] = Role::all();
        return view('user.new', $data);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|min:3',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required',
            'roles'           => 'required',
            'photo'           => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($validator->passes()) {
            $photo    = $request->file('photo');
            $filename = time() . '-' . $photo->getClientOriginalName();
            $path     = 'photo/' . $filename;
            Storage::disk('public')->put($path, file_get_contents($photo));

            $user = new User();
            $user->name     = $request->name;
            $user->email    = $request->email;
            $user->password = Hash::make($request->password);
            $user->image    = $filename;
            $user->save();
            $user->syncRoles($request->roles);

            session()->flash('success', 'Data user telah ditambahkan.');

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
        $user = User::findOrFail($id);
        $userRoles = $user->roles->pluck('name', 'name')->all();
        $data['user']      = $user;
        $data['roles']     = Role::all();
        $data['userRoles'] = $userRoles;
        return view('user.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = [
            'name'  => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id . ',id',
            'roles' => 'required',
            'photo' => 'mimes:png,jpg,jpeg|max:2048',
        ];

        if ($request->password) {
            $data += [
                'password'        => 'required|min:6|same:confirmPassword',
                'confirmPassword' => 'required',
            ];
        }

        $validator = Validator::make($request->all(), $data);

        if ($validator->passes()) {
            $photo = $request->file('photo');

            $user->name     = $request->name;
            $user->email    = $request->email;
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }
            if ($photo) {
                $filename = time() . '-' . $photo->getClientOriginalName();
                $path     = 'photo/' . $filename;

                if ($user->image) {
                    Storage::disk('public')->delete('photo/' . $user->image);
                }

                Storage::disk('public')->put($path, file_get_contents($photo));

                $user->image = $filename;
            }
            $user->save();
            $user->syncRoles($request->roles);

            session()->flash('success', 'Data user telah diubah.');

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
        $user = User::findOrFail($request->id);
        if ($user) $user->delete();
        session()->flash('success', 'Data user telah dihapus.');
        return redirect()->route('users');
    }

    public function import()
    {
        return view('user.import');
    }

    public function importProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:xls,xlsx|max:2048',
        ]);

        if ($validator->passes()) {
            $userImport = new UserImport();
            Excel::import($userImport, $request->file('file'));

            session()->flash('success', 'Data user telah ditambahkan.');

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
}
