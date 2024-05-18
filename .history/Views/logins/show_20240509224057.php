<?php
view('blocks.logins.header');
view('logins.index');
view('blocks.logins.footer');
?>

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
                        } 
                        else {
                            $('.wrong-account').text('Tài khoản hoặc mật khẩu không đúng.');
                        }
                    },
                });
            }
        });
    });
</script>