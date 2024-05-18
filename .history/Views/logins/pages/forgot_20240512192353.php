<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center">Quên mật khẩu</h3>
    </div>
    <div class="mb-4">
        <span class="text-center w-100 d-inline-block">Vui lòng nhập email để lấy mã xác nhận</span>
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" id="InputEmail" placeholder="Nhập email đăng nhập">
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button id="send-mail" type="button" class="btn btn-primary btn-submit w-100 mb-3">Lấy lại mật khẩu</button>
    <a href="<?= getWebRoot() ?>/dang-nhap" class="w-100 text-center d-inline-block text-decoration-none">Quay lại đăng nhập</a>

    <div class="modal-loading modal d-flex flex-column justify-content-center" tabindex="-1">
        <div class="spinner spinner-border text-primary mx-auto" role="status"></div>
        <span class="text-center fs-6 fw-bold text-light-emphasis mt-3">Loading...</span>
    </div>

    <script>
        $(document).ready(function() {
            $('.modal').modal('show');

            $('#InputEmail').keypress(function(event) {
                if (event.which === 13) {
                    $('.btn-submit').click();
                }
            });

            $('.btn-submit').click(function() {
                var email = $("#InputEmail").val();
                if (email != '') {
                    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (emailPattern.test(email)) {
                        $.ajax({
                            url: '<?= getWebRoot() ?>/quen-mat-khau',
                            method: 'POST',
                            data: {
                                email: email,
                            },
                            success: function(response) {
                                window.location.href = "<?= getWebRoot() ?>/ma-xac-nhan/" + response;
                                if (response == 'wrong') {
                                    $('.wrong-account').text('Email không tồn tại trong hệ thống.');
                                } else if (response == 'fail') {
                                    $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                                } else {
                                    $('.wrong-account').text('');
                                }
                            },
                        });
                    } else {
                        $(".wrong-account").text("Định dạng email không hợp lệ.");
                    }
                } else {
                    $(".wrong-account").text("Vui lòng nhập email.");
                }
            });
        });
    </script>
</div>