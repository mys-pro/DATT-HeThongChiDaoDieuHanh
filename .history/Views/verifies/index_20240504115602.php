<form class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Nhập mã xác nhận</h3>
    </div>
    <div class="mb-4">
        <span class="text-center w-100 d-inline-block">
            Hệ thống đã gửi mã xác nhận đến email của bạn, <br>
            Vui lòng kiểm tra email
    </span>
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" id="InputEmail" placeholder="Nhập email đăng nhập">
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block d-none"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">Lấy lại mật khẩu</button>
    <a href="<?= getWebRoot() ?>/dang-nhap" class="w-100 text-center d-inline-block text-decoration-none">Quay lại đăng nhập</a>
</form>