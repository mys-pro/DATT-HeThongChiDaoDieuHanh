<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="view-user-modal__label">Người dùng</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <label for="view-user-name" class="mb-1">Họ tên<span class="text-danger">*</span></label>
                    <input class="form-control mb-2" id="view-user-name" placeholder="Nhập họ tên" value="<?= $user[0]["FullName"] ?>"></input>
                </div>

                <div class="col-12 col-sm-6">
                    <label for="view-user-phone" class="mb-1">Số điện thoại</label>
                    <input class="form-control mb-2" id="view-user-phone" placeholder="Nhập số điện thoại" value="<?= $user[0]["PhoneNumber"] ?>"></input>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-6">
                    <label for="view-user-position" class="mb-1">Chức vụ</label>
                    <select name="" id="view-user-position" class="form-select mb-2">
                        <option selected hidden disabled>Chọn chức vụ</option>
                        <?php foreach ($position as $value) : ?>
                            <option <?= $user[0]["PositionID"] == $value["PositionID"] ? "selected" : "" ?> value="<?= $value["PositionID"] ?>"><?= $value["PositionName"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-12 col-sm-6">
                    <label for="view-user-department" class="mb-1">Phòng ban</label>
                    <select name="" id="view-user-department" class="form-select mb-2">
                        <option selected hidden disabled>Chọn phòng ban</option>
                        <?php foreach ($department as $value) : ?>
                            <option <?= $user[0]["DepartmentID"] == $value["DepartmentID"] ? "selected" : "" ?> value="<?= $value["DepartmentID"] ?>"><?= $value["DepartmentName"] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <label for="view-user-gmail" class="mb-1">Gmail<span class="text-danger">*</span></label>
                    <input class="form-control mb-2 bg-transparent" id="view-user-gmail" placeholder="Nhập gmail" value="<?= $user[0]["Gmail"] ?>" disabled></input>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="" class="mb-1">Phân quyền theo vai trò<span class="text-danger">*</span></label>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="form-check mb-2 me-2">
                            <input name="role" data-id="1" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" <?= checkRole($role, 1) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexRadioDefault1">
                                Trưởng phòng
                            </label>
                        </div>
                        <div class="form-check mb-2 me-2">
                            <input name="role" data-id="2" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" <?= checkRole($role, 2) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexRadioDefault2">
                                Phó phòng
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input name="role" data-id="3" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" <?= checkRole($role, 3) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexRadioDefault3">
                                Chuyên viên
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="" class="mb-1">Quyền bổ sung</label>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div class="form-check mb-2 me-2">
                            <input name="additional_permissions" data-id="6" class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" <?= checkRole($role, 6) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexCheckDefault1">
                                Quản trị
                            </label>
                        </div>
                        <div class="form-check mb-2 me-2">
                            <input name="additional_permissions" data-id="4" class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" <?= checkRole($role, 4) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexCheckDefault2">
                                Chỉ đạo
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input name="additional_permissions" data-id="5" class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" <?= checkRole($role, 5) ? "checked" : "" ?> >
                            <label class="form-check-label" for="flexCheckDefault3">
                                Thẩm định
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="delete-user-submit">Xóa</button>
            <button type="button" class="btn btn-primary" id="save-user-submit">Lưu</button>
        </div>
    </div>
</div>