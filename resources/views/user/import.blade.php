@extends('layouts.wrapper')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Upload Pengguna</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form id="form" action="" method="post" enctype="multipart/form-data">
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label for="file">File Upload</label><br>
                                <span class="text-muted text-small">Ukuran file maksimal 2 MB. Ekstensi file .xls, .xlsx</span>
                                <input type="file" id="file" name="file" class="form-control">
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
@section('customJS')
    <script type="text/javascript">
        $('#form').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").attr('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("users.import.process") }}',
                method: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    $("button[type='submit']").attr('disabled', false);
                    if(response.status === true){
                        window.location.href='{{ route("users") }}';
                    }else{
                        var errors = response.errors;
                        if(errors.file){
                            $('#file').addClass('is-invalid').siblings('small').html(errors.file);
                        }else{
                            $('#file').removeClass('is-invalid').siblings('small').html('');
                        }
                    }
                }
            });
        });
    </script>
@endsection