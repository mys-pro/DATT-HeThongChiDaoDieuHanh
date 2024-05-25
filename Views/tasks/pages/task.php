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
            <table id="table-data" class="table table-hover border shadow-sm mb-2">
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="feedback-task-label">Phê duyệt</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <textarea class="form-control" id="feedback-area" style="height: 100px"></textarea>
                        <label for="feedback-area" id="feedback-area-label">Nhận xét</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay lại</button>
                    <button id="submit-refuse-task" type="button" class="btn btn-primary">Xác nhận</button>
                    <button id="submit-comment-task" type="button" class="btn btn-primary">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Feedback Task Model -->
    <script>
        // $(document).ready(function() {
        //     var taskID = 0;

        //     function showToast(toast, type, message) {
        //         toast.removeClass("text-bg-success");
        //         toast.removeClass("text-bg-warning");
        //         toast.removeClass("text-bg-danger");

        //         var icon = '';
        //         switch (type) {
        //             case 'success': {
        //                 icon = '<i class="bi bi-check-lg me-2 fs-5"></i>';
        //                 break;
        //             }

        //             case 'warning': {
        //                 icon = '<i class="bi bi-exclamation-triangle me-2 fs-5"></i>';
        //                 break;
        //             }

        //             case 'danger': {
        //                 icon = '<i class="bi bi-x-circle me-2 fs-5"></i>';
        //                 break;
        //             }
        //         }

        //         var status = "text-bg-" + type;
        //         message = icon + message;

        //         toast.addClass(status);
        //         toast.find(".toast-body").html(message);
        //         bootstrap.Toast.getOrCreateInstance(toast).show();
        //     }

        //     //============================Search============================
        //     $('#search').keypress(function(event) {
        //         if (event.which === 13) {
        //             $('#btn-search').click();
        //         }
        //     });

        //     $('#btn-search').click(function() {
        //         var search = $('#search').val();
        //         $.ajax({
        //             url: window.location.href,
        //             type: 'POST',
        //             data: {
        //                 search: search
        //             },

        //             success: function(response) {
        //                 var data = $(response).find("#table-data").html();
        //                 $("#table-data").html(data);
        //                 customStatus();
        //             }
        //         })
        //     });

        //     //============================Table============================

        //     $('#table-data > tbody > tr').click(function() {
        //         var id = $(this).attr('data-id');
        //         var assignedBy = $(this).attr('assigned-by');
        //         var viewModal = $("#view-task-modal");
        //         var assignedByUserId = <?php echo json_encode($_SESSION["UserInfo"][0]["UserID"]); ?>;

        //         if (assignedBy != assignedByUserId) {
        //             viewModal.find("#delete-task-btn").prop('disabled', true);
        //             viewModal.find('#view-task-name').prop('disabled', true);
        //             viewModal.find('#view-task-priority').prop("disabled", true);
        //             viewModal.find("#deadline-task").prop('disabled', true);
        //             descriptionEditor.enableReadOnlyMode('Description-view-task');
        //             viewModal.find("#deadline-TaskPerformers").prop("disabled", true);
        //             viewModal.find("#deadline-TaskReview").prop("disabled", true);
        //         } else {
        //             viewModal.find("#delete-task-btn").prop('disabled', false);
        //             viewModal.find('#view-task-name').prop('disabled', false);
        //             viewModal.find('#view-task-priority').prop("disabled", false);
        //             viewModal.find("#deadline-task").prop('disabled', false);
        //             descriptionEditor.disableReadOnlyMode('Description-view-task');
        //             viewModal.find("#deadline-TaskPerformers").prop("disabled", false);
        //             viewModal.find("#deadline-TaskReview").prop("disabled", false);
        //         }

        //         $.ajax({
        //             url: "<?= getWebRoot(); ?>/Task/viewTask",
        //             type: "POST",
        //             data: {
        //                 idTask: id,
        //             },

        //             success: function(response) {
        //                 var data = JSON.parse(response);
        //                 updateModalView(data, assignedBy);
        //                 customStatusView();
        //                 $('#view-task-modal').modal('show');
        //             },

        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
        //             }
        //         });
        //     });

        //     function customStatus() {
        //         const $cell1Elements = $('[data-cell="Tình trạng"]');
        //         $cell1Elements.each(function() {
        //             const dataValue = $(this).attr('data-value');
        //             if (dataValue == "Hoàn thành trước hạn") {
        //                 $(this).children().addClass("bg-primary text-primary");
        //             } else if (dataValue == "Hoàn thành") {
        //                 $(this).children().addClass("bg-success text-success");
        //             } else if (dataValue == "Hoàn thành trễ hạn") {
        //                 $(this).children().addClass("bg-warning text-warning");
        //             } else if (dataValue == "Chờ duyệt") {
        //                 $(this).children().addClass("bg-info text-info");
        //             } else if (dataValue == "Quá hạn" || dataValue == "Từ chối phê duyệt") {
        //                 $(this).children().addClass("bg-danger text-danger");
        //             } else {
        //                 $(this).children().addClass("bg-secondary text-secondary");
        //             }
        //         });
        //     }

        //     function customStatusView() {
        //         $('#view-task-modal').find(".badge").removeClass("bg-primary text-primary");
        //         $('#view-task-modal').find(".badge").removeClass("bg-success text-success");
        //         $('#view-task-modal').find(".badge").removeClass("bg-warning text-warning");
        //         $('#view-task-modal').find(".badge").removeClass("bg-info text-info");
        //         $('#view-task-modal').find(".badge").removeClass("bg-danger text-danger");
        //         $('#view-task-modal').find(".badge").removeClass("bg-secondary text-secondary");

        //         var statusTask = $('#view-task-modal').find(".badge").attr('data-value');
        //         var viewModal = $("#view-task-modal");
        //         if (statusTask == "Hoàn thành trước hạn") {
        //             $('#view-task-modal').find(".badge").addClass("bg-primary text-primary");
        //             // viewModal.find("#save-task-btn").prop("disabled", true);
        //         } else if (statusTask == "Hoàn thành") {
        //             $('#view-task-modal').find(".badge").addClass("bg-success text-success");
        //             // viewModal.find("#save-task-btn").prop("disabled", true);
        //         } else if (statusTask == "Hoàn thành trễ hạn") {
        //             $('#view-task-modal').find(".badge").addClass("bg-warning text-warning");
        //             // viewModal.find("#save-task-btn").prop("disabled", true);
        //         } else if (statusTask == "Chờ duyệt") {
        //             $('#view-task-modal').find(".badge").addClass("bg-info text-info");
        //         } else if (statusTask == "Quá hạn" || statusTask == "Từ chối phê duyệt") {
        //             $('#view-task-modal').find(".badge").addClass("bg-danger text-danger");
        //         } else {
        //             $('#view-task-modal').find(".badge").addClass("bg-secondary text-secondary");
        //         }
        //     }

        //     customStatus();

        //     //============================Add Task============================
        //     $('#add-task-modal').on('hidden.bs.modal', function() {
        //         $('#add-task-name').val("");
        //     });

        //     $('#add-task-submit').click(function() {
        //         var taskName = $('#add-task-name').val();
        //         var toastNotify = $("#toast-notify");
        //         if (taskName.trim() === "") {
        //             showToast(toastNotify, 'warning', "Vui lòng nhập tên công việc.");
        //         } else {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: "<?= getWebRoot(); ?>/Task/addTask",
        //                 type: "POST",
        //                 data: {
        //                     taskName: taskName,
        //                 },

        //                 success: function(response) {
        //                     if (response === "success") {
        //                         showToast(toastNotify, 'success', "Thêm thành công.");
        //                         setTimeout(function() {
        //                             $('#add-task-name').val("");
        //                             window.location.href = "<?= getWebRoot() ?>/ac/cong-viec?v=du-thao";
        //                         }, 1000);
        //                     } else if (response === "fail") {
        //                         showToast(toastNotify, 'danger', "Thêm thất bại.");
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast(toastNotify, 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast(toastNotify, 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
        //                     $('#modal-loading').addClass("d-none");
        //                 }
        //             });
        //         }
        //     });

        //     //============================View Task============================
        //     $('#add-file').change(function() {
        //         var formData = new FormData();
        //         var files = $(this)[0].files;

        //         for (var i = 0; i < files.length; i++) {
        //             formData.append('files[]', files[i]);
        //         }

        //         formData.append('taskID', taskID);

        //         $.ajax({
        //             url: '<?= getWebRoot() ?>/Task/uploadFile',
        //             type: 'POST',
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             dataType: 'json',
        //             success: function(response) {
        //                 if (response.type == "success") {
        //                     showToast($("#toast-notify"), 'success', 'Tải lên thành công.');
        //                     $("#attachments-list").html(response.documentList);
        //                 } else if (response.type == 'fail') {
        //                     showToast($("#toast-notify"), 'danger', 'Tải lên thất bại.');
        //                 } else {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 }
        //             },
        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //             }
        //         });
        //         $(this).val("");
        //     });

        //     $('#attachments-list').on('click', '.remove-file-btn', function() {
        //         var documentID = $("#attachments-list").find(".link-file").attr('data-value');
        //         $.ajax({
        //             url: '<?= getWebRoot() ?>/Task/removeFile',
        //             type: 'POST',
        //             data: {
        //                 documentID: documentID,
        //                 taskID: taskID
        //             },
        //             dataType: 'json',
        //             success: function(response) {
        //                 if (response.type == "success") {
        //                     showToast($("#toast-notify"), 'success', 'Đã xóa tập tin.');
        //                     $("#attachments-list").html(response.documentHtml);
        //                 } else if (response.type == 'fail') {
        //                     showToast($("#toast-notify"), 'danger', 'Xóa tập tin thất bại.');
        //                 } else if (response.type == 'notFound') {
        //                     showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
        //                 } else {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 }
        //             },

        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //             }
        //         });
        //     });

        //     $('#attachments-list').on('click', '.link-file', function(e) {
        //         var documentID = $(this).attr('data-value');
        //         $.ajax({
        //             url: '<?= getWebRoot() ?>/Task/downloadFile',
        //             type: 'POST',
        //             data: {
        //                 documentID: documentID
        //             },
        //             success: function(response) {
        //                 if (response == "notFound") {
        //                     showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
        //                 } else {
        //                     var link = response.split(", ");
        //                     var a = document.createElement('a');
        //                     a.href = link[1];
        //                     a.download = link[0];
        //                     document.body.appendChild(a);
        //                     a.click();
        //                     $(a).remove();
        //                 }
        //             },

        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
        //             }
        //         });
        //     });

        //     $('#TaskPerformers optgroup').each(function() {
        //         if ($(this).children('option').length === 0) {
        //             $(this).remove();
        //         }
        //     });

        //     $('#TaskReview optgroup').each(function() {
        //         if ($(this).children('option').length === 0) {
        //             $(this).remove();
        //         }
        //     });

        //     $('#Description-btn').click(function() {
        //         $('.Description > div').toggleClass('d-none');
        //     });

        //     $('#view-task-modal').on('hidden.bs.modal', function() {
        //         taskID = 0;
        //         if ($('.Description > div').length != 0)
        //             $('.Description > div').addClass('d-none');
        //     });

        //     var descriptionEditor;

        //     ClassicEditor
        //         .create(document.querySelector('#Description-view-task'))
        //         .then(editor => {
        //             descriptionEditor = editor;
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });

        //     function resizeTextArea(el) {
        //         var autoResize = function() {
        //             el.css('height', 'auto');
        //             el.css('height', el[0].scrollHeight + 'px');
        //         };

        //         el.on('input', autoResize);
        //         autoResize();
        //     }

        //     var textarea = $('.task-name');
        //     resizeTextArea(textarea);

        //     function formatStatePriority(state) {
        //         if (!state.id) {
        //             return state.text;
        //         }

        //         var $state = $(
        //             '<span><i class="' + $(state.element).data('icon') + ' me-2"></i>' + $(state.element).data('title') + '</span>'
        //         );

        //         return $state;
        //     }

        //     $('#view-task-priority').select2({
        //         dropdownParent: $('#view-task-modal'),
        //         minimumResultsForSearch: Infinity,
        //         templateResult: formatStatePriority,
        //         templateSelection: formatStatePriority,
        //     });

        //     function matchCustom(params, data) {
        //         if ($.trim(params.term) === '') {
        //             return data;
        //         }
        //         var searchTerm = params.term.toUpperCase();
        //         if (data.children) {
        //             var match = false;
        //             var filteredChildren = [];
        //             $.each(data.children, function(i, child) {
        //                 if (child.text.toUpperCase().indexOf(searchTerm) > -1) {
        //                     filteredChildren.push(child);
        //                     match = true;
        //                 }
        //             });
        //             if (match) {
        //                 var filteredGroup = $.extend({}, data, true);
        //                 filteredGroup.children = filteredChildren;
        //                 return filteredGroup;
        //             }
        //         }
        //         if (data.text.toUpperCase().indexOf(searchTerm) > -1) {
        //             return data;
        //         }
        //         return null;
        //     }


        //     function formatState(state) {
        //         if (!state.id) {
        //             return state.text;
        //         }

        //         if (state.element.value == 'null') {
        //             var $state = $(
        //                 '<span class="d-flex align-items-center"><i class="select-icon bi ' + $(state.element).data('icon') + ' text-secondary border border-2 rounded-circle d-flex align-items-center justify-content-center me-2"></i> ' +
        //                 $(state.element).data('title') + '</span>'
        //             );
        //             return $state;
        //         }

        //         var $state = $(
        //             '<div class="d-flex align-items-center"><img src="' + $(state.element).data('avatar') + '" class="rounded-circle me-2" style="width: 36px; height: 36px;" /> ' +
        //             '<div><p class="m-0 fw-semibold lh-1 mb-2" style="font-size: 14px">' + $(state.element).data('title') + '</p>' +
        //             '<p class="m-0 text-secondary lh-1" style="font-size: 12px">' + $(state.element).data('role') + ' - ' + $(state.element).data('company') + '</p></div></div>'
        //         );

        //         return $state;
        //     }

        //     $('#TaskPerformers').select2({
        //         templateResult: formatState,
        //         templateSelection: formatState,
        //         dropdownParent: $('#view-task-modal'),
        //         placeholder: "Chọn người thực hiện",
        //         matcher: matchCustom,
        //     });

        //     $('#TaskReview').select2({
        //         templateResult: formatState,
        //         templateSelection: formatState,
        //         dropdownParent: $('#view-task-modal'),
        //         placeholder: "Chọn người thực hiện",
        //         matcher: matchCustom,
        //     });

        //     var deadlineTask = Number($('#deadline-task').val());
        //     var deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
        //     var deadlineTaskReview = Number($('#deadline-TaskReview').val());

        //     $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        //     $('#deadline-TaskReview').attr("max", (deadlineTask - deadlineTaskPerformers));

        //     $("#deadline-task").change(function() {
        //         deadlineTask = Number($(this).val());
        //         deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
        //         deadlineTaskReview = Number($('#deadline-TaskReview').val());
        //         $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        //         $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
        //     });


        //     $("#deadline-TaskPerformers").change(function() {
        //         deadlineTaskPerformers = Number($(this).val());
        //         deadlineTask = Number($("#deadline-task").val());
        //         deadlineTaskReview = Number($('#deadline-TaskReview').val());
        //         $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        //         $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));

        //         if (deadlineTaskPerformers > Number($(this).attr("max"))) {
        //             $(this).val(Number($(this).attr("max")));
        //         }
        //     })

        //     $("#deadline-TaskReview").change(function() {
        //         deadlineTask = Number($("#deadline-task").val());
        //         deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
        //         deadlineTaskReview = Number($(this).val());
        //         $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        //         $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
        //         if (deadlineTaskReview > Number($(this).attr("max"))) {
        //             $(this).val(Number($(this).attr("max")));
        //         }
        //     })

        //     function updateModalView(data = [], assignedByUserId) {
        //         var viewModal = $("#view-task-modal");
        //         var feedbackModel = $('#feedback-task-modal');
        //         viewModal.find('.badge').attr("data-value", data["statusTask"]);
        //         viewModal.find('.badge').text(data["statusTask"]);
        //         viewModal.find('#view-task-name').val(data["name"]);
        //         viewModal.find('#view-task-priority').val(data["priority"]).trigger('change');
        //         viewModal.find("#deadline-task").val(data["deadlineTask"]);
        //         descriptionEditor.setData(data["description"]);
        //         viewModal.find('.AssignedBy-info img').attr("src", "data:image/jpeg;base64," + data["avatar"]);
        //         viewModal.find(".AssignedBy-name p:first").text(data["assignedBy"]);
        //         var assignedByInfo = data["position"] + " - " + data["department"];
        //         if (data["department"] == null) {
        //             var assignedByInfo = data["position"];
        //         }
        //         viewModal.find(".AssignedBy-name p:last").text(assignedByInfo);
        //         viewModal.find("#TaskPerformers").val(data["userPerformer"]).trigger('change');
        //         viewModal.find("#deadline-TaskPerformers").val(data["deadlinePerformer"]);
        //         viewModal.find("#TaskReview").val(data["userReviewer"]).trigger('change');
        //         viewModal.find("#deadline-TaskReview").val(data["deadlineReviewer"]);
        //         taskID = data["taskID"];
        //         viewModal.find("#attachments-list").html(data["document"]);
        //         viewModal.find('#progress-range').val(data["progress"]);
        //         viewModal.find('#progress-text').text(data["progress"] + "%");

        //         if (data["statusTask"] == "Dự thảo") {
        //             viewModal.find('#send-task-btn').removeClass("d-none");
        //             viewModal.find("#TaskPerformers").prop("disabled", false);
        //             viewModal.find("#TaskReview").prop("disabled", false);
        //             viewModal.find("#save-task-btn").css("display", "none");
        //             viewModal.find("#range-content").css("display", "none");
        //             viewModal.find(".modal-footer").removeClass("justify-content-between");
        //         } else {
        //             viewModal.find('#send-task-btn').addClass("d-none");
        //             viewModal.find("#TaskPerformers").prop("disabled", true);
        //             viewModal.find("#TaskReview").prop("disabled", true);
        //             viewModal.find("#save-task-btn").css("display", "inline-block");
        //             viewModal.find("#range-content").css("display", "inline-block");
        //             viewModal.find(".modal-footer").addClass("justify-content-between");
        //         }

        //         if (data["statusTask"] == "Chờ duyệt") {
        //             viewModal.find('#recall-task-btn').css("display", "inline-block");
        //         } else {
        //             viewModal.find('#recall-task-btn').css("display", "none");
        //         }

        //         if (viewModal.find("#progress-range").val() == 100) {
        //             viewModal.find("#appraisal-task-btn").css("display", "inline-block");
        //             viewModal.find("#signature-block-task-btn").css("display", "inline-block");
        //         }

        //         if (data["statusTask"].indexOf("Hoàn thành") !== -1 || data["statusTask"] === "Chờ duyệt" || assignedByUserId == <?= json_encode($_SESSION["UserInfo"][0]["UserID"]) ?>) {
        //             viewModal.find("#appraisal-task-btn").css("display", "none");
        //             viewModal.find("#signature-block-task-btn").css("display", "none");
        //             viewModal.find("#progress-range").prop("disabled", true);
        //         } else if (data["statusTask"].indexOf("Hoàn thành") === -1 || data["statusTask"] !== "Chờ duyệt" || assignedByUserId == <?= json_encode($_SESSION["UserInfo"][0]["UserID"]) ?>) {
        //             viewModal.find("#progress-range").prop("disabled", false);
        //         }

        //         if (data["statusTask"].indexOf("Hoàn thành") !== -1 || data["statusTask"] == "Chờ duyệt") {
        //             viewModal.find("#refuse-task-btn").css("display", "none");
        //         } else {
        //             viewModal.find("#refuse-task-btn").css("display", "inline-block");
        //         }

        //         if (data["statusTask"].indexOf("Hoàn thành") !== -1 || data["statusTask"] === "Từ chối phê duyệt") {
        //             viewModal.find("#feedback-task-btn").css("display", "inline-block");
        //             feedbackModel.find('#feedback-area').prop("disabled", true);
        //             $('#feedback-task-modal').find('.modal-footer').css("display", "none");
        //         } else {
        //             viewModal.find("#feedback-task-btn").css("display", "none");
        //             feedbackModel.find('#feedback-area').prop("disabled", false);
        //             $('#feedback-task-modal').find('.modal-footer').css("display", "flex");
        //         }

        //         if (data["statusTask"] === "Từ chối phê duyệt") {
        //             viewModal.find("#feedback-task-btn").text("Xem lý do");
        //             feedbackModel.find('#feedback-task-label').text("Từ chối thẩm định");
        //             feedbackModel.find('#feedback-area-label').text("Lý do");
        //         } else {
        //             viewModal.find("#feedback-task-btn").text("Xem nhận xét");
        //             feedbackModel.find('#feedback-task-label').text("Phê duyệt");
        //             feedbackModel.find('#feedback-area-label').text("Nhận xét");
        //         }

        //         viewModal.find('#comment-list').html(data["commentList"]);
        //         feedbackModel.find('#feedback-area').val(data["feedback"]);
        //     }

        //     $('#progress-range').on('input', function() {
        //         var progress = $(this).val();
        //         $('#progress-text').text(progress + '%');
        //         var viewModal = $("#view-task-modal");
        //         var idPerformer = viewModal.find("#TaskPerformers").val();
        //         var idReviewer = viewModal.find("#TaskReview").val();

        //         if (progress == 100) {
        //             if (idPerformer == <?= $_SESSION["UserInfo"][0]["UserID"] ?>) {
        //                 $('#appraisal-task-btn').css("display", "inline-block");
        //             } else if (idReviewer == <?= $_SESSION["UserInfo"][0]["UserID"] ?>) {
        //                 $('#signature-block-task-btn').css("display", "inline-block");
        //             }
        //         } else {
        //             $('#appraisal-task-btn').css("display", "none");
        //             $('#signature-block-task-btn').css("display", "none");
        //         }
        //     });

        //     var commentEditor;
        //     $('#comment-input').focus(function() {
        //         ClassicEditor
        //             .create(document.querySelector('#comment-input'))
        //             .then(editor => {
        //                 commentEditor = editor;
        //             })
        //             .catch(error => {
        //                 console.error(error);
        //             });
        //         $("#save-comment").removeClass('d-none');
        //     });

        //     $('#comment-list').on('click', '.delete-comment-btn', function() {
        //         var commentID = $(this).attr("data-value");
        //         $.ajax({
        //             url: "<?= getWebRoot() ?>/Task/deleteComment",
        //             type: "POST",
        //             data: {
        //                 commentID: commentID,
        //                 taskID: taskID
        //             },
        //             success: function(response) {
        //                 if (response == "fail") {
        //                     showToast($("#toast-notify"), 'danger', 'Xóa bình luận thất bại.');
        //                 } else {
        //                     $("#view-task-modal").find('#comment-list').html(response);
        //                 }
        //             },

        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //             }
        //         });
        //     });

        //     $('#feedback-task-btn').click(function() {
        //         $('#view-task-modal').css("z-index", "1050");
        //         $('#feedback-task-modal').modal('show');
        //     });
        //     //============================Delete Task============================

        //     $("#delete-task-btn").click(function() {
        //         var toastNotify = $("#toast-notify");
        //         if (taskID != 0) {
        //             $('#view-task-modal').css("z-index", "1050");
        //             $('#delete-task-modal').modal('show');

        //             $("#submit-delete-task").click(function() {
        //                 $('#delete-task-modal').modal('hide');
        //                 $('#modal-loading').removeClass("d-none");
        //                 $.ajax({
        //                     url: '<?= getWebRoot() ?>/Task/deleteTask',
        //                     type: "POST",
        //                     data: {
        //                         taskID: taskID
        //                     },

        //                     success: function(response) {
        //                         if (response == "success") {
        //                             taskID = 0;
        //                             showToast(toastNotify, 'success', 'Xóa thành công.');
        //                             setTimeout(function() {
        //                                 location.reload();
        //                             }, 1000);
        //                         } else if (response == "fail") {
        //                             showToast(toastNotify, 'danger', 'Xóa thất bại.');
        //                             $('#modal-loading').addClass("d-none");
        //                         } else {
        //                             showToast(toastNotify, 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                             $('#modal-loading').addClass("d-none");
        //                         }
        //                     },

        //                     error: function() {
        //                         showToast(toastNotify, 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     }
        //                 });
        //             });
        //         }
        //     });

        //     $('#delete-task-modal').on('hidden.bs.modal', function() {
        //         $('#view-task-modal').css("z-index", "1055");
        //     });

        //     $('#refuse-task-btn').click(function() {
        //         if (taskID != 0) {
        //             $('#feedback-task-modal').find("#submit-comment-task").css("display", "none");
        //             $('#feedback-task-modal').find("#submit-refuse-task").css("display", "inline-block");

        //             $('#view-task-modal').css("z-index", "1050");
        //             var feedbackModel = $('#feedback-task-modal');
        //             feedbackModel.find('#feedback-task-label').text("Từ chối thẩm định");
        //             feedbackModel.find('#feedback-area-label').text("Lý do");
        //             feedbackModel.modal('show');
        //         }
        //     });

        //     $('#feedback-task-modal').on('hidden.bs.modal', function() {
        //         $('#view-task-modal').css("z-index", "1055");
        //     });

        //     $('#submit-refuse-task').click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find('#view-task-name').val();
        //         var taskPerformers = viewModal.find("#TaskPerformers").val();
        //         var feedbackModel = $('#feedback-task-modal');
        //         var content = feedbackModel.find('#feedback-area').val();
        //         if (content.trim() == "") {
        //             showToast($("#toast-notify"), 'warning', 'Vui lòng nhập nhận xét.');
        //         } else {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: '<?= getWebRoot() ?>/Task/refuseTask',
        //                 type: 'POST',
        //                 data: {
        //                     taskID: taskID,
        //                     name: name,
        //                     taskPerformers: taskPerformers,
        //                     content: content
        //                 },

        //                 success: function(response) {
        //                     if (response == "success") {
        //                         showToast($("#toast-notify"), 'success', 'Từ chối thành công.');
        //                         setTimeout(function() {
        //                             location.reload();
        //                         }, 1000);
        //                     } else if (response == "fail") {
        //                         showToast($("#toast-notify"), 'danger', 'Từ chối thất bại.');
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 }
        //             });
        //         }
        //     });
        //     //============================Update Task============================
        //     $('#send-task-btn').click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find('#view-task-name').val();
        //         var priority = viewModal.find('#view-task-priority').val();
        //         var deadlineTask = viewModal.find("#deadline-task").val();
        //         var description = descriptionEditor.getData();
        //         var taskPerformers = viewModal.find("#TaskPerformers").val();
        //         var deadlineTaskPerformers = viewModal.find("#deadline-TaskPerformers").val();
        //         var taskReview = viewModal.find("#TaskReview").val();
        //         var deadlineReview = viewModal.find("#deadline-TaskReview").val();

        //         if (name.trim() == "" || taskPerformers == null || taskReview == null) {
        //             showToast($("#toast-notify"), 'warning', 'Vui lòng điền đầy đủ thông tin.');
        //         } else {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: "<?= getWebRoot() ?>/Task/sendTask",
        //                 type: "POST",
        //                 data: {
        //                     taskID: taskID,
        //                     name: name,
        //                     priority: priority,
        //                     deadlineTask: deadlineTask,
        //                     description: description,
        //                     taskPerformers: taskPerformers,
        //                     deadlineTaskPerformers: deadlineTaskPerformers,
        //                     taskReview: taskReview,
        //                     deadlineReview: deadlineReview
        //                 },

        //                 success: function(response) {
        //                     if (response == "success") {
        //                         showToast($("#toast-notify"), 'success', 'Đã gửi.');
        //                         $('#modal-loading').addClass("d-none");
        //                         setTimeout(function() {
        //                             window.location.href = "<?= getWebRoot() ?>/ac/cong-viec?v=chua-hoan-thanh";
        //                         }, 1000);
        //                     } else if (response == "fail") {
        //                         showToast($("#toast-notify"), 'danger', 'Gửi thất bại.');
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     $('#modal-loading').addClass("d-none");
        //                 }
        //             });
        //         }
        //     })

        //     $('#save-task-btn').click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find("#view-task-name").val();
        //         var priority = viewModal.find("#view-task-priority").val();
        //         var description = descriptionEditor.getData();
        //         var deadlineTask = viewModal.find("#deadline-task").val();
        //         var deadlinePerformer = viewModal.find("#deadline-TaskPerformers").val();
        //         var deadlineReview = viewModal.find("#deadline-TaskReview").val();
        //         var progress = viewModal.find("#progress-range").val();

        //         if (deadlinePerformer > (deadlineTask - deadlineTaskReview) || deadlineReview > (deadlineTask - deadlineTaskPerformers)) {
        //             showToast($("#toast-notify"), 'warning', 'Thời gian không hợp lệ.');
        //         } else if (name.trim() == "") {
        //             showToast($("#toast-notify"), 'warning', 'Tên công việc không được để trống.');
        //         } else {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: "<?= getWebRoot() ?>/Task/updateTask",
        //                 type: "POST",
        //                 data: {
        //                     taskID: taskID,
        //                     name: name,
        //                     priority: priority,
        //                     description: description,
        //                     deadlineTask: deadlineTask,
        //                     deadlinePerformer: deadlinePerformer,
        //                     deadlineReview: deadlineReview,
        //                     progress: progress
        //                 },

        //                 success: function(response) {
        //                     if (response == "success") {
        //                         showToast($("#toast-notify"), 'success', 'Cập nhật thành công.');
        //                         setTimeout(function() {
        //                             location.reload();
        //                         }, 1000);
        //                     } else if (response == "fail") {
        //                         showToast($("#toast-notify"), 'danger', 'Cập nhật thất bại.');
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     $('#modal-loading').addClass("d-none");
        //                 }
        //             })
        //         }
        //     })

        //     $('#save-comment').click(function() {
        //         var comment = commentEditor.getData();
        //         if (comment.trim() != "") {
        //             $.ajax({
        //                 url: '<?= getWebRoot() ?>/Task/addComment',
        //                 type: 'POST',
        //                 data: {
        //                     taskID: taskID,
        //                     comment: comment
        //                 },
        //                 success: function(response) {
        //                     if (response == 'fail') {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     } else {
        //                         commentEditor.setData("");
        //                         $("#view-task-modal").find('#comment-list').html(response);
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 }
        //             });
        //         }
        //     });

        //     $('#appraisal-task-btn').click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find('#view-task-name').val();
        //         var description = descriptionEditor.getData();
        //         var taskReview = viewModal.find("#TaskReview").val();
        //         var deadlineReview = viewModal.find("#deadline-TaskReview").val();
        //         var progress = viewModal.find('#progress-range').val();
        //         if (progress == 100) {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: '<?= getWebRoot() ?>/Task/sendAppraisal',
        //                 type: "POST",
        //                 data: {
        //                     taskID: taskID,
        //                     name: name,
        //                     description: description,
        //                     taskReview: taskReview,
        //                     deadlineReview: deadlineReview,
        //                     progress: progress
        //                 },
        //                 success: function(response) {
        //                     if (response == 'success') {
        //                         showToast($("#toast-notify"), 'success', 'Gửi thành công.');
        //                         setTimeout(function() {
        //                             window.location.href = "<?= getWebRoot() ?>/ac/cong-viec?v=cho-phe-duyet";
        //                         }, 1000);
        //                     } else if (response == 'fail') {
        //                         showToast($("#toast-notify"), 'danger', 'Gửi thất bại.');
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     $('#modal-loading').addClass("d-none");
        //                 }
        //             });
        //         }
        //     });

        //     $('#recall-task-btn').click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find('#view-task-name').val();
        //         var taskReview = viewModal.find("#TaskReview").val();
        //         if(taskReview == <?= $_SESSION["UserInfo"][0]["UserID"] ?>) {
        //             taskReview = -1;
        //         }

        //         $('#modal-loading').removeClass("d-none");
        //         $.ajax({
        //             url: '<?= getWebRoot() ?>/Task/recallTask',
        //             type: "POST",
        //             data: {
        //                 taskID: taskID,
        //                 name: name,
        //                 taskReview: taskReview
        //             },
        //             success: function(response) {
        //                 if (response == 'success') {
        //                     showToast($("#toast-notify"), 'success', 'Thu hồi thành công.');
        //                     setTimeout(function() {
        //                         window.location.href = "<?= getWebRoot() ?>/ac/cong-viec?v=chua-hoan-thanh";
        //                     }, 1000);
        //                 } else if (response == 'fail') {
        //                     showToast($("#toast-notify"), 'danger', 'thu hồi thất bại.');
        //                     $('#modal-loading').addClass("d-none");
        //                 } else {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                     $('#modal-loading').addClass("d-none");
        //                 }
        //             },
        //             error: function() {
        //                 showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 $('#modal-loading').addClass("d-none");
        //             }
        //         });
        //     })

        //     $('#signature-block-task-btn').click(function() {
        //         if (taskID != 0) {
        //             $('#feedback-task-modal').find("#submit-comment-task").css("display", "inline-block");
        //             $('#feedback-task-modal').find("#submit-refuse-task").css("display", "none");

        //             $('#view-task-modal').css("z-index", "1050");
        //             var feedbackModel = $('#feedback-task-modal');
        //             feedbackModel.find('#feedback-task-label').text("Phê duyệt");
        //             feedbackModel.find('#feedback-area-label').text("Nhận xét");
        //             feedbackModel.modal('show');
        //         }
        //     });

        //     $("#submit-comment-task").click(function() {
        //         var viewModal = $("#view-task-modal");
        //         var name = viewModal.find('#view-task-name').val();
        //         var taskPerformers = viewModal.find("#TaskPerformers").val();
        //         var feedbackModel = $('#feedback-task-modal');
        //         var content = feedbackModel.find('#feedback-area').val();
        //         var progress = viewModal.find('#progress-range').val();
        //         if (content.trim() == "") {
        //             showToast($("#toast-notify"), 'warning', 'Vui lòng nhập nhận xét.');
        //         } else {
        //             $('#modal-loading').removeClass("d-none");
        //             $.ajax({
        //                 url: '<?= getWebRoot() ?>/Task/signatureBlockTask',
        //                 type: 'POST',
        //                 data: {
        //                     taskID: taskID,
        //                     name: name,
        //                     taskPerformers: taskPerformers,
        //                     content: content,
        //                     progress: progress
        //                 },

        //                 success: function(response) {
        //                     if (response == "success") {
        //                         showToast($("#toast-notify"), 'success', 'Gửi thành công.');
        //                         setTimeout(function() {
        //                             location.reload();
        //                         }, 1000);
        //                     } else if (response == "fail") {
        //                         showToast($("#toast-notify"), 'danger', 'Gửi thất bại.');
        //                         $('#modal-loading').addClass("d-none");
        //                     } else {
        //                         showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                         $('#modal-loading').addClass("d-none");
        //                     }
        //                 },

        //                 error: function() {
        //                     showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
        //                 }
        //             });
        //         }
        //     });
        // });
    </script>
</div>