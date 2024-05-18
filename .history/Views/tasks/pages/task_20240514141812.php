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
            <button id="btn-add-task" class="btn btn-primary my-2 me-2" type="button" data-bs-toggle="modal" data-bs-target="#add-Task">
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
                            <td data-cell="Tên công việc" class="text-start text-break"><?= $value["TaskName"] ?></td>
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

    <div class="modal fade" id="add-Task" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 me-2" id="staticBackdropLabel">Thêm công việc</h1>
                    <span id="task-status" data-value="Dự thảo" class="badge bg-opacity-25 fw-semibold">Dự thảo</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="task-name" class="mb-2">Tên công việc <span class="text-danger">*</span></label>
                    <textarea class="textarea-task form-control rounded-0 mb-2" id="task-name" placeholder="Nhập tên công việc" rows="1"></textarea>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div id="priority-dropdown" class="dropdown d-flex align-items-center">
                            <label for="priority-dropdown-toggle">Độ ưu tiên:</label>
                            <button id="priority-dropdown-toggle" data-value="1" class="btn bg-transparent ou dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-square-fill text-secondary opacity-50 me-2"></i> Thấp
                            </button>
                            <ul class="dropdown-menu">
                                <li><button data-value="1" class="dropdown-item" type="button">
                                        <i class="bi bi-square-fill text-secondary opacity-50 me-2"></i> Thấp
                                    </button>
                                </li>
                                <li>
                                    <button data-value="2" class="dropdown-item" type="button">
                                        <i class="bi bi-square-fill text-primary opacity-75 me-2"></i> Vừa
                                    </button>
                                </li>
                                <li>
                                    <button data-value="3" class="dropdown-item" type="button">
                                        <i class="bi bi-square-fill text-danger opacity-75 me-2"></i> Cao
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="d-flex align-items-center">
                            <label for="deadline-task">Thời gian (ngày): </label>
                            <input type="number" class="form-control border-0 p-0 ps-2 ms-2" min="1" value="1" id="deadline-task">
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
                            <textarea class="textarea-task form-control mt-2" id="Description-content" rows="1"></textarea>
                        </div>
                    </div>

                    <div id="TaskPerformers-dropdown" class="dropdown">
                        <label class="fw-semibold ms-1 me-2"><i class="bi bi-person-fill me-2 text-secondary"></i>Phòng ban/Người thực hiện</label><br>
                        <button id="TaskPerformers-dropdown-toggle" data-value="null" class="btn bg-transparent ou dropdown-toggle border-0 d-flex align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-fill me-2 text-secondary border border-2 rounded-circle d-flex align-items-center justify-content-center"></i> 
                            Chọn người thực hiện
                        </button>
                        <ul class="dropdown-menu">
                            <li><button data-value="1" class="dropdown-item" type="button">
                                    <i class="bi bi-square-fill text-secondary opacity-50 me-2"></i> Thấp
                                </button>
                            </li>
                            <li>
                                <button data-value="2" class="dropdown-item" type="button">
                                    <i class="bi bi-square-fill text-primary opacity-75 me-2"></i> Vừa
                                </button>
                            </li>
                            <li>
                                <button data-value="3" class="dropdown-item" type="button">
                                    <i class="bi bi-square-fill text-danger opacity-75 me-2"></i> Cao
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"><i class="bi bi-x-circle me-2"></i>Hủy</button>
                    <button type="button" class="btn btn-primary"><i class="bi bi-send me-2"></i>Gửi</button>
                    <!-- <button type="button" class="btn btn-primary"><i class="bi bi-save me-2"></i>Lưu</button> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
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

            $('#table-data > tbody > tr').click(function() {
                var id = $(this).attr('data-id');
                console.log(id);
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

            var statusTask = $('#task-status').attr('data-value');
            if (statusTask == "Hoàn thành trước hạn") {
                $('#task-status').addClass("bg-primary text-primary");
            } else if (statusTask == "Hoàn thành") {
                $('#task-status').addClass("bg-success text-success");
            } else if (statusTask == "Hoàn thành trễ hạn") {
                $('#task-status').addClass("bg-warning text-warning");
            } else if (statusTask == "Chờ duyệt") {
                $('#task-status').addClass("bg-info text-info");
            } else if (statusTask == "Trễ hạn") {
                $('#task-status').addClass("bg-danger text-danger");
            } else {
                $('#task-status').addClass("bg-secondary text-secondary");
            }

            customStatus();

            $('#priority-dropdown .dropdown-item').click(function() {
                var text = $(this).html();
                var value = $(this).attr("data-value");
                $('#priority-dropdown-toggle').html(text);
                $('#priority-dropdown-toggle').attr("data-value", value);
                console.log($('#priority-dropdown-toggle').attr("data-value"));
            });

            $('#Description-btn').click(function() {
                $('.Description > div').toggleClass('d-none');
            });

            ClassicEditor
                .create(document.querySelector('#Description-content'))
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

            var textarea = $('#task-name');
            resizeTextArea(textarea);
        })
    </script>
</div>