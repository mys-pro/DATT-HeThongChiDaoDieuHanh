<?php
view('blocks.logins.header');
view('changePasswords.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputPassword1').keypress(function(event) {
            if (event.which === 13) {
                $('#InputPassword2').focus();
            }
        });

        $('#InputPassword2').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            $inputPassword1 = $('#InputPassword1').val();
            $inputPassword2 = $('#InputPassword2').val();
            if($inputPassword1 == '') {
                $('.wrong-account').text('Vui lòng nhập mật khẩu.');
            } else {
                if($inputPassword1 != $inputPassword2) {
                    $('.wrong-account').text('Mật khẩu không trùng khớp.');
                } else {
                    
                }
            }
        });
    });
</script>