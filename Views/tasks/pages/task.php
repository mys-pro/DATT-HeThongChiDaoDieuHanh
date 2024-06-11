<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>
    <div class="row g-0">
        <div class="col d-flex justify-content-between">
            <div class="search d-flex p-2">
                <input id="search" class="form-control me-2" type="search" placeholder="Tìm công việc..." aria-label="Search">
                <button id="btn-search" class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <?php if (checkRole($_SESSION["Role"], 4)) : ?>
                <button id="btn-add-task" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-task-modal">
                    <i class="bi bi-plus-lg"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-data" view="task" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">STT</th>
                        <th class="text-start" scope="col" style="width: 220px">Tên công việc</th>
                        <th class="text-start" scope="col">Tình trạng</th>
                        <th class="text-start" scope="col">Người giao</th>
                        <th class="text-center" scope="col">Hạn hoàn thành</th>
                        <th class="text-center" scope="col" style="min-width: 100px">Tiến độ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['taskList'] as $index => $value) : ?>
                        <tr data-id="<?= $value["TaskID"] ?>">
                            <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                            <td data-cell="Tên công việc" class="text-start text-break"><?= nl2br($value["TaskName"]) . "\n\n" ?></td>
                            <td data-cell="Tình trạng" class="text-start" data-value="<?= $value["Status"] ?>">
                                <span class="badge bg-opacity-25 fw-semibold"><?= $value["Status"] ?></span>
                            </td>
                            <td data-cell="Người giao" class="text-start">
                                <img class="rounded-circle" src="data:image/jpeg;base64,<?= $value["Avatar"] ?>" alt="" width="32px" height="32px">
                                <span class="ms-2"><?= $value["FullName"] ?></span>
                            </td>
                            <td data-cell="Hạn hoàn thành" class="text-center"><?= $value["Deadline"] == null ? "-" :  $value["Deadline"] ?>
                            </td>
                            <td data-cell="Tiến độ" class="text-center">
                                <div class="progress-task d-flex align-items-center">
                                    <div class="progress flex-fill me-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: <?= $value["Progress"] ?>%"></div>
                                    </div>
                                    <span class="progress-text text-start"><?= $value["Progress"] ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php foreach ($data["subTask"] as $value2) : ?>
                            <?php if ($value2["ParentTaskID"] == $value["TaskID"]) : ?>
                                <tr data-id="<?= $value2["TaskID"] ?>" class="sub-task">
                                    <td data-cell="STT" class="text-center"> - </td>
                                    <td data-cell="Tên công việc" class="text-start text-break"><?= nl2br($value2["TaskName"]) . "\n\n" ?></td>
                                    <td data-cell="Tình trạng" class="text-start" data-value="<?= $value2["Status"] ?>">
                                        <span class="badge bg-opacity-25 fw-semibold"><?= $value2["Status"] ?></span>
                                    </td>
                                    <td data-cell="Người giao" class="text-start">
                                        <img class="rounded-circle" src="data:image/jpeg;base64,<?= $value2["Avatar"] ?>" alt="" width="32px" height="32px">
                                        <span class="ms-2"><?= $value2["FullName"] ?></span>
                                    </td>
                                    <td data-cell="Hạn hoàn thành" class="text-center"><?= $value2["Deadline"] == null ? "-" :  $value["Deadline"] ?>
                                    </td>
                                    <td data-cell="Tiến độ" class="text-center">
                                        <div class="progress-task d-flex align-items-center">
                                            <div class="progress flex-fill me-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                <div class="progress-bar" style="width: <?= $value2["Progress"] ?>%"></div>
                                            </div>
                                            <span class="progress-text text-start"><?= $value2["Progress"] ?>%</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Start: Add Task modal -->
    <div class="modal fade" id="add-task-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="add-task-modal__label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="add-task-modal__label">Thêm công việc</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="add-task-name" class="mb-1">Tên công việc <span class="text-danger">*</span></label>
                    <input class="textarea-task task-name form-control mb-2" id="add-task-name" placeholder="Nhập tên công việc" rows="1"></input>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add-task-submit">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Add Task modal -->

    <!-- Start: View Task modal -->
    <div class="modal fade" id="view-task-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    </div>
    <!-- End: View Task modal -->

    <!-- Start: Delete Task Model -->
    <div class="modal fade" id="delete-task-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Xóa công việc</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Bạn có chắc muốn xóa công việc này ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                    <button id="submit-delete-task" type="button" class="btn btn-danger">Xóa</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Delete Task Model -->

    <!-- Start: Feedback Task Model -->
    <div class="modal fade" id="feedback-task-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    </div>
    <!-- End: Feedback Task Model -->

    <!-- Start: Notify Model -->
    <div class="modal fade" id="notify-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="notify-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="notify-modalLabel">Thông báo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="notify-content"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Notify Model -->
</div>