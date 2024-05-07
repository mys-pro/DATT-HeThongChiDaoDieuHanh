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

        $('.btn-submit').click(function() {
            var login = 'login';
            var username = $('#InputUsername1').val();
            var password = $('#InputPassword1').val();
            $.ajax({
                url: '<?= getWebRoot() ?>/dang-nhap',
                method: 'POST',
                data: {
                    login: login,
                    username: username,
                    password: password,
                },
                success: function(response) {
                    if(response == 'success') {
                        window.location.href = '<?= getWebRoot() ?>/ac/thong-ke';
                    } else {
                        $('.wrong-account').text('Tài khoản hoặc mật khẩu không đúng.');
                    }
                },
            });
        });
    });
</script>