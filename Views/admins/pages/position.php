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
                    <input id="search" class="form-control me-2" type="search" placeholder="Tìm chức vụ..." aria-label="Search">
                    <button id="btn-search" class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                <button id="btn-add-position" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-position-modal">
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
        </div>

        <div class="row g-0">
            <div class="col">
                <table id="table-data" view="position" class="table table-hover border shadow-sm mb-2">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">STT</th>
                            <th class="text-start" scope="col">Tên chức vụ</th>
                            <th class="text-start" scope="col">Mô tả</th>
                            <th class="text-center" scope="col">Thời gian tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['position'] as $index => $value) : ?>
                            <tr data-id="<?= $value["PositionID"] ?>">
                                <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                                <td data-cell="Tên chức vụ" class="text-start"><?= $value['PositionName'] ?></td>
                                <td data-cell="Mô tả" class="text-start"><?= nl2br($value["Description"]) . "\n\n" ?></td>
                                <td data-cell="Thời gian tạo" class="text-center"><?= date('d-m-Y', strtotime($value['DateCreated'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Start: Add Position modal -->
        <div class="modal fade" id="add-position-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-position-modal__label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="add-position-modal__label">Thêm chức vụ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="add-position-name" class="mb-1">Tên chức vụ<span class="text-danger">*</span></label>
                        <input class="textarea-position position-name form-control mb-2" id="add-position-name" placeholder="Nhập tên chức vụ" rows="1"></input>

                        <label for="add-position-description" class="mb-1">Mô tả</label>
                        <textarea class="form-control mb-2" id="add-position-description"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="add-position-submit">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Add Position modal -->

        <!-- Start: View Position modal -->
        <div class="modal fade" id="view-position-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="view-position-modal__label" aria-hidden="true">
        </div>
        <!-- End: View Position modal -->

        <!-- Start: Delete position Model -->
        <div class="modal fade" id="delete-position-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa chức vụ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Bạn có chắc muốn xóa chức vụ này ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                        <button id="submit-delete-position" type="button" class="btn btn-danger">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End: Delete position Model -->
    </div>
</div>