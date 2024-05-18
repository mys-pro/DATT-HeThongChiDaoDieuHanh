<?php
view('blocks.logins.header');
view('blocks.logins.sidebar', ['active' => $active]);
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
                $('.btn-login').click();
            }
        });

        $('.btn-login').click(function() {
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
                        $('.wrong-account').removeClass('d-none');
                    }
                },
            });
        });
    });
</script>