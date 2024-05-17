<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="toast-notify" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">

            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

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
            <button id="btn-add-task" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-task-modal">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-data" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">STT</th>
                        <th class="text-start" scope="col">Tên công việc</th>
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
                            <td data-cell="Hạn hoàn thành" class="text-center"><?= $value["Deadline"] ?>
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
                    <textarea class="textarea-task task-name form-control rounded-0 mb-2" id="add-task-name" placeholder="Nhập tên công việc" rows="1"></textarea>
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
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 me-3" id="staticBackdropLabel">Công việc</h1>
                    <span class="badge bg-opacity-25 fw-semibold" data-value="Dự thảo">Dự thảo</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="task-name" class="mb-1">Tên công việc <span class="text-danger">*</span></label>
                    <textarea class="textarea-task form-control rounded-0 mb-2" id="view-task-name" rows="1"></textarea>
                    <div class="d-md-flex align-items-center justify-content-between mb-2">
                        <div id="priority-dropdown" class="dropdown d-flex align-items-center">
                            <label for="view-task-priority">Độ ưu tiên:</label>
                            <select name="" id="view-task-priority" class="ms-2 border-0">
                                <option value="1" data-title="Thấp" data-icon="bi bi-square-fill text-secondary text-opacity-50">Thấp</option>
                                <option value="2" data-title="Vừa" data-icon="bi bi-square-fill text-primary text-opacity-75">Vừa</option>
                                <option value="3" data-title="Cao" data-icon="bi bi-square-fill text-danger text-opacity-75">Cao</option>
                            </select>
                        </div>

                        <div class="d-flex align-items-center">
                            <label for="deadline-task">Thời gian: </label>
                            <input type="number" class="deadline-input form-control rounded-0 p-0 ps-2 mx-2" min="2" value="2" id="deadline-task">
                            <span>ngày</span>
                        </div>
                    </div>
                    <div class="AssignedBy mb-2 d-flex align-items-center">
                        <span class="me-2">Người giao việc: </span>
                        <div class="AssignedBy-info d-flex align-items-center">
                            <img class="rounded-circle me-2" src="data:image/jpeg;base64,<?= base64_encode($_SESSION["UserInfo"][0]["Avatar"]) ?>" alt="" width="36px" height="36px">
                            <div class="AssignedBy-name">
                                <p class="m-0 text-primary"><?= $_SESSION["UserInfo"][0]["FullName"] ?></p>
                                <p class="m-0 text-secondary"><?= $_SESSION["UserInfo"][0]["PositionName"] ?> - <?= $_SESSION["UserInfo"][0]["DepartmentName"] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="Description mb-2">
                        <button id="Description-btn" class="border-0 bg-transparent text-primary"><i class="bi bi-text-left me-2"></i>Mô tả</button>
                        <div class="d-none">
                            <textarea class="textarea-task form-control mt-2" id="Description-view-task" rows="1"></textarea>
                        </div>
                    </div>

                    <label class="fw-semibold ms-1 mb-1"><i class="bi bi-person-fill me-2 text-secondary"></i>Người thực hiện <span class="text-danger">*</span></label>
                    <div class="d-md-flex align-items-center justify-content-between mb-2">
                        <select name="" id="TaskPerformers" class="border-0">
                            <option value="null" data-title="Chọn người thực hiện" data-icon="bi-person-fill" disabled selected hidden>Chọn người thực hiện</option>
                            <?php foreach ($data["departmentList"] as $department) : ?>
                                <optgroup label="<?= $department["DepartmentName"] ?>">
                                    <?php foreach ($data["userList"] as $user) : ?>
                                        <?php if ($user["DepartmentID"] == $department["DepartmentID"]) : ?>
                                            <option value="<?= $user["UserID"] ?>" data-title="<?= $user["FullName"] ?>" data-role="<?= $user["PositionName"] ?>" data-company="<?= $user["DepartmentName"]  ?>" data-avatar="data:image/jpeg;base64,<?= base64_encode($user["Avatar"]) ?>"><?= $user["FullName"] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>

                        <div class="d-flex align-items-center">
                            <label for="deadline-TaskPerformers">Thời gian: </label>
                            <input type="number" class="deadline-input form-control rounded-0 p-0 ps-2 mx-2" min="1" value="1" id="deadline-TaskPerformers">
                            <span>ngày</span>
                        </div>
                    </div>

                    <label class="fw-semibold ms-1 mb-1"><i class="bi bi-person-fill-check me-2 text-secondary"></i>Người thẩm định <span class="text-danger">*</span></label>
                    <div class="d-md-flex align-items-center justify-content-between mb-2">
                        <select name="" id="TaskReview" class="border-0">
                            <option value="null" data-title="Chọn người thẩm định" data-icon="bi-person-fill-check" disabled selected hidden>Chọn người thẩm định</option>
                            <?php foreach ($data["departmentList"] as $department) : ?>
                                <optgroup label="<?= $department["DepartmentName"] ?>">
                                    <?php foreach ($data["userList"] as $user) : ?>
                                        <?php if ($user["DepartmentID"] == $department["DepartmentID"]) : ?>
                                            <?php foreach ($data['role'] as $role) : ?>
                                                <?php if ($role['RoleID'] == 5 && $role["UserID"] ==  $user["UserID"]) : ?>
                                                    <option value="<?= $user["UserID"] ?>" data-title="<?= $user["FullName"] ?>" data-role="<?= $user["PositionName"] ?>" data-company="<?= $user["DepartmentName"]  ?>" data-avatar="data:image/jpeg;base64,<?= base64_encode($user["Avatar"]) ?>"><?= $user["FullName"] ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            <?php endforeach; ?>
                        </select>

                        <div class="d-flex align-items-center">
                            <label for="deadline-TaskReview">Thời gian: </label>
                            <input type="number" class="deadline-input form-control rounded-0 p-0 ps-2 mx-2" min="1" value="1" id="deadline-TaskReview">
                            <span>ngày</span>
                        </div>
                    </div>

                    <label class="fw-semibold ms-1 mb-1"><i class="bi bi-paperclip me-2 text-secondary"></i>Tệp đính kèm</label>
                    <input type="file" name="files[]" multiple class="form-control mb-2" id="uploadFile">
                </div>
                <div class="modal-footer">
                    <button id="save-task-btn" type="button" class="btn btn-primary"><i class="bi bi-send me-2"></i>Gửi</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: View Task modal -->
    <script>
        $(document).ready(function() {
            $('#view-task-modal').modal('show');
            //============================Search============================
            $('#search').keypress(function(event) {
                if (event.which === 13) {
                    $('#btn-search').click();
                }
            });

            $('#btn-search').click(function() {
                var search = $('#search').val();
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        search: search
                    },

                    success: function(response) {
                        var data = $(response).find("#table-data").html();
                        $("#table-data").html(data);
                        customStatus();
                    }
                })
            });

            //============================Table============================

            $('#table-data > tbody > tr').click(function() {
                var id = $(this).attr('data-id');
                $.ajax({
                    url: "<?= getWebRoot(); ?>/Task/AddTask",
                    type: "POST",
                    data: {
                        taskName: taskName,
                    },

                    success: function(response) {
                        if (response === "fail") {
                            var status = "text-bg-danger";
                            var icon = '<i class="bi bi-x-circle me-2"></i></i>';
                            var message = icon + "Lỗi hệ thống vui lòng thử lại sau.";

                            toastNotify.addClass(status);
                            toastNotify.find(".toast-body").html(message);
                            bootstrap.Toast.getOrCreateInstance(toastNotify).show();
                        } else {

                        }
                    },

                    error: function() {
                        var status = "text-bg-danger";
                        var icon = '<i class="bi bi-x-circle me-2"></i></i>';
                        var message = icon + "Lỗi hệ thống vui lòng thử lại sau.";

                        toastNotify.addClass(status);
                        toastNotify.find(".toast-body").html(message);
                        bootstrap.Toast.getOrCreateInstance(toastNotify).show();
                    }
                });
            });

            function customStatus() {
                const $cell1Elements = $('[data-cell="Tình trạng"]');
                $cell1Elements.each(function() {
                    const dataValue = $(this).attr('data-value');
                    if (dataValue == "Hoàn thành trước hạn") {
                        $(this).children().addClass("bg-primary text-primary");
                    } else if (dataValue == "Hoàn thành") {
                        $(this).children().addClass("bg-success text-success");
                    } else if (dataValue == "Hoàn thành trễ hạn") {
                        $(this).children().addClass("bg-warning text-warning");
                    } else if (dataValue == "Chờ duyệt") {
                        $(this).children().addClass("bg-info text-info");
                    } else if (dataValue == "Trễ hạn") {
                        $(this).children().addClass("bg-danger text-danger");
                    } else {
                        $(this).children().addClass("bg-secondary text-secondary");
                    }
                });
            }

            var statusTask = $('#view-task-modal .badge').attr('data-value');
            if (statusTask == "Hoàn thành trước hạn") {
                $('#view-task-modal .badge').addClass("bg-primary text-primary");
            } else if (statusTask == "Hoàn thành") {
                $('#view-task-modal .badge').addClass("bg-success text-success");
            } else if (statusTask == "Hoàn thành trễ hạn") {
                $('#view-task-modal .badge').addClass("bg-warning text-warning");
            } else if (statusTask == "Chờ duyệt") {
                $('#view-task-modal .badge').addClass("bg-info text-info");
            } else if (statusTask == "Trễ hạn") {
                $('#view-task-modal .badge').addClass("bg-danger text-danger");
            } else {
                $('#view-task-modal .badge').addClass("bg-secondary text-secondary");
            }

            customStatus();

            //============================Add Task============================
            $('#add-task-modal').on('hidden.bs.modal', function() {
                $('#add-task-name').val("");
            });

            $('#add-task-submit').click(function() {
                var taskName = $('#add-task-name').val();
                var toastNotify = $("#toast-notify")
                if (taskName.trim() === "") {
                    var status = "text-bg-warning";
                    var icon = '<i class="bi bi-exclamation-triangle me-2"></i>';
                    var message = icon + "Vui lòng nhập tên công việc.";
                    toastNotify.addClass(status);
                    toastNotify.find(".toast-body").html(message);

                    bootstrap.Toast.getOrCreateInstance(toastNotify).show();
                } else {
                    bootstrap.Toast.getOrCreateInstance(toastNotify).hide();

                    $.ajax({
                        url: "<?= getWebRoot(); ?>/Task/AddTask",
                        type: "POST",
                        data: {
                            taskName: taskName,
                        },

                        success: function(response) {
                            if (response === "success") {
                                var status = "text-bg-success";
                                var icon = '<i class="bi bi-check-circle me-2"></i>';
                                var message = icon + "Thêm thành công.";
                                setTimeout(function() {
                                    location.reload();
                                }, 1000);
                            } else if (response === "fail") {
                                var status = "text-bg-danger";
                                var icon = '<i class="bi bi-x-circle me-2"></i></i>';
                                var message = icon + "Thêm thất bại.";
                            } else {
                                var status = "text-bg-danger";
                                var icon = '<i class="bi bi-x-circle me-2"></i>';
                                var message = icon + "Lỗi hệ thống vui lòng thử lại sau.";
                            }

                            toastNotify.addClass(status);
                            toastNotify.find(".toast-body").html(message);
                            bootstrap.Toast.getOrCreateInstance(toastNotify).show();
                        },

                        error: function() {
                        var status = "text-bg-danger";
                        var icon = '<i class="bi bi-x-circle me-2"></i></i>';
                        var message = icon + "Lỗi hệ thống vui lòng thử lại sau.";

                        toastNotify.addClass(status);
                        toastNotify.find(".toast-body").html(message);
                        bootstrap.Toast.getOrCreateInstance(toastNotify).show();
                    }
                    });
                }
            });

            //============================View Task============================
            $('#TaskPerformers optgroup').each(function() {
                if ($(this).children('option').length === 0) {
                    $(this).remove();
                }
            });

            $('#TaskReview optgroup').each(function() {
                if ($(this).children('option').length === 0) {
                    $(this).remove();
                }
            });

            $('#Description-btn').click(function() {
                $('.Description > div').toggleClass('d-none');
            });

            let descriptionEditor;

            ClassicEditor
                .create(document.querySelector('#Description-view-task'))
                .then(editor => {
                    descriptionEditor = editor;
                })
                .catch(error => {
                    console.error(error);
                });

            function resizeTextArea(el) {
                var autoResize = function() {
                    el.css('height', 'auto');
                    el.css('height', el[0].scrollHeight + 'px');
                };

                el.on('input', autoResize);
                autoResize();
            }

            var textarea = $('.task-name');
            resizeTextArea(textarea);

            function formatStatePriority(state) {
                if (!state.id) {
                    return state.text;
                }

                var $state = $(
                    '<span><i class="' + $(state.element).data('icon') + ' me-2"></i>' + $(state.element).data('title') + '</span>'
                );

                return $state;
            }

            $('#view-task-priority').select2({
                dropdownParent: $('#view-task-modal'),
                minimumResultsForSearch: Infinity,
                templateResult: formatStatePriority,
                templateSelection: formatStatePriority,
            });

            function matchCustom(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                var searchTerm = params.term.toUpperCase();
                if (data.children) {
                    var match = false;
                    var filteredChildren = [];
                    $.each(data.children, function(i, child) {
                        if (child.text.toUpperCase().indexOf(searchTerm) > -1) {
                            filteredChildren.push(child);
                            match = true;
                        }
                    });
                    if (match) {
                        var filteredGroup = $.extend({}, data, true);
                        filteredGroup.children = filteredChildren;
                        return filteredGroup;
                    }
                }
                if (data.text.toUpperCase().indexOf(searchTerm) > -1) {
                    return data;
                }
                return null;
            }


            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }

                if (state.element.value == 'null') {
                    var $state = $(
                        '<span class="d-flex align-items-center"><i class="select-icon bi ' + $(state.element).data('icon') + ' text-secondary border border-2 rounded-circle d-flex align-items-center justify-content-center me-2"></i> ' +
                        $(state.element).data('title') + '</span>'
                    );
                    return $state;
                }

                var $state = $(
                    '<div class="d-flex align-items-center"><img src="' + $(state.element).data('avatar') + '" class="rounded-circle me-2" style="width: 36px; height: 36px;" /> ' +
                    '<div><p class="m-0 fw-semibold lh-1 mb-2" style="font-size: 14px">' + $(state.element).data('title') + '</p>' +
                    '<p class="m-0 text-secondary lh-1" style="font-size: 12px">' + $(state.element).data('role') + ' - ' + $(state.element).data('company') + '</p></div></div>'
                );

                return $state;
            }

            $('#TaskPerformers').select2({
                templateResult: formatState,
                templateSelection: formatState,
                dropdownParent: $('#view-task-modal'),
                placeholder: "Chọn người thực hiện",
                matcher: matchCustom,
            });

            $('#TaskReview').select2({
                templateResult: formatState,
                templateSelection: formatState,
                dropdownParent: $('#view-task-modal'),
                placeholder: "Chọn người thực hiện",
                matcher: matchCustom,
            });

            var deadlineTask = Number($('#deadline-task').val());
            var deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
            var deadlineTaskReview = Number($('#deadline-TaskReview').val());

            $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
            $('#deadline-TaskReview').attr("max", (deadlineTask - deadlineTaskPerformers));

            $("#deadline-task").change(function() {
                deadlineTask = Number($(this).val());
                deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
                deadlineTaskReview = Number($('#deadline-TaskReview').val());
                $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
            });


            $("#deadline-TaskPerformers").change(function() {
                deadlineTaskPerformers = Number($(this).val());
                deadlineTask = Number($("#deadline-task").val());
                deadlineTaskReview = Number($('#deadline-TaskReview').val());
                $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));

                if (deadlineTaskPerformers > Number($(this).attr("max"))) {
                    $(this).val(Number($(this).attr("max")));
                }
            })

            $("#deadline-TaskReview").change(function() {
                deadlineTask = Number($("#deadline-task").val());
                deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
                deadlineTaskReview = Number($(this).val());
                $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
                if (deadlineTaskReview > Number($(this).attr("max"))) {
                    $(this).val(Number($(this).attr("max")));
                }
            })
        })
    </script>
</div>