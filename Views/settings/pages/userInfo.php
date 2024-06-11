<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>
    <div class="row g-0 bg-white shadow-sm p-3 pb-2">
        <div id="user-avatar" class="col-12 col-sm-2 mb-2">
            <div class="position-relative d-inline-block">
                <img class="rounded-circle" src="data:image/jpeg;base64,<?= base64_encode($_SESSION["UserInfo"][0]["Avatar"]) ?>" alt="" width="64px" height="64px">
                <input id="avatar" type="file" class="d-none">
                <label id="avatar-btn" for="avatar" class="bg-body-secondary rounded-circle border border-white position-absolute text-center"><i class="bi bi-pencil"></i></label>
            </div>
        </div>

        <div id="user-info" class="col-12 col-sm-5 mb-2 px-2">
            <h6>Thông tin</h6>
            <hr>
            <div class="user-information d-flex justify-content-between">
                <div class="text-secondary">
                    <p>Họ tên:</p>
                    <p>Chức vụ:</p>
                    <p class="m-0">Phòng ban:</p>
                </div>

                <div>
                    <p><strong><?= $_SESSION["UserInfo"][0]["FullName"] ?></strong></p>
                    <p><strong><?= $_SESSION["UserInfo"][0]["PositionName"] == null ? "-" :  $_SESSION["UserInfo"][0]["PositionName"] ?></strong></p>
                    <p><strong><?= $_SESSION["UserInfo"][0]["DepartmentName"] == null ? "-" :  $_SESSION["UserInfo"][0]["DepartmentName"] ?></strong></p>
                </div>
            </div>
        </div>

        <div id="user-account" class="col-12 col-sm-5 mb-2 px-2">
            <h6>Tài khoản</h6>
            <hr>
            <div class="user-information d-flex justify-content-between">
                <div class="text-secondary text-nowrap me-2 d-flex flex-column justify-content-between">
                    <p>Gmail:</p>
                    <p class="m-0">Mật khẩu:</p>
                </div>

                <div class="text-break">
                    <p><strong><?= $_SESSION["UserInfo"][0]["Gmail"] ?></strong></p>
                    <a id="change-password-btn" href="#">Đổi mật khẩu</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change-password-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="change-password-modal__label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="change-password-modal__label">Đổi mật khẩu</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="InputPasswordOld" class="mb-1">Mật khẩu cũ</label>
                    <div class="input-group mb-3 w-100">
                        <input type="password" class="form-control border-end-0" id="InputPasswordOld" placeholder="Nhập mật khẩu mới">
                        <button class="btn-eye-old bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
                            <i id="eye-old" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <label for="InputPassword1" class="mb-1">Nhập mật khẩu mới</label>
                    <div class="input-group mb-3 w-100">
                        <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu mới">
                        <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
                            <i id="eye" class="bi bi-eye-slash"></i>
                        </button>
                    </div>

                    <label for="InputPassword2" class="mb-1">Xác nhận mật khẩu</label>
                    <div class="input-group mb-3 w-100">
                        <input type="password" class="form-control border-end-0" id="InputPassword2" placeholder="Xác nhận mật khẩu">
                        <button class="btn-eye2 bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
                            <i id="eye2" class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="change-password-submit">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>