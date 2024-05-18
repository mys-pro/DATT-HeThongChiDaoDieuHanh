<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Đăng nhập</h3>
    </div>
    <div class="mb-3">
        <input type="email" class="form-control" id="InputUsername1" placeholder="Nhập tài khoản">
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button type="button" class="btn btn-primary btn-submit w-100 mb-3">ĐĂNG NHẬP</button>
    <a href="<?= getWebRoot() ?>/quen-mat-khau" class="w-100 text-center d-inline-block text-decoration-none">Quên mật khẩu?</a>
</div>