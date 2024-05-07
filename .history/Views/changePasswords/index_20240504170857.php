<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Đặt lại mật khẩu</h3>
    </div>
    <div class="mb-4">
        <span class="text-center w-100 d-inline-block">Đặt lại mật khẩu mới cho tài khoản</span>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Mật khẩu">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword2" placeholder="Nhập mật khẩu">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block d-none"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">Xác nhận</button>
    <a href="<?= getWebRoot() ?>/dang-nhap" class="w-100 text-center d-inline-block text-decoration-none">Gửi lại mã (30 giây)</a>
</div>