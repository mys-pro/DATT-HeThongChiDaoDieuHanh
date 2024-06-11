<div class="form-login bg-white rounded-3">
    <div class="mb-4">
        <h3 class="text-center ">Kích hoạt tài khoản</h3>
    </div>
    <div class="mb-3">
        <span class="fs-6"><span class="fw-semibold">Tài khoản đăng nhập: </span><?= $data["account"] ?></span>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu">
        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <input type="password" class="form-control border-end-0" id="InputPassword2" placeholder="Nhập lại mật khẩu">
        <button class="btn-eye2 bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
            <i id="eye2" class="bi bi-eye-slash"></i>
        </button>
    </div>
    <div class="input-group mb-3 w-100">
        <span class="wrong-account text-center text-danger w-100 d-inline-block"></span>
    </div>
    <button id="active-btn" type="button" class="btn btn-primary btn-submit w-100 mb-3">Kích hoạt</button>
</div>