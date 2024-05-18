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
            $.ajax({
                type: "POST",
                url: "<?= getWebRoot() ?>/doi-mat-khau", // PHP file to process the form data
                data: formData,
                success: function(response) {
                    $("#result").html(response); // Display response in the result div
                    setTimeout(function() {
                        window.location.href = "newpage.php"; // Redirect to new page after 3 seconds
                    }, 3000);
                }
            });
            // var verifyInput = $('#VerifyInput').val();
            // if ($verifyInput == '') {
            //     $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
            // } else {

            //     $('.wrong-account').text('');
            // }
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
    });
</script>