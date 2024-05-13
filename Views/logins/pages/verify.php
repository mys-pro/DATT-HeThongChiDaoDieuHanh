<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Nhập mã xác nhận</h3>
    </div>
    <div class="mb-4">
        <span class="text-center w-100 d-inline-block">
            Hệ thống đã gửi mã xác nhận đến email của bạn, <br>
            vui lòng kiểm tra email.
        </span>
    </div>
    <div class="mb-3">
        <input type="text" class="form-control" id="VerifyInput" placeholder="Mã xác nhận">
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">Xác nhận</button>
    <button id="send-verify" class="w-100 text-center d-inline-block text-decoration-none border-0 bg-transparent">Gửi lại mã (30 giây)</button>

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
                            if (response == "wrong") {
                                $('.wrong-account').text('Mã xác nhận không đúng.');
                            } else if (response == "overTime") {
                                $('.wrong-account').text('Mã xác nhận đã quá hạn.');
                            } else {
                                window.location.href = '<?= getWebRoot() ?>/doi-mat-khau/' + response;
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
                            if (response == 'fail') {
                                $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                            }
                        }
                    });
                }
            });
        });
    </script>
</div>