<?php
view('blocks.logins.header');
view('changePasswords.verify');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        // ================================Verify================================================//
        var time = 30;
        var timeDown;

        function startCountdown() {
            timeDown = setInterval(function() {
                time--;
                $("#send-verify").text('Gửi lại mã (' + time + " giây)");
                if (time == 0) {
                    $("#send-verify").text('Gửi lại mã');
                    clearInterval(timeDown);
                }
            }, 1000);
        }

        startCountdown();

        $('#VerifyInput').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            $.get('<?= getWebRoot() ?>/Views/changePasswords/changePassword.php', function(data) {
                localStorage.setItem('savedContent', data);
                $(".form-login").replaceWith(data);
            });
            // var verifyInput = $('#VerifyInput').val();
            // if ($verifyInput == '') {
            //     $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
            // } else {

            //     $('.wrong-account').text('');
            // }
        });

        var savedContent = localStorage.getItem('savedContent');
        if (savedContent) {
            $(".form-login").replaceWith(savedContent);
        }

        $(window).on('unload', function() {
            // Xóa dữ liệu trong Local Storage khi rời khỏi trang
            localStorage.removeItem('savedContent');
        });

        $('#send-verify').click(function() {
            if (time == 0) {
                time = 30;
                startCountdown();
                var sendVerify = true;
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        sendVerify: sendVerify
                    },
                    success: function(response) {
                        if (response == 'fail') {
                            $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                        }
                    }
                });
            }
        });
        // ================================Change pass===========================================//
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
                    }
                }
            }
        });
    });
</script>