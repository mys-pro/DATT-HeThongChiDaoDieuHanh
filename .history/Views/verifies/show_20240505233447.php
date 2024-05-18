<?php
view('blocks.logins.header');
view('verifies.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        var time = 30;
        setInterval(function() {
            time--;
            if (time <= 0) {
                $("#send-verify").text('Gửi lại mã');
            } else {
                $("#send-verify").text('Gửi lại mã (' + time + " giây)");
            }
        }, 1000);


        $('#VerifyInput').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            var verifyInput = $('#VerifyInput').val();
            if ($verifyInput == '') {
                $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
            } else {

                $('.wrong-account').text('');
            }
        });

        $('#send-verify').click(function() {
            if (time == 0) {
                time = 30;
                // var sendVerify = true;
                // $.ajax({
                //     url: window.location.href,
                //     type: 'POST',
                //     data: {
                //         sendVerify: sendVerify
                //     },
                //     success: function(response) {
                //         alert(response);
                //         if(response == "success") {
                //             time = 30;
                //         }
                //     }
                // });
            }
        });
    });
</script>