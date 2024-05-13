<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Đăng nhập</h3>
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" id="InputUsername1" placeholder="Nhập tài khoản">
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">ĐĂNG NHẬP</button>
    <a href="<?= getWebRoot() ?>/quen-mat-khau" class="w-100 text-center d-inline-block text-decoration-none">Quên mật khẩu?</a>

    <script>
        $(document).ready(function() {
            $('#InputUsername1').keypress(function(event) {
                if (event.which === 13) {
                    $('#InputPassword1').focus();
                }
            });

            $('#InputPassword1').keypress(function(event) {
                if (event.which === 13) {
                    $('.btn-submit').click();
                }
            });

            $('#InputPassword1').on('copy paste', function(e) {
                e.preventDefault();
            });

            $('.btn-submit').click(function() {
                var login = 'login';
                var username = $('#InputUsername1').val();
                var password = $('#InputPassword1').val();
                if (username == '') {
                    $('.wrong-account').text('Vui lòng nhập thông tin tài khoản.');
                } else {
                    $.ajax({
                        url: '<?= getWebRoot() ?>/dang-nhap',
                        method: 'POST',
                        data: {
                            login: login,
                            username: username,
                            password: password,
                        },
                        success: function(response) {
                            if (response == 'success') {
                                window.location.href = '<?= getWebRoot() ?>/ac/cong-viec';
                            } else if (response == 'notActive') {
                                $('.wrong-account').text('Tài khoản chưa được kích hoạt.');
                            } else {
                                $('.wrong-account').text('Tài khoản hoặc mật khẩu không đúng.');
                            }
                        },
                    });
                }
            });
        });
    </script>
</div>