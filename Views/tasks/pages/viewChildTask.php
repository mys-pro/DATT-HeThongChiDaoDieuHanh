<div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-header-title d-flex flex-wrap align-items-center">
                <h1 class="modal-title fs-5 me-3 d-inline-block" id="staticBackdropLabel">Công việc</h1>
                <span class="badge bg-opacity-25 fw-semibold me-2" data-value="<?= $status ?>"><?= $status ?></span>
                <?php if (strpos($status, 'Hoàn thành') !== false && $assignedBy != $_SESSION["UserInfo"][0]["UserID"]) : ?>
                    <button id="feedback-task-btn" type="button" class="btn border-0 text-primary">Xem nhận xét</button>
                <?php elseif ($status == "Từ chối phê duyệt") : ?>
                    <button id="feedback-task-btn" type="button" class="btn border-0 text-primary">Xem lý do</button>
                <?php endif; ?>
            </div>
            <?php if ($view == 'task') : ?>
                <div class="btn-group ms-auto" id="menu-kebab-task-view">
                    <button type="button" class="btn border-0 dropdown-toggle p-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical text-secondary"></i>
                    </button>
                    <ul class="dropdown-menu p-2">
                        <li class="dropdown-item rounded-3 p-0">
                            <button <?= checkRole($_SESSION["Role"], 1) || checkRole($_SESSION["Role"], 2) ? 'id="forward-task-btn"' : "" ?> type="button" class="btn border-0 text-start w-100" <?= (checkRole($_SESSION["Role"], 1) || checkRole($_SESSION["Role"], 2)) && $assignedBy != $_SESSION["UserInfo"][0]["UserID"] ? "" : "disabled" ?>><i class="bi bi-arrow-clockwise me-2"></i>Chuyển tiếp</button>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-item rounded-3 p-0">
                            <button <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] ? 'id="delete-task-btn"' : "" ?> type="button" class="btn border-0 text-start w-100 text-danger" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] ? "" : "disabled" ?>><i class="bi bi-trash3 me-2"></i>Xóa</button>
                        </li>
                    </ul>
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
            <?php else : ?>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
            <?php endif; ?>
        </div>
        <div class="modal-body">
            <label for="view-task-name" class="mb-1">Tên công việc <span class="text-danger">*</span></label>
            <textarea class="textarea-task form-control rounded-0 mb-2 bg-transparent text-wrap text-break" id="view-task-name" rows="1" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && $view == 'task' ? "" : "disabled" ?>><?= $taskName ?></textarea>
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div id="priority-dropdown" class="dropdown d-flex align-items-center mb-2">
                    <label for="view-task-priority">Độ ưu tiên:</label>
                    <select name="" id="view-task-priority" class="ms-2 border-0" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && stripos($status, "Hoàn thành") === false && $view == 'task' ? "" : "disabled" ?>>
                        <option value="1" data-title="Thấp" data-icon="bi bi-square-fill text-secondary text-opacity-50" <?= $priority == 1 ? "selected" : "" ?>>Thấp</option>
                        <option value="2" data-title="Vừa" data-icon="bi bi-square-fill text-primary text-opacity-75" <?= $priority == 2 ? "selected" : "" ?>>Vừa</option>
                        <option value="3" data-title="Cao" data-icon="bi bi-square-fill text-danger text-opacity-75" <?= $priority == 3 ? "selected" : "" ?>>Cao</option>
                    </select>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <label for="deadline-task">Thời gian: </label>
                    <input type="number" class="deadline-input form-control rounded-0 p-0 ps-2 mx-2 bg-transparent" min="2" value="<?= $deadlineTask ?>" id="deadline-task" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && stripos($status, "Hoàn thành") === false && $view == 'task' ? "" : "disabled" ?>>
                    <span>ngày</span>
                </div>
            </div>
            <div class="AssignedBy mb-2 d-flex align-items-center">
                <span class="me-2">Người giao việc: </span>
                <div class="AssignedBy-info d-flex align-items-center">
                    <img class="rounded-circle me-2" src="data:image/jpeg;base64,<?= base64_encode($assignedInfo[0]["Avatar"]) ?>" alt="" width="36px" height="36px">
                    <div class="AssignedBy-name">
                        <p class="m-0 text-primary"><?= $assignedInfo[0]["FullName"] ?></p>
                        <p class="m-0 text-secondary">
                            <?= $assignedInfo[0]["PositionName"] ?>
                            <?= $assignedInfo[0]["DepartmentName"] != null ? '-' . $assignedInfo[0]["DepartmentName"] : '' ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="Description mb-2">
                <button id="Description-btn" class="border-0 bg-transparent text-primary"><i class="bi bi-text-left me-2"></i>Mô tả</button>
                <div class="d-none">
                    <textarea class="textarea-task form-control mt-2" id="Description-view-task" rows="1" data-readonly="<?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && $view == 'task' ? "true" : "false" ?>">
                        <?= $description ?>
                    </textarea>
                </div>
            </div>

            <label class="fw-semibold ms-1 mb-1"><i class="bi bi-person-fill me-2 text-secondary"></i>Người thực hiện <span class="text-danger">*</span></label>
            <div id="performers" class="d-flex flex-wrap align-items-center justify-content-between">
                <select name="" id="TaskPerformers" class="border-0  mb-2" <?= $status === "Dự thảo" ? "" : "disabled" ?>>
                    <option value="null" data-title="Chọn người thực hiện" data-icon="bi-person-fill" disabled hidden <?= $performerID == null ? "selected" : "" ?>>Chọn người thực hiện</option>
                    <?php foreach ($departmentList as $department) : ?>
                        <optgroup label="<?= $department["DepartmentName"] ?>">
                            <?php foreach ($userList as $user) : ?>
                                <?php if ($user["DepartmentID"] == $department["DepartmentID"] && $department["DepartmentID"] == $_SESSION["UserInfo"][0]["DepartmentID"]) : ?>
                                    <option value="<?= $user["UserID"] ?>" data-title="<?= $user["FullName"] ?>" data-role="<?= $user["PositionName"] ?>" data-company="<?= $user["DepartmentName"]  ?>" data-avatar="data:image/jpeg;base64,<?= base64_encode($user["Avatar"]) ?>" <?= $performerID == $user["UserID"] ? "selected" : "" ?>>
                                        <?= $user["FullName"] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </optgroup>
                    <?php endforeach; ?>
                </select>

                <div class="d-flex align-items-center mb-2">
                    <label for="deadline-TaskPerformers" class="text-nowrap">Thời gian: </label>
                    <input type="number" class="deadline-input form-control rounded-0 p-0 ps-2 mx-2 bg-transparent" min="1" value="<?= $deadlinePerformer ?>" id="deadline-TaskPerformers" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && stripos($status, "Hoàn thành") === false && $view == 'task' ? "" : "disabled" ?>>
                    <span>ngày</span>
                </div>
            </div>

            <div class="attachments mb-2">
                <div class="attachments-title ms-1 mb-1 d-flex align-items-center justify-content-between">
                    <span class="fw-semibold">
                        <i class="bi bi-paperclip me-2 text-secondary"></i>Đính kèm
                    </span>
                    <label for="add-file" class="btn btn-primary rounded-circle py-0 px-1"><i class="bi bi-plus-lg"></i></label>
                    <input type="file" class="d-none" id="add-file" name="files[]" multiple>
                </div>

                <ul id="attachments-list" class="list-group list-group-flush">
                    <?php foreach ($documentList as $document) : ?>
                        <li class="list-group-item list-group-item-action border-0 d-flex align-items-center justify-content-between mb-2 rounded-3">
                            <span class="file-name fw-medium">
                                <span data-value="<?= sha1($document["DocumentID"]) ?>" class="link-file text-primary text-decoration-underline me-2 text-break"> <?= $document["FileName"] ?> </span>
                                <span class="text-secondary fw-normal">(<?= $document["FileSize"] ?>)</span>
                            </span>
                            <button class="remove-file-btn btn btn-white border-0"><i class="bi bi-x-lg"></i></button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="comment-box">
                <div class="comment-title ms-1 mb-1">
                    <label for="comment-input" class="fw-semibold mb-1">
                        <i class="bi bi-chat-dots-fill text-secondary me-2"></i>Bình luận
                    </label>
                    <div class="input-comment w-100 mb-2">
                        <textarea class="textarea-task form-control rounded-0 mb-2 bg-transparent rounded-3" id="comment-input" rows="1" placeholder="Nhập bình luận..."></textarea>
                        <button class="btn btn-primary py-1 mt-1 d-none" type="button" id="save-comment">Lưu</i></button>
                    </div>
                    <ul class="list-group list-group-flush mb-2" id="comment-list">
                        <?php foreach ($commentList as $value) : ?>
                            <li class="list-group-item d-flex">
                                <img src="data:image/jpeg;base64,<?= base64_encode($value["Avatar"]) ?>" alt="" class="rounded-circle me-2" style="max-width: 36px; min-width: 36px;" height="36px">
                                <div class="comment-content">
                                    <?php if ($value["UserID"] == $_SESSION["UserInfo"][0]["UserID"]) : ?>
                                        <div class="dropdown position-static">
                                            <button class="btn border-0 dropdown-toggle position-absolute top-0 p-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bi bi-three-dots text-secondary"></i>
                                            </button>
                                            <ul class="dropdown-menu p-2">
                                                <li class="dropdown-item rounded-3 p-0">
                                                    <button type="button" class="delete-comment-btn btn border-0 text-start w-100 text-danger" data-value="<?= sha1($value["CommentID"]) ?>"><i class="bi bi-trash3 me-2"></i>Xóa</button>
                                                </li>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <div class="comment-info mb-1">
                                        <span class="comment-info-name fw-semibold me-2"><?= $value["FullName"] ?></span>
                                        <span class="comment-info-date text-secondary">
                                            <?php
                                            date_default_timezone_set('Asia/Ho_Chi_Minh');
                                            $currentDate = new DateTime();
                                            $targetDate = new DateTime($value["DateCreated"]);
                                            $interval = $currentDate->diff($targetDate);
                                            if ($interval->y != 0) {
                                                echo $interval->y . ' năm trước';
                                            } else if ($interval->m != 0) {
                                                echo $interval->m . ' tháng trước';
                                            } else if ($interval->d != 0) {
                                                echo $interval->d . ' ngày trước';
                                            } else if ($interval->h != 0) {
                                                echo $interval->h . ' giờ trước';
                                            } else if ($interval->i != 0) {
                                                echo $interval->i . ' phút trước';
                                            } else {
                                                echo '';
                                            }
                                            ?>
                                        </span>
                                    </div>
                                    <?= $value["Content"] ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php if (stripos($status, "Hoàn thành") === false && $dateStart !== null || $assignedBy == $_SESSION["UserInfo"][0]["UserID"]) : ?>
            <div class="modal-footer justify-content-between">
                <?php if ($status != "Dự thảo") : ?>
                    <div class="d-flex align-items-center" id="range-content">
                        <span>Tiến độ: </span>
                        <input type="range" class="mx-2" min="0" max="100" id="progress-range" value="<?= $progress ?>" <?= $assignedBy == $_SESSION["UserInfo"][0]["UserID"] || stripos($status, "Hoàn thành") !== false || $status == "Chờ duyệt" ? "disabled" : "" ?>>
                        <span id="progress-text"><?= $progress ?>%</span>
                    </div>
                <?php endif; ?>

                <div class="ms-auto footer-action">
                    <?php if (($reviewerID == $_SESSION["UserInfo"][0]["UserID"] || $assignedBy == $_SESSION["UserInfo"][0]["UserID"] && $view == "signature") && stripos($status, "Hoàn thành") === false && $status !== "Chờ duyệt") : ?>
                        <button id="refuse-child-task-btn" type="button" class="btn border-0 text-danger"><i class="bi bi-clipboard2-x me-2"></i>Từ chối</button>
                    <?php endif; ?>
                    <?php if ($assignedBy != $_SESSION["UserInfo"][0]["UserID"] && $status == "Chờ duyệt") : ?>
                        <button id="recall-child-task-btn" type="button" class="btn border-0 text-primary"><i class="bi bi-arrow-counterclockwise me-2"></i>Thu hồi</button>
                    <?php endif; ?>

                    <?php if ($assignedBy != $_SESSION["UserInfo"][0]["UserID"] && stripos($status, "Hoàn thành") === false && $status != "Chờ duyệt") : ?>
                        <button id="send-signature-child-btn" type="button" class="btn btn-success <?= $progress == 100 ? "" : "d-none" ?>"><i class="bi bi-send me-2"></i>Gửi duyệt</button>
                    <?php endif; ?>
                    <?php if ($status != "Dự thảo" && $view == 'task') : ?>
                        <button id="save-child-task-btn" type="button" class="btn btn-primary"><i class="bi bi-floppy2 me-2"></i>Lưu</button>
                    <?php endif; ?>
                    <?php if (!checkRole($_SESSION["Role"], 3) && $status == "Dự thảo") : ?>
                        <button id="send-child-task-btn" type="button" class="btn btn-primary"><i class="bi bi-send me-2"></i>Gửi</button>
                    <?php endif; ?>
                    <?php if ($_SESSION["UserInfo"][0]["PositionID"] != 5 && $view == "signature") : ?>
                        <button id="signature-child-btn" type="button" class="btn btn-success"><i class="bi bi-clipboard2-check me-2"></i>Duyệt</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>