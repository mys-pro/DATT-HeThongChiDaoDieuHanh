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

    <div class="modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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