@extends('layouts.wrapper')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Role Permission</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Role: {{ $role->name }}</h4>
                    </div>
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        <div class="card-body pb-0">
                            <div class="row">
                                @if ($permissions->isNotEmpty())
                                    @foreach ($permissions as $key => $permission)
                                        <div class="col-lg-3 col-md-4 col-6">
                                            <div class="form-group">
                                                <div class="form-check">
                                                    <input type="checkbox" id="permission_{{ $key }}" name="permissions[]" class="form-check-input" value="{{ $permission->name }}" {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}>
                                                    <label for="permission_{{ $key }}" class="form-check-label">{{ $permission->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col">
                                        <div class="alert alert-light text-center">Tidak Ada Data</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <a href="{{ route('role') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i>
                                Kembali</a>
                                @if ($permissions->isNotEmpty())
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                                @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('customJS')
<script type="text/javascript">
    $('#form').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").attr('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("role.permission.give", $role->id) }}',
                method: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    $("button[type='submit']").attr('disabled', false);
                    if(response.status === true){
                        $('#name').removeClass('is-invalid').siblings('small').html('');
                        window.location.reload();
                    }else{
                        var errors = response.errors;
                        if(errors.name){
                            $('#name').addClass('is-invalid').siblings('small').html(errors.name);
                        }else{
                            $('#name').removeClass('is-invalid').siblings('small').html('');
                        }
                    }
                }
            });
        });
</script>
@endsection