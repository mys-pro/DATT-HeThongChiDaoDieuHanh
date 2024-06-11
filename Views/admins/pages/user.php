<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>

    <div class="row g-0">
        <div class="col d-flex justify-content-between">
            <div class="search d-flex p-2">
                <input id="search" class="form-control me-2" type="search" placeholder="Tìm kiểm người dùng..." aria-label="Search">
                <button id="btn-search" class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <button id="btn-add-user" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-user-modal">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-data" view="user" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">STT</th>
                        <th class="text-start" scope="col">Họ tên</th>
                        <th class="text-center" scope="col">Chức vụ</th>
                        <th class="text-center" scope="col">Phòng ban</th>
                        <th class="text-center" scope="col">Số điện thoại</th>
                        <th class="text-center" scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['user'] as $index => $value) : ?>
                        <tr data-id="<?= $value["UserID"] ?>">
                            <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                            <td data-cell="Họ tên" class="text-start">
                                <div class="user-info d-flex align-items-center">
                                    <img class="rounded-circle me-2" src="data:image/jpeg;base64,<?= base64_encode($value["Avatar"]) ?>" alt="" width="36px" height="36px">
                                    <div class="user-info-content">
                                        <p class="User-name p-0 m-0"><?= $value["FullName"] ?></p>
                                        <p class="User-gmail p-0 m-0 text-secondary"><?= $value["Gmail"] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td data-cell="Chức vụ" class="text-center"><?= $value["PositionName"] != null ? $value["PositionName"] : "-" ?></td>
                            <td data-cell="Phòng ban" class="text-center"><?= $value["DepartmentName"] != null ? $value["DepartmentName"] : '-' ?></td>
                            <td data-cell="Số điện thoại" class="text-center"><?= $value["PhoneNumber"] ?></td>
                            <td data-cell="Trạng thái" class="text-center">
                                <span class="badge fw-semibold <?= $value["Status"] == 1 ? 'text-bg-success' : 'text-bg-warning' ?>"><?= $value["Status"] == 1 ? 'Đang hoạt động' : 'Chờ xác nhận' ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Start: Add User modal -->
    <div class="modal fade" id="add-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-user-modal__label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add-user-modal__label">Thêm người dùng</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="add-user-name" class="mb-1">Họ tên<span class="text-danger">*</span></label>
                            <input class="form-control mb-2" id="add-user-name" placeholder="Nhập họ tên"></input>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="add-user-phone" class="mb-1">Số điện thoại</label>
                            <input class="form-control mb-2" id="add-user-phone" placeholder="Nhập số điện thoại"></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label for="add-user-position" class="mb-1">Chức vụ</label>
                            <select name="" id="add-user-position" class="form-select mb-2">
                                <option selected hidden disabled>Chọn chức vụ</option>
                                <?php foreach ($data["position"] as $value) : ?>
                                    <option value="<?= $value["PositionID"] ?>"><?= $value["PositionName"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 col-sm-6">
                            <label for="add-user-department" class="mb-1">Phòng ban</label>
                            <select name="" id="add-user-department" class="form-select mb-2">
                                <option selected hidden disabled>Chọn phòng ban</option>
                                <?php foreach ($data["department"] as $value) : ?>
                                    <option value="<?= $value["DepartmentID"] ?>"><?= $value["DepartmentName"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="add-user-gmail" class="mb-1">Gmail<span class="text-danger">*</span></label>
                            <input class="form-control mb-2" id="add-user-gmail" placeholder="Nhập gmail"></input>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <label for="" class="mb-1">Phân quyền theo vai trò<span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="form-check mb-2 me-2">
                                    <input name="role" data-id="1" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                        Trưởng phòng
                                    </label>
                                </div>
                                <div class="form-check mb-2 me-2">
                                    <input name="role" data-id="2" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                        Phó phòng
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input name="role" data-id="3" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" checked>
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
                                    <input name="additional_permissions" data-id="6" class="form-check-input" type="checkbox" value="" id="flexCheckDefault1">
                                    <label class="form-check-label" for="flexCheckDefault1">
                                        Quản trị
                                    </label>
                                </div>
                                <div class="form-check mb-2 me-2">
                                    <input name="additional_permissions" data-id="4" class="form-check-input" type="checkbox" value="" id="flexCheckDefault2">
                                    <label class="form-check-label" for="flexCheckDefault2">
                                        Chỉ đạo
                                    </label>
                                </div>
                                <div class="form-check mb-2">
                                    <input name="additional_permissions" data-id="5" class="form-check-input" type="checkbox" value="" id="flexCheckDefault3">
                                    <label class="form-check-label" for="flexCheckDefault3">
                                        Thẩm định
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-user-submit">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Add User modal -->

    <!-- Start: View User modal -->
    <div class="modal fade" id="view-user-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="view-user-modal__label" aria-hidden="true">
    </div>
    <!-- End: View User modal -->

    <!-- Start: Delete User Model -->
    <div class="modal fade" id="delete-user-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa người dùng</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc muốn xóa người dùng này ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                        <button id="submit-delete-user" type="button" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Delete User Model -->
</div>