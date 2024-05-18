<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Đặt lại mật khẩu</h3>
    </div>
    <div class="mb-4">
        <span class="text-center w-100 d-inline-block">Đặt lại mật khẩu mới cho tài khoản</span>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu mới">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword2" placeholder="Xác nhận mật khẩu">
        <button class="btn-eye2 bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye2" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">Đặt lại mật khẩu</button>

    <script>
        $(document).ready(function() {
            $('#InputPassword1').keypress(function(event) {
                if (event.which === 13) {
                    $('#InputPassword2').focus();
                }
            });

            $('#InputPassword1').on('copy paste', function(e) {
                e.preventDefault();
            });

            $('#InputPassword2').keypress(function(event) {
                if (event.which === 13) {
                    $('.btn-submit').click();
                }
            });

            $('#InputPassword2').on('copy paste', function(e) {
                e.preventDefault();
            });

            $('.btn-submit').click(function() {
                var inputPassword1 = $('#InputPassword1').val();
                var inputPassword2 = $('#InputPassword2').val();
                var valid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/;
                if (inputPassword1 == '') {
                    $('.wrong-account').text('Vui lòng nhập mật khẩu.');
                } else {
                    if (!valid.test(inputPassword1)) {
                        $('.wrong-account').text('Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
                    } else {
                        if (inputPassword1 != inputPassword2) {
                            $('.wrong-account').text('Mật khẩu không trùng khớp.');
                        } else {
                            $('.wrong-account').text('');
                            $.ajax({
                                url: window.location.href,
                                type: 'POST',
                                data: {
                                    updatePassword: inputPassword1
                                },
                                success: function(response) {
                                    if (response == "success") {
                                        var toast = $('#login-toast');

                                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#login-toast'))
                                        toastBootstrap.show()

                                        window.location.href = "<?= getWebRoot() ?>";
                                    } else {
                                        $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                                    }
                                }
                            })
                        }
                    }
                }
            });
        });
    </script>
</div>