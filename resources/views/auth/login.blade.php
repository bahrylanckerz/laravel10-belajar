<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login | Belajar Laravel 10</title>
    @include('layouts.head')
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="http://localhost/stisla/assets/img/stisla-fill.svg" alt="logo" width="100"
                                class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Masuk</h4>
                            </div>
                            <div class="card-body">
                                <form id="form" action="" method="post">
                                    @csrf
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
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input"
                                                tabindex="3" id="remember">
                                            <label class="custom-control-label" for="remember">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Masuk</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Copyright &copy; Belajar Laravel 10
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @include('layouts.script')

    <script type="text/javascript">
        $('#form').submit(function(e){
            e.preventDefault();
            $("button[type='submit']").attr('disabled', true);
            var formData = new FormData(this);
            $.ajax({
                url: '{{ route("login.process") }}',
                method: 'post',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response){
                    $("button[type='submit']").attr('disabled', false);
                    if(response.status === true){
                        $('#email').removeClass('is-invalid').siblings('small').html('');
                        $('#password').removeClass('is-invalid').siblings('small').html('');
                        window.location.href=response.redirect;
                    }else{
                        var errors = response.errors;
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
                    }
                }
            });
        });
    </script>
</body>

</html>