@extends('layouts.wrapper')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Role</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @can('Tambah Role')
                            <a href="{{ route('role.new') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</a>
                        @endcan
                        <hr>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-sm table-striped mb-0" width="100%">
                                <thead>
                                    <tr class="bg-primary text-white">
                                        <th class="text-center">#</th>
                                        <th>Nama</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
                <form action="{{ route('role.delete') }}" method="post">
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
            loadDataTable();
        });
        function loadDataTable(){
            $('#datatable').dataTable({
                processing: true,
                pagination: true,
                responsive: false,
                serverSide: true,
                searching: true,
                ordering: false,
                ajax: {
                    url: '{{ route("role") }}',
                },
                columns: [
                    {
                        data: 'no',
                        name: 'no',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ],
                columnDefs: [
                    {
                        targets: [0,2],
                        className: 'text-center',
                    },
                ],
            });
        }
        function modalDelete(id){
            $('#id').val(id);
            $('#modalDelete').modal('show');
        }
    </script>
@endsection