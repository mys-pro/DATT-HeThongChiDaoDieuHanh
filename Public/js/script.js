$(document).ready(function () {
    var origin = window.location.origin;
    var pathname = window.location.pathname;
    var baseURL = origin;
    if (pathname.split("/")[1] == "DATT-HeThongChiDaoDieuHanh") {
        baseURL = origin + "/" + pathname.split("/")[1];
    }

    $(window).on('popstate', function (event) {
        location.reload();
    });

    $('#dropdown-apps').click(function (event) {
        event.preventDefault();
    });

    //============================================= Notify toast =============================================//
    if (sessionStorage.getItem('addTask-Success')) {
        showToast($("#toast-notify"), 'success', "Thêm thành công.");
        sessionStorage.removeItem('addTask-Success');
    } else if (sessionStorage.getItem('removeTask-success')) {
        showToast($("#toast-notify"), 'success', 'Xóa thành công.');
        sessionStorage.removeItem('removeTask-success');
    }

    //============================================= Pusher =============================================//

    // Pusher.logToConsole = true;

    var pusher = new Pusher('6cb0dc56f5ed27c15171', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('direct_operator');
    channel.bind('update-file', function (data) {
        if (taskID == data.taskID) {
            $("#attachments-list").html(data.content);
        }
    });

    channel.bind('update-comment', function (data) {
        if (taskID == data.taskID) {
            $.ajax({
                url: baseURL + "/Task/viewComment",
                type: "POST",
                data: {
                    taskID: taskID,
                },

                success: function (response) {
                    $("#view-task-modal").find('#comment-list').html(response);
                }
            });
        }
    });

    //============================================= Login =============================================//
    $('.btn-eye').click(function () {
        var password = $('#InputPassword1');
        if (password.attr("type") == "password") {
            password.attr('type', 'text');
            $('#eye').removeClass('bi-eye-slash');
            $('#eye').addClass('bi-eye');
        } else {
            password.attr('type', 'password');
            $('#eye').removeClass('bi-eye');
            $('#eye').addClass('bi-eye-slash');
        }
    });

    $('.btn-eye2').click(function () {
        var password = $('#InputPassword2');
        if (password.attr("type") == "password") {
            password.attr('type', 'text');
            $('#eye2').removeClass('bi-eye-slash');
            $('#eye2').addClass('bi-eye');
        } else {
            password.attr('type', 'password');
            $('#eye2').removeClass('bi-eye');
            $('#eye2').addClass('bi-eye-slash');
        }
    });

    $('#logout').click(function () {
        window.location.href = baseURL + "/login/logout";
    });
    //============================================= Sidebar =============================================//
    $('.btn-sidebar').click(function () {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar__content-item > a:not([data-bs-toggle="collapse"])').click(function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        history.pushState(null, null, url);

        $('.sidebar__content-item > a').removeClass("active");
        $('.sidebar__dropdown-item > a').removeClass("active");
        $(this).addClass("active");
        $('#sidebarToggleExternalContent').collapse('hide');

        $.ajax({
            url: window.location.href,
            method: 'POST',
            success: function (response) {
                var content = $(response).find(".content").html();
                $(".content").html(content);

                flatpickr("#date-input", {
                    dateFormat: "d-m-Y",
                    mode: "range"
                });
                customStatus();
            }
        });
    });

    $('.sidebar__content-item > a:not([data-bs-toggle="collapse"])').click(function () {
        if ($('.btn-offcanvas').css('display') != 'none') {
            bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
        }
    });

    // $('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function () {
    //     var href = $('.sidebar__dropdown-item > a:first').attr("href");
    //     if (href) {
    //         var url = new URL(href);
    //         if (url.origin + url.pathname != window.location.origin + window.location.pathname) {
    //             $('.sidebar__dropdown-item > a:first').click();
    //         }
    //     }
    // });

    $('.sidebar__dropdown-item > a').click(function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        history.pushState(null, null, url);

        $('.sidebar__content-item > a').removeClass("active");
        $('.sidebar__content-item > a[data-bs-toggle="collapse"]').addClass("active");
        $('.sidebar__dropdown-item > a').removeClass("active");
        $(this).addClass("active");
        if ($('.btn-offcanvas').css('display') != 'none') {
            bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
        }

        $.ajax({
            url: window.location.href,
            method: 'POST',
            success: function (response) {
                var content = $(response).find(".content").html();
                $(".content").html(content);
                flatpickr("#date-input", {
                    dateFormat: "d-m-Y",
                    mode: "range"
                });
                customStatus();
            }
        });
    });

    $('#dropdown-apps').click(function () {
        $('.list-apps').toggleClass('hide')
    });

    $(document).click(function (event) {
        var $target = $(event.target);
        if (!$target.closest('#dropdown-apps').length && !$target.closest('.list-apps').length) {
            $(".list-apps").addClass("hide");
        }
    });

    //================================Filter: report==============================
    var container = $('.content');
    container.on('change', '#date-filter', function () {
        if ($(this).val() == 'DATE') {
            $('#date-item').removeClass('d-none');
        } else {
            $('#date-item').addClass('d-none');
        }
    });

    var department = "";
    var date = "YEAR";
    var dateStart = 0;
    var dateEnd = 0;
    container.on('click', '#btn-filter-report', function () {
        department = $('#department-filter').val();
        date = $('#date-filter').val();
        var toDate = $('#date-input').val().split(" to ");
        if ($('#date-input').val() != "") {
            if (toDate[0] != null) {
                var dateTemp = toDate[0].split("-");
                dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
            }

            if (toDate[1] != null) {
                var dateTemp = toDate[1].split("-");
                dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
            }
        }

        $.ajax({
            url: baseURL + '/ac/bao-cao',
            method: 'POST',
            data: {
                department: department,
                date: date,
                dateStart: dateStart,
                dateEnd: dateEnd,
            },
            success: function (response) {
                var report = $(response).find("#table-data").html();
                $("#table-data").html(report);
            },
        });
    });

    container.on('click', '#Export-report', function () {
        $.ajax({
            url: baseURL + '/PDF/report',
            method: 'POST',
            data: {
                department: department,
                date: date,
                dateStart: dateStart,
                dateEnd: dateEnd,
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function (response) {
                var blob = new Blob([response], {
                    type: 'application/pdf'
                });
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = 'BaoCao.pdf';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },
            error: function (xhr, status, error) {
                console.error('Lỗi khi gửi POST request:', error);
            }
        });
    });

    //================================Task==============================
    var taskID = 0;

    function showToast(toast, type, message) {
        toast.removeClass("text-bg-success");
        toast.removeClass("text-bg-warning");
        toast.removeClass("text-bg-danger");

        var icon = '';
        switch (type) {
            case 'success': {
                icon = '<i class="bi bi-check-lg me-2 fs-5"></i>';
                break;
            }

            case 'warning': {
                icon = '<i class="bi bi-exclamation-triangle me-2 fs-5"></i>';
                break;
            }

            case 'danger': {
                icon = '<i class="bi bi-x-circle me-2 fs-5"></i>';
                break;
            }
        }

        var status = "text-bg-" + type;
        message = icon + message;

        toast.addClass(status);
        toast.find(".toast-body").html(message);
        bootstrap.Toast.getOrCreateInstance(toast).show();
    }

    function customStatus() {
        const $cell1Elements = $('[data-cell="Tình trạng"]');
        $cell1Elements.each(function () {
            const dataValue = $(this).attr('data-value');
            if (dataValue == "Hoàn thành trước hạn") {
                $(this).children().addClass("bg-primary text-primary");
            } else if (dataValue == "Hoàn thành") {
                $(this).children().addClass("bg-success text-success");
            } else if (dataValue == "Hoàn thành trễ hạn") {
                $(this).children().addClass("bg-warning text-warning");
            } else if (dataValue == "Chờ duyệt") {
                $(this).children().addClass("bg-info text-info");
            } else if (dataValue == "Quá hạn" || dataValue == "Từ chối phê duyệt") {
                $(this).children().addClass("bg-danger text-danger");
            } else {
                $(this).children().addClass("bg-secondary text-secondary");
            }
        });
    }

    function customStatusView() {
        $('#view-task-modal').find(".badge").removeClass("bg-primary text-primary");
        $('#view-task-modal').find(".badge").removeClass("bg-success text-success");
        $('#view-task-modal').find(".badge").removeClass("bg-warning text-warning");
        $('#view-task-modal').find(".badge").removeClass("bg-info text-info");
        $('#view-task-modal').find(".badge").removeClass("bg-danger text-danger");
        $('#view-task-modal').find(".badge").removeClass("bg-secondary text-secondary");

        var statusTask = $('#view-task-modal').find(".badge").attr('data-value');
        if (statusTask == "Hoàn thành trước hạn") {
            $('#view-task-modal').find(".badge").addClass("bg-primary text-primary");
        } else if (statusTask == "Hoàn thành") {
            $('#view-task-modal').find(".badge").addClass("bg-success text-success");
        } else if (statusTask == "Hoàn thành trễ hạn") {
            $('#view-task-modal').find(".badge").addClass("bg-warning text-warning");
        } else if (statusTask == "Chờ duyệt") {
            $('#view-task-modal').find(".badge").addClass("bg-info text-info");
        } else if (statusTask == "Quá hạn" || statusTask == "Từ chối phê duyệt") {
            $('#view-task-modal').find(".badge").addClass("bg-danger text-danger");
        } else {
            $('#view-task-modal').find(".badge").addClass("bg-secondary text-secondary");
        }
    }

    function resizeTextArea(el) {
        var autoResize = function () {
            el.css('height', 'auto');
            el.css('height', el[0].scrollHeight + 'px');
        };

        el.on('input', autoResize);
        autoResize();
    }

    function formatStatePriority(state) {
        if (!state.id) {
            return state.text;
        }

        var $state = $(
            '<span><i class="' + $(state.element).data('icon') + ' me-2"></i>' + $(state.element).data('title') + '</span>'
        );

        return $state;
    }

    function matchCustom(params, data) {
        if ($.trim(params.term) === '') {
            return data;
        }
        var searchTerm = params.term.toUpperCase();
        if (data.children) {
            var match = false;
            var filteredChildren = [];
            $.each(data.children, function (i, child) {
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

    customStatus();

    // Search
    container.on('keypress', '#search', function (event) {
        if (event.which === 13) {
            $('#btn-search').click();
        }
    });

    container.on('click', '#btn-search', function () {
        var search = $('#search').val();
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                search: search
            },

            success: function (response) {
                var data = $(response).find("#table-data").html();
                $("#table-data").html(data);
                customStatus();
            }
        })
    });

    // View task
    container.on('click', '#Description-btn', function () {
        $('.Description > div').toggleClass('d-none');
    });

    var descriptionEditor;

    container.on('click', '#table-data > tbody > tr', function () {
        var id = $(this).attr('data-id');
        taskID = id;

        $.ajax({
            url: baseURL + "/Task/viewTask",
            type: "POST",
            data: {
                idTask: id,
            },
            success: function (response) {
                $('#view-task-modal').html(response);
                customStatusView();

                var textarea = $('#view-task-name');
                resizeTextArea(textarea);

                $('#view-task-priority').select2({
                    dropdownParent: $('#view-task-modal'),
                    minimumResultsForSearch: Infinity,
                    templateResult: formatStatePriority,
                    templateSelection: formatStatePriority,
                });

                ClassicEditor
                    .create(document.querySelector('#Description-view-task'))
                    .then(editor => {
                        descriptionEditor = editor;

                        // const toolbarElement = editor.ui.view.toolbar.element;
                        if ($('#Description-view-task').data('readonly') === false) {
                            editor.enableReadOnlyMode('Description-view-task');
                            // toolbarElement.style.display = 'none';
                        }

                        editor.setData($('#Description-view-task').text());
                    })
                    .catch(error => {
                        console.error(error);
                    });

                $('#TaskPerformers optgroup').each(function () {
                    if ($(this).children('option').length === 0) {
                        $(this).remove();
                    }
                });

                $('#TaskReview optgroup').each(function () {
                    if ($(this).children('option').length === 0) {
                        $(this).remove();
                    }
                });

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

                $("#deadline-task").change(function () {
                    deadlineTask = Number($(this).val());
                    deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
                    deadlineTaskReview = Number($('#deadline-TaskReview').val());
                    $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                    $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
                });

                $("#deadline-TaskPerformers").change(function () {
                    deadlineTaskPerformers = Number($(this).val());
                    deadlineTask = Number($("#deadline-task").val());
                    deadlineTaskReview = Number($('#deadline-TaskReview').val());
                    $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                    $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));

                    if (deadlineTaskPerformers > Number($(this).attr("max"))) {
                        $(this).val(Number($(this).attr("max")));
                    }
                })

                $("#deadline-TaskReview").change(function () {
                    deadlineTask = Number($("#deadline-task").val());
                    deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
                    deadlineTaskReview = Number($(this).val());
                    $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
                    $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
                    if (deadlineTaskReview > Number($(this).attr("max"))) {
                        $(this).val(Number($(this).attr("max")));
                    }
                })

                $('#view-task-modal').modal('show');
            },

            error: function () {
                showToast($("#toast-notify"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    });

    container.on('hidden.bs.modal', '#view-task-modal', function () {
        taskID = 0;
        if ($('.Description > div').length != 0)
            $('.Description > div').addClass('d-none');
    })

    // Add task
    container.on('hidden.bs.modal', '#add-task-modal', function () {
        $('#add-task-name').val("");
    });

    container.on('click', '#add-task-submit', function () {
        var taskName = $('#add-task-name').val();
        if (taskName.trim() === "") {
            showToast(toastNotify, 'warning', "Vui lòng nhập tên công việc.");
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + "/Task/addTask",
                type: "POST",
                data: {
                    taskName: taskName,
                },

                success: function (response) {
                    if (response === "success") {
                        sessionStorage.setItem('addTask-Success', 'true');
                        window.location.href = baseURL + "/ac/cong-viec?v=du-thao";
                    } else if (response === "fail") {
                        showToast($("#toast-notify"), 'danger', "Thêm thất bại.");
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    });

    // Remove Task
    container.on('click', '#delete-task-btn', function () {
        if (taskID != 0) {
            $('#view-task-modal').css("z-index", "1050");
            $('#delete-task-modal').modal('show');

            $("#submit-delete-task").click(function () {
                $('#delete-task-modal').modal('hide');
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Task/deleteTask',
                    type: "POST",
                    data: {
                        taskID: taskID
                    },

                    success: function (response) {
                        if (response == "success") {
                            taskID = 0;
                            sessionStorage.setItem('removeTask-success', 'true');
                            location.reload();
                        } else if (response == "fail") {
                            showToast($("#toast-notify"), 'danger', 'Xóa thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            });
        }
    });

    container.on('hidden.bs.modal', '#delete-task-modal', function () {
        $('#view-task-modal').css("z-index", "1055");
    });

    //Add File
    container.on('change', '#add-file', function () {
        var formData = new FormData();
        var files = $(this)[0].files;

        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        formData.append('taskID', taskID);

        $.ajax({
            url: baseURL + '/Task/uploadFile',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == "success") {
                    showToast($("#toast-notify"), 'success', 'Tải lên thành công.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify"), 'danger', 'Tải lên thất bại.');
                } else {
                    showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },
            error: function () {
                showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
        $(this).val("");
    });

    //Remove File
    container.on('click', '.remove-file-btn', function () {
        var documentID = $("#attachments-list").find(".link-file").attr('data-value');
        $.ajax({
            url: baseURL + '/Task/removeFile',
            type: 'POST',
            data: {
                documentID: documentID,
                taskID: taskID
            },
            success: function (response) {
                if (response == "success") {
                    showToast($("#toast-notify"), 'success', 'Đã xóa tập tin.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify"), 'danger', 'Xóa tập tin thất bại.');
                } else if (response == 'notFound') {
                    showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
                } else {
                    showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },

            error: function () {
                showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    //Download File
    container.on('click', '.link-file', function (e) {
        var documentID = $(this).attr('data-value');
        $.ajax({
            url: baseURL + '/Task/downloadFile',
            type: 'POST',
            data: {
                documentID: documentID
            },
            success: function (response) {
                if (response == "notFound") {
                    showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
                } else {
                    var link = response.split(", ");
                    var a = document.createElement('a');
                    a.href = link[1];
                    a.download = link[0];
                    document.body.appendChild(a);
                    a.click();
                    $(a).remove();
                }
            },

            error: function () {
                showToast($("#toast-notify"), 'danger', 'Tập tin không tồn tại.');
            }
        });
    });

    //Add comment
    var commentEditor;

    container.on('focus', '#comment-input', function () {
        ClassicEditor
            .create(document.querySelector('#comment-input'))
            .then(editor => {
                commentEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
        $("#save-comment").removeClass('d-none');
    });

    container.on('click', '#save-comment', function () {
        var comment = commentEditor.getData();
        if (comment.trim() != "") {
            $.ajax({
                url: baseURL + '/Task/addComment',
                type: 'POST',
                data: {
                    taskID: taskID,
                    comment: comment
                },
                success: function (response) {
                    if (response == 'success') {
                        commentEditor.setData("");
                    } else if (response == 'fail') {
                        showToast($("#toast-notify"), 'danger', 'Gửi bình luận thất bại.');
                    } else {
                        showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                },

                error: function () {
                    showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            });
        }
    });

    //Remove comment
    container.on('click', '.delete-comment-btn', function () {
        var commentID = $(this).attr("data-value");
        $.ajax({
            url: baseURL + "/Task/deleteComment",
            type: "POST",
            data: {
                commentID: commentID,
                taskID: taskID
            },
            success: function (response) {
                if (response == 'success') {
                    showToast($("#toast-notify"), 'success', 'Đã xóa bình luận.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify"), 'danger', 'Xóa bình luận thất bại.');
                } else {
                    showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },

            error: function () {
                showToast($("#toast-notify"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });
});