<?php
view('blocks.logins.header');
view('verifies.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#VerifyInput').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            $('.wrong-account').text('Tài khoản hoặc mật khẩu không đúng.');
        });
    });
</script>