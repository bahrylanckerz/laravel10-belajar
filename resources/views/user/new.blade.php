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
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" id="name" name="name" class="form-control" autocomplete="off">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" id="email" name="email" class="form-control" autocomplete="off">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" class="form-control" autocomplete="off">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Konfirmasi Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" autocomplete="off">
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="roles">Roles</label>
                                <select id="roles" name="roles[]" class="form-control select2" multiple style="width:100%">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="photo">Foto Profil</label>
                                <input type="file" id="photo" name="photo" class="form-control">
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <a href="{{ route('users') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('customCSS')
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
@endsection
@section('customJS')
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".select2").select2();
        });
    </script>
    <script type="text/javascript">
        $('#form').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").attr('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("users.create") }}',
                method: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    $("button[type='submit']").attr('disabled', false);
                    if(response.status === true){
                        $('#name').removeClass('is-invalid').siblings('small').html('');
                        $('#email').removeClass('is-invalid').siblings('small').html('');
                        $('#password').removeClass('is-invalid').siblings('small').html('');
                        $('#confirmPpassword').removeClass('is-invalid').siblings('small').html('');
                        window.location.href='{{ route("users") }}';
                    }else{
                        var errors = response.errors;
                        if(errors.name){
                            $('#name').addClass('is-invalid').siblings('small').html(errors.name);
                        }else{
                            $('#name').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.email){
                            $('#email').addClass('is-invalid').siblings('small').html(errors.email);
                        }else{
                            $('#email').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.password){
                            $('#password').addClass('is-invalid').siblings('small').html(errors.password);
                        }else{
                            $('#password').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.confirmPassword){
                            $('#confirmPassword').addClass('is-invalid').siblings('small').html(errors.confirmPassword);
                        }else{
                            $('#confirmPassword').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.roles){
                            $('#roles').addClass('is-invalid').siblings('small').html(errors.roles);
                        }else{
                            $('#roles').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.photo){
                            $('#photo').addClass('is-invalid').siblings('small').html(errors.photo);
                        }else{
                            $('#photo').removeClass('is-invalid').siblings('small').html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection