<!-- General JS Scripts -->
<script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/modules/popper.js') }}"></script>
<script src="{{ asset('assets/modules/tooltip.js') }}"></script>
<script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('assets/modules/moment.min.js') }}"></script>
<script src="{{ asset('assets/modules/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        @if (Session::has('success'))
            iziToast.success({
                title: 'Berhasil!',
                message: '{{ Session::get('success') }}',
                position: 'topRight',
            });
        @elseif (Session::has('warning'))
            iziToast.warning({
                title: 'Peringatan!',
                message: '{{ Session::get('warning') }}',
                position: 'topRight',
            });
        @elseif (Session::has('error'))
            iziToast.error({
                title: 'Gagal!',
                message: '{{ Session::get('error') }}',
                position: 'topRight',
            });
        @endif
</script>