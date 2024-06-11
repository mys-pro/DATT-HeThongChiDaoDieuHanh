<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>

    <div class="row g-0">
        <div class="col">
            <ul class="nav nav-underline bg-white shadow-sm flex-nowrap overflow-auto">
                <li class="nav-item">
                    <a class="text-nowrap nav-link px-4 text-secondary <?= $active == 'department' ? 'active' : '' ?>" aria-current="page" href="<?= getWebRoot() ?>/kb/phong-ban">Phòng ban</a>
                </li>

                <li class="nav-item">
                    <a class="text-nowrap nav-link px-4 text-secondary <?= $active == 'position' ? 'active' : '' ?>" aria-current="page" href="<?= getWebRoot() ?>/kb/chuc-vu">Chức vụ</a>
                </li>
            </ul>
        </div>
    </div>

    <div id="page">
        <div class="row g-0">
            <div class="col d-flex justify-content-between">
                <div class="search d-flex p-2">
                    <input id="search" class="form-control me-2" type="search" placeholder="Tìm phòng ban..." aria-label="Search">
                    <button id="btn-search" class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <button id="btn-add-department" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-department-modal">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

        <div class="row g-0">
            <div class="col">
                <table id="table-data" view="department" class="table table-hover border shadow-sm mb-2">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">STT</th>
                            <th class="text-start" scope="col">Tên phòng ban</th>
                            <th class="text-center" scope="col">Thời gian tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['department'] as $index => $value) : ?>
                            <tr data-id="<?= $value["DepartmentID"] ?>">
                                <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                                <td data-cell="Tên phòng ban" class="text-start"><?= $value['DepartmentName'] ?></td>
                                <td data-cell="Thời gian tạo" class="text-center"><?= date('d-m-Y', strtotime($value['DateCreated'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Start: Add Department modal -->
        <div class="modal fade" id="add-department-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-department-modal__label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add-department-modal__label">Thêm phòng ban</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="add-department-name" class="mb-1">Tên phòng ban <span class="text-danger">*</span></label>
                        <input class="textarea-department department-name form-control mb-2" id="add-department-name" placeholder="Nhập tên phòng ban" rows="1"></input>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-department-submit">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Add department modal -->

        <!-- Start: View Department modal -->
        <div class="modal fade" id="view-department-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="view-department-modal__label" aria-hidden="true">
        </div>
        <!-- End: View department modal -->

        <!-- Start: Delete Department Model -->
        <div class="modal fade" id="delete-department-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa phòng ban</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc muốn xóa phòng ban này ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                        <button id="submit-delete-department" type="button" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Delete Department Model -->
    </div>
</div>