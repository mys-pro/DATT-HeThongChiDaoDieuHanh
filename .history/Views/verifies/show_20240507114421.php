<?php
view('blocks.logins.header');
view('verifies.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
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
            var verify = $('#VerifyInput').val();
            if (verify == '') {
                $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
            } else {
                $('.wrong-account').text('');
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        verify: verify
                    },
                    success: function(response) {
                        alert(response);
                        if(response == "wrong") {
                            $('.wrong-account').text('Mã xác nhận không đúng.');
                        } else if (response = "overTime") {
                            $('.wrong-account').text('Mã xác nhận đã quá hạn.');
                        } else {
                            window.location.href = '<?= getWebRoot() ?>/doi-mat-khau/'+response;
                        }
                    }
                });
            }
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
                        if(response == 'fail') {
                            $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                        }
                    }
                });
            }
        });
    });
</script>