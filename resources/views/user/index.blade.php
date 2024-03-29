@extends('layouts.wrapper')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pengguna</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @can('Tambah Pengguna')
                            <a href="{{ route('users.new') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                        @endcan
                        @can('Upload Pengguna')
                            <a href="{{ route('users.import') }}" class="btn btn-info"><i class="fas fa-upload"></i> Upload</a>
                        @endcan
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped datatable mb-0">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-center">#</th>
                                        <th class="text-center">Foto</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($users->isNotEmpty())
                                        @foreach ($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if ($user->image)
                                                        <img alt="image" src="{{ asset('storage/photo/' . $user->image) }}" class="rounded-circle" width="50">
                                                    @else
                                                        <img alt="image" src="http://localhost/stisla/assets/img/avatar/avatar-1.png" class="rounded-circle" width="50">
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center">
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        @can('Ubah Pengguna')
                                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning" title="Ubah"><i class="fas fa-edit"></i></a>
                                                        @endcan
                                                        @can('Delete Pengguna')
                                                            <button class="btn btn-sm btn-danger" onclick="modalDelete({{ $user->id }})" title="Hapus"><i class="fas fa-times"></i></button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center">-- Tidak Ada Data --</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah yakin ingin menghapus data?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('users.delete') }}" method="post">
                    @csrf @method('DELETE')
                    <input type="hidden" id="id" name="id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customCSS')
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
@endsection
@section('customJS')
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.datatable').dataTable();
        });
        function modalDelete(id){
            $('#id').val(id);
            $('#modalDelete').modal('show');
        }
    </script>
@endsection