@extends('layouts.wrapper')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Permission</h1>
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
                                <label for="description">Deskripsi</label>
                                <input type="text" id="description" name="description" class="form-control" autocomplete="off">
                                <small class="text-danger"></small>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <a href="{{ route('permission') }}" class="btn btn-dark"><i class="fas fa-arrow-left"></i>
                                Kembali</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
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
                url: '{{ route("permission.create") }}',
                method: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    $("button[type='submit']").attr('disabled', false);
                    if(response.status === true){
                        $('#name').removeClass('is-invalid').siblings('small').html('');
                        $('#description').removeClass('is-invalid').siblings('small').html('');
                        window.location.href='{{ route("permission") }}';
                    }else{
                        var errors = response.errors;
                        if(errors.name){
                            $('#name').addClass('is-invalid').siblings('small').html(errors.name);
                        }else{
                            $('#name').removeClass('is-invalid').siblings('small').html('');
                        }
                        if(errors.description){
                            $('#description').addClass('is-invalid').siblings('small').html(errors.description);
                        }else{
                            $('#description').removeClass('is-invalid').siblings('small').html('');
                        }
                    }
                }
            });
        });
</script>
@endsection