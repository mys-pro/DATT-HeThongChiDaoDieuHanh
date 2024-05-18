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
                                updatePassword: updatePassword
                            },
                            success: function(response) {
                                
                            }
                        })
                    }
                }
            }
        });
    });
</script>