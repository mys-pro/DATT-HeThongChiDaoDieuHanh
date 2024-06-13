$(document).ready(function () {
    var baseURL = "/DATT-HeThongChiDaoDieuHanh";
    var userID = null;

    if (sessionStorage.getItem("UserID") && sessionStorage.getItem("Role")) {
        userID = sessionStorage.getItem("UserID");
        role = JSON.parse(sessionStorage.getItem("Role"));
    }

    $.ajax({
        url: baseURL + "/login/info",
        type: "POST",
        dataType: "json",
        success: function (response) {
            alert(JSON.stringify(response.Info));
        }
    });

    $(window).on('popstate', function (event) {
        location.reload();
    });
    //============================================= Pusher =============================================//

    // Pusher.logToConsole = true;

    var pusher = new Pusher('6cb0dc56f5ed27c15171', {
        cluster: 'ap1'
    });

    var channel = pusher.subscribe('direct_operator');
    channel.bind('info', function (data) {

    });

    channel.bind('update', function (data) {
        if ($('#dropdown-notify-box').hasClass("show")) {
            $.ajax({
                url: baseURL + "/Task/notifyView",
                type: "POST",
                success: function (response) {
                    if (response != null && response != "") {
                        $('#dropdown-notify-list').html($(response));
                    } else {
                        $('#dropdown-notify-list').html('<li class="d-flex flex-column align-items-center">' +
                            '<img src="' + baseURL + '/public/image/no-notification.png" alt="" width="62px" height="62px">' +
                            '<strong class="ms-2 text-secondary">Chưa có thông báo</strong>' +
                            '</li>');
                    }
                },
            });
        }

        switch (data.type) {
            case "update-file": {
                if (data.taskID == taskID) {
                    $("#attachments-list").html(data.content);
                }
                break;
            }

            case "update-comment": {
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
                break;
            }

            case "update-task": {
                if (taskID == data.taskID) {
                    var scrollPosition = $("#view-task-modal").find(".modal-body").scrollTop();
                    $.ajax({
                        url: baseURL + "/Task/viewTask",
                        type: "POST",
                        data: {
                            idTask: taskID,
                        },
                        success: function (response) {
                            updateViewTask(response);
                            $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                        },

                        error: function () {
                            showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                            $('#view-task-modal').modal('hidden');
                        }
                    });
                }
                break;
            }

            case "delete-task": {
                if (userID != data.userID && taskID == data.taskID) {
                    showNotifyModel("Công việc này đã bị hủy");
                    container.on('hidden.bs.modal', '#notify-modal', function () {
                        $('#view-task-modal').modal('hide');

                        $.ajax({
                            url: window.location.href,
                            method: 'POST',
                            success: function (response) {
                                var notify = $(response).find("#dropdown-notify-btn > .badge");
                                var content = $(response).find("#table-data").html();
                                $("#dropdown-notify-btn").append(notify);
                                $("#table-data").html(content);
                                customStatus();
                            }
                        });
                    });
                }
                break;
            }

            case "recall-task": {
                if (taskID == data.taskID) {
                    if (userID == data.userID) {
                        showNotifyModel("Công việc này đã được thu thồi");
                        $('#notify-modal').on('hidden.bs.modal', function () {
                            location.reload();
                        });
                    }

                    var scrollPosition = $("#view-task-modal").find(".modal-body").scrollTop();
                    $.ajax({
                        url: baseURL + "/Task/viewTask",
                        type: "POST",
                        data: {
                            idTask: taskID,
                        },
                        success: function (response) {
                            updateViewTask(response);
                            $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                        },

                        error: function () {
                            showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                            $('#view-task-modal').modal('hidden');
                        }
                    });
                }
                break;
            }

            case "refuse-task": {
                if (taskID == data.taskID) {
                    if (userID == data.userID) {
                        showNotifyModel("Công việc bị từ chối phê duyệt.");
                        $.ajax({
                            url: baseURL + "/Task/viewTask",
                            type: "POST",
                            data: {
                                idTask: taskID,
                            },
                            success: function (response) {
                                updateViewTask(response);
                                $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                            },

                            error: function () {
                                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                                $('#view-task-modal').modal('hidden');
                            }
                        });
                    } else {
                        var scrollPosition = $("#view-task-modal").find(".modal-body").scrollTop();
                        $.ajax({
                            url: baseURL + "/Task/viewTask",
                            type: "POST",
                            data: {
                                idTask: taskID,
                            },
                            success: function (response) {
                                updateViewTask(response);
                                $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                            },

                            error: function () {
                                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                                $('#view-task-modal').modal('hidden');
                            }
                        });
                    }
                }
                break;
            }

            case "signature-task": {
                if (taskID == data.taskID) {
                    if (userID != data.userID) {
                        showNotifyModel("Công việc đã được duyệt.");
                        $.ajax({
                            url: baseURL + "/Task/viewTask",
                            type: "POST",
                            data: {
                                idTask: taskID,
                            },
                            success: function (response) {
                                updateViewTask(response);
                                $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                            },

                            error: function () {
                                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                                $('#view-task-modal').modal('hidden');
                            }
                        });
                    } else {
                        var scrollPosition = $("#view-task-modal").find(".modal-body").scrollTop();
                        $.ajax({
                            url: baseURL + "/Task/viewTask",
                            type: "POST",
                            data: {
                                idTask: taskID,
                            },
                            success: function (response) {
                                updateViewTask(response);
                                $("#view-task-modal").find(".modal-body").scrollTop(scrollPosition);
                            },

                            error: function () {
                                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                                $('#view-task-modal').modal('hidden');
                            }
                        });
                    }
                }
            }
        }
        $.ajax({
            url: window.location.href,
            method: 'POST',
            success: function (response) {
                var notify = $(response).find("#dropdown-notify-btn > .badge");
                var content = $(response).find("#table-data").html();
                $("#dropdown-notify-btn").append(notify);
                $("#table-data").html(content);
                customStatus();
            }
        });
    });

    channel.bind('admin-update', function (data) {
        switch (data.type) {
            case 'department': {
                $.ajax({
                    url: baseURL + "/kb/phong-ban",
                    method: 'POST',
                    success: function (response) {
                        var content = $(response).find("#table-data").html();
                        $("#table-data").html(content);
                    }
                });
                break;
            }

            case 'position': {
                $.ajax({
                    url: baseURL + "/kb/chuc-vu",
                    method: 'POST',
                    success: function (response) {
                        var content = $(response).find("#table-data").html();
                        $("#table-data").html(content);
                    }
                });
                break;
            }

            case 'user': {
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    success: function (response) {
                        var content = $(response).find("#table-data").html();
                        $("#table-data").html(content);
                    }
                });
                break;
            }

            case 'delete-user': {
                if (data.userID == userID) {
                    sessionStorage.clear();
                    window.location.href = baseURL + "/login/logout";
                } else {
                    $.ajax({
                        url: window.location.href,
                        method: 'POST',
                        success: function (response) {
                            var content = $(response).find("#table-data").html();
                            $("#table-data").html(content);
                        }
                    });
                }
                break;
            }
        }
    });

    channel.bind('setting-update', function (data) {
        switch (data.type) {
            case 'userInfo': {
                $.ajax({
                    url: window.location.href,
                    method: 'POST',
                    success: function (response) {
                        var content = $(response).find("#user-avatar").html();
                        $("#user-avatar").html(content);
                    }
                });
                break;
            }
        }
    });
    //============================================= Notify =============================================//

    $('#dropdown-notify-btn').click(function () {
        $.ajax({
            url: baseURL + "/Task/notifyView",
            type: "POST",
            success: function (response) {
                if (response != null && response != "") {
                    $('#dropdown-notify-list').html(response);
                } else {
                    $('#dropdown-notify-list').html('<li class="d-flex flex-column align-items-center">' +
                        '<img src="' + baseURL + '/public/image/no-notification.png" alt="" width="62px" height="62px">' +
                        '<strong class="ms-2 text-secondary">Chưa có thông báo</strong>' +
                        '</li>');
                }
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    })

    $('#dropdown-notify').on('click', '.notify-link', function (e) {
        e.preventDefault();
        var url = $(this).attr("href");
        var watchedID = $(this).parent().attr("data-id");
        $.ajax({
            url: baseURL + "/Task/notifyView",
            type: "POST",
            data: { watchedID: watchedID },
            success: function (response) {
                if (response == 'success') {
                    window.location.href = url;
                } else {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    });

    $('#dropdown-notify').on('click', '.delete-notify-btn', function (e) {
        var notifyID = $(this).parent().parent().parent().parent().attr("data-id");
        $.ajax({
            url: baseURL + "/Task/deleteNotify",
            type: "POST",
            data: { notifyID: notifyID },
            dataType: 'json',
            success: function (response) {
                if (response.type == 'success') {
                    $('#dropdown-notify-list').find("li[data-id=" + notifyID + "]").remove();
                    if (parseInt(response.quality) > 0) {
                        if ($('#dropdown-notify-btn').find(".badge").length > 0) {
                            $('#dropdown-notify-btn').find(".badge").text(parseInt(response.quality) < 99 ? response.quality : "99+");
                        } else {
                            $('#dropdown-notify-btn').append('<span class="position-absolute top-0 start-50 badge rounded-pill bg-danger">' + (response.quality < 99 ? response.quality : "99+") + '</span>');
                        }
                    } else {
                        $('#dropdown-notify-btn').find(".badge").remove();
                    }

                    if ($('#dropdown-notify-list').children().length === 0) {
                        $('#dropdown-notify-list').html('<li class="d-flex flex-column align-items-center">' +
                            '<img src="' + baseURL + '/public/image/no-notification.png" alt="" width="62px" height="62px">' +
                            '<strong class="ms-2 text-secondary">Chưa có thông báo</strong>' +
                            '</li>');
                    }
                } else {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    });

    $('#dropdown-notify').on('click', '.read-notify-btn', function (e) {
        var notifyID = $(this).parent().parent().parent().parent().attr("data-id");
        $.ajax({
            url: baseURL + "/Task/readNotify",
            type: "POST",
            data: { notifyID: notifyID },
            dataType: 'json',
            success: function (response) {
                if (response.type == 'success') {
                    $('#dropdown-notify-list').find("li[data-id=" + notifyID + "] > a").addClass("watched");
                    if (parseInt(response.quality) > 0) {
                        if ($('#dropdown-notify-btn').find(".badge").length > 0) {
                            $('#dropdown-notify-btn').find(".badge").text(parseInt(response.quality) < 99 ? response.quality : "99+");
                        } else {
                            $('#dropdown-notify-btn').append('<span class="position-absolute top-0 start-50 badge rounded-pill bg-danger">' + (response.quality < 99 ? response.quality : "99+") + '</span>');
                        }
                    } else {
                        $('#dropdown-notify-btn').find(".badge").remove();
                    }
                } else {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    });

    //============================================= Notify toast =============================================//
    if (sessionStorage.getItem('changePass-Success')) {
        var toast = $('#login-toast');
        toast.addClass('text-bg-success');
        toast.find('.toast-body__icon').addClass('bi bi-check');
        toast.find('.toast-body__text').text('Thay đổi mật khẩu thành công.');

        const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#login-toast'))
        toastBootstrap.show()
        sessionStorage.removeItem('changePass-Success');
    }

    if (sessionStorage.getItem('activeAccount-Success')) {
        var toast = $('#login-toast');
        toast.addClass('text-bg-success');
        toast.find('.toast-body__icon').addClass('bi bi-check');
        toast.find('.toast-body__text').text('Kích hoạt thành công.');

        const toastBootstrap = bootstrap.Toast.getOrCreateInstance($('#login-toast'))
        toastBootstrap.show()
        sessionStorage.removeItem('activeAccount-Success');
    }

    if (sessionStorage.getItem("UserID")) {
        userID = sessionStorage.getItem("UserID");
    }

    //============================================= Login =============================================//
    $('.btn-eye-old').click(function () {
        var password = $('#InputPasswordOld');
        if (password.attr("type") == "password") {
            password.attr('type', 'text');
            $('#eye-old').removeClass('bi-eye-slash');
            $('#eye-old').addClass('bi-eye');
        } else {
            password.attr('type', 'password');
            $('#eye-old').removeClass('bi-eye');
            $('#eye-old').addClass('bi-eye-slash');
        }
    });

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

    $('#InputUsername1').keypress(function (event) {
        if (event.which === 13) {
            $('#InputPassword1').focus();
        }
    });

    $('#InputPassword1').keypress(function (event) {
        if (event.which === 13) {
            $('.btn-submit').click();
        }
    });

    $('#InputPassword1').on('copy paste', function (e) {
        e.preventDefault();
    });

    $('#login-btn').click(function () {
        var login = 'login';
        var username = $('#InputUsername1').val();
        var password = $('#InputPassword1').val();
        if (username == '') {
            $('.wrong-account').text('Vui lòng nhập thông tin tài khoản.');
        } else {
            $.ajax({
                url: baseURL + '/dang-nhap',
                method: 'POST',
                data: {
                    login: login,
                    username: username,
                    password: password,
                },
                dataType: 'json',
                success: function (response) {
                    if (response.type == 'success') {
                        sessionStorage.setItem("UserID", response.userID);

                        window.location.href = baseURL + '/ac/cong-viec';
                    } else if (response.type == 'notActive') {
                        $('.wrong-account').text('Tài khoản chưa được kích hoạt.');
                    } else if (response.type == 'fail') {
                        $('.wrong-account').text('Tài khoản hoặc mật khẩu không đúng.');
                    } else {
                        $('.wrong-account').text('Lỗi hệ thống vui lòng thử lại sau.');
                    }
                },
            });
        }
    });

    //============================================= Logout =============================================//

    $('#logout').click(function () {
        sessionStorage.clear();
        window.location.href = baseURL + "/login/logout";
    });

    //============================================= forgot =============================================//

    $('#InputEmail').keypress(function (event) {
        if (event.which === 13) {
            $('.btn-submit').click();
        }
    });

    $('#send-mail').click(function () {
        var email = $("#InputEmail").val();
        if (email != '') {
            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailPattern.test(email)) {
                $('.modal-loading').removeClass('d-none');
                $.ajax({
                    url: baseURL + '/quen-mat-khau',
                    method: 'POST',
                    data: {
                        email: email,
                    },
                    success: function (response) {
                        if (response == 'wrong') {
                            $('.wrong-account').text('Email không tồn tại trong hệ thống.');
                        } else if (response == 'fail') {
                            $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                        } else {
                            $('.wrong-account').text('');
                            window.location.href = baseURL + "/ma-xac-nhan/" + response;
                        }
                    },
                });
            } else {
                $(".wrong-account").text("Định dạng email không hợp lệ.");
            }
        } else {
            $(".wrong-account").text("Vui lòng nhập email.");
        }
    });

    //============================================= verify =============================================//

    var time = 30;
    var timeDown;

    function startCountdown() {
        timeDown = setInterval(function () {
            time--;
            $("#send-verify").text('Gửi lại mã (' + time + " giây)");
            if (time == 0) {
                $("#send-verify").text('Gửi lại mã');
                clearInterval(timeDown);
            }
        }, 1000);
    }

    startCountdown();

    $('#VerifyInput').keypress(function (event) {
        if (event.which === 13) {
            $('.btn-submit').click();
        }
    });

    $('#verify-btn').click(function () {
        var verify = $('#VerifyInput').val();
        if (verify == '') {
            $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
        } else {
            $('.wrong-account').text('');
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    verify: verify
                },
                success: function (response) {
                    if (response == "wrong") {
                        $('.wrong-account').text('Mã xác nhận không đúng.');
                    } else if (response == "overTime") {
                        $('.wrong-account').text('Mã xác nhận đã quá hạn.');
                    } else {
                        window.location.href = baseURL + '/doi-mat-khau/' + response;
                    }
                }
            });
        }
    });

    $('#send-verify').click(function () {
        if (time == 0) {
            time = 30;
            startCountdown();
            var sendVerify = true;
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    sendVerify: sendVerify
                },
                success: function (response) {
                    if (response == 'fail') {
                        $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                    }
                }
            });
        }
    });

    //============================================= change password =============================================//

    $('#InputPassword1').keypress(function (event) {
        if (event.which === 13) {
            $('#InputPassword2').focus();
        }
    });

    $('#InputPassword1').on('copy paste', function (e) {
        e.preventDefault();
    });

    $('#InputPassword2').keypress(function (event) {
        if (event.which === 13) {
            $('.btn-submit').click();
        }
    });

    $('#InputPassword2').on('copy paste', function (e) {
        e.preventDefault();
    });

    $('#changePass-btn').click(function () {
        var inputPassword1 = $('#InputPassword1').val();
        var inputPassword2 = $('#InputPassword2').val();
        var valid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/;
        if (inputPassword1 == '') {
            $('.wrong-account').text('Vui lòng nhập mật khẩu.');
        } else {
            if (!valid.test(inputPassword1)) {
                $('.wrong-account').text('Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
            } else {
                if (inputPassword1 != inputPassword2) {
                    $('.wrong-account').text('Mật khẩu không trùng khớp.');
                } else {
                    $('.wrong-account').text('');
                    $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        data: {
                            updatePassword: inputPassword1
                        },
                        success: function (response) {
                            if (response == "success") {
                                sessionStorage.setItem('changePass-Success', 'true');
                                window.location.href = baseURL;
                            } else {
                                $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                            }
                        }
                    })
                }
            }
        }
    });

    //============================================= Active account =============================================//

    $('#active-btn').click(function () {
        var inputPassword1 = $('#InputPassword1').val();
        var inputPassword2 = $('#InputPassword2').val();
        var valid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/;
        if (inputPassword1 == '') {
            $('.wrong-account').text('Vui lòng nhập mật khẩu.');
        } else {
            if (!valid.test(inputPassword1)) {
                $('.wrong-account').text('Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
            } else {
                if (inputPassword1 != inputPassword2) {
                    $('.wrong-account').text('Mật khẩu không trùng khớp.');
                } else {
                    $('.wrong-account').text('');
                    $.ajax({
                        url: window.location.href,
                        type: 'POST',
                        data: {
                            password: inputPassword1
                        },
                        success: function (response) {
                            if (response == "success") {
                                sessionStorage.setItem('activeAccount-Success', 'true');
                                window.location.href = baseURL;
                            } else {
                                $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                            }
                        }
                    })
                }
            }
        }
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

    $('.nav-item>a[aria-current="page"]').click(function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        history.pushState(null, null, url);

        $('.nav-item>a[aria-current="page"]').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            url: window.location.href,
            method: 'POST',
            success: function (response) {
                var content = $(response).find("#page").html();
                $("#page").html(content);
            }
        });
    })

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
        toast.removeClass("text-bg-info");
        toast.removeClass("text-bg-warning");
        toast.removeClass("text-bg-danger");

        var icon = '';
        switch (type) {
            case 'success': {
                icon = '<i class="bi bi-check-lg me-2 fs-5"></i>';
                break;
            }

            case 'info': {
                icon = '<i class="bi bi-info-circle me-2 fs-5"></i>'
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
            '<div><p class="m-0 fw-semibold lh-1 mb-1" style="font-size: 14px">' + $(state.element).data('title') + '</p>' +
            '<p class="m-0 text-secondary lh-1 text-wrap" style="font-size: 12px">' + $(state.element).data('role') + ' - ' + $(state.element).data('company') + '</p></div></div>'
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

    container.on('click', '#table-data[view="task"] > tbody > tr, #table-data[view="signature"] > tbody > tr', function () {
        var id = $(this).attr('data-id');
        taskID = id;
        var view = $('#table-data').attr('view');

        $.ajax({
            url: baseURL + "/Task/viewTask",
            type: "POST",
            data: {
                idTask: id,
                view: view
            },

            success: function (response) {
                updateViewTask(response);
                $('#view-task-modal').modal('show');
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
            }
        });
    });

    function updateViewTask(response) {
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

        updateDeadlineConstraints();
    }

    function updateDeadlineConstraints() {
        var deadlineTask = Number($('#deadline-task').val());
        var deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
        var deadlineTaskReview = 0;
        if ($('#deadline-TaskReview').length) {
            deadlineTaskReview = Number($('#deadline-TaskReview').val());
        }

        $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        $('#deadline-TaskReview').attr("max", (deadlineTask - deadlineTaskPerformers));

        $("#deadline-task").change(function () {
            deadlineTask = Number($(this).val());
            deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
            if ($('#deadline-TaskReview').length) {
                deadlineTaskReview = Number($('#deadline-TaskReview').val());
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
            }
            $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
        });

        $("#deadline-TaskPerformers").change(function () {
            deadlineTaskPerformers = Number($(this).val());
            deadlineTask = Number($("#deadline-task").val());
            $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));

            if ($('#deadline-TaskReview').length) {
                deadlineTaskReview = Number($('#deadline-TaskReview').val());
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
            }

            if (deadlineTaskPerformers > Number($(this).attr("max"))) {
                $(this).val(Number($(this).attr("max")));
            }
        })

        $("#deadline-TaskReview").change(function () {
            deadlineTask = Number($("#deadline-task").val());
            deadlineTaskPerformers = Number($('#deadline-TaskPerformers').val());
            $('#deadline-TaskPerformers').attr("max", (deadlineTask - deadlineTaskReview));
            if ($('#deadline-TaskReview').length) {
                deadlineTaskReview = Number($('#deadline-TaskReview').val());
                $("#deadline-TaskReview").attr("max", (deadlineTask - deadlineTaskPerformers));
            }

            if (deadlineTaskReview > Number($(this).attr("max"))) {
                $(this).val(Number($(this).attr("max")));
            }
        })
    }

    container.on('hidden.bs.modal', '#view-task-modal', function () {
        taskID = 0;
        if ($('.Description > div').length != 0)
            $('.Description > div').addClass('d-none');
    })

    // Add task
    container.on('keypress', '#add-task-name', function (event) {
        if (event.which === 13) {
            $('#add-task-submit').click();
        }
    })

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
                    taskName: taskName.trim(),
                },
                dataType: 'json',
                success: function (response) {
                    if (response.type === "success") {
                        var id = response.id;
                        showToast($("#toast-notify-content"), 'success', "Thêm thành công.");
                        $.ajax({
                            url: baseURL + "/Task/viewTask",
                            type: "POST",
                            data: {
                                idTask: id,
                            },
                            success: function (response) {
                                taskID = id;
                                updateViewTask(response);
                                $('#view-task-modal').modal('show');
                            },

                            error: function () {
                                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                            }
                        });

                        $('#modal-loading').addClass("d-none");
                        $('#add-task-modal').modal("hide");
                    } else if (response.type === "fail") {
                        showToast($("#toast-notify-content"), 'danger', "Thêm thất bại.");
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    });

    container.on('click', '#forward-task-btn', function () {
        var name = container.find('#view-task-name').val();
        $('#modal-loading').removeClass("d-none");
        $.ajax({
            url: baseURL + "/Task/forwardTask",
            type: "POST",
            data: {
                taskID: taskID,
                taskName: name,
            },
            dataType: 'json',
            success: function (response) {
                if (response.type === "success") {
                    showToast($("#toast-notify-content"), 'success', "Thêm công việc con thành công.");
                    var id = response.id;
                    $.ajax({
                        url: baseURL + "/Task/viewTask",
                        type: "POST",
                        data: {
                            idTask: id,
                        },
                        success: function (response) {
                            taskID = id;
                            updateViewTask(response);
                        },

                        error: function () {
                            showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                        }
                    });

                    $('#modal-loading').addClass("d-none");
                } else if (response.type === "fail") {
                    showToast($("#toast-notify-content"), 'danger', "Thêm công việc con thất bại.");
                    $('#modal-loading').addClass("d-none");
                } else {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                    $('#modal-loading').addClass("d-none");
                }
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                $('#modal-loading').addClass("d-none");
            }
        });
    })
    // Remove Task
    container.on('click', '#delete-task-btn', function () {
        if (taskID != 0) {
            $('#view-task-modal').css("z-index", "1050");
            $('#delete-task-modal').modal('show');

            var viewModal = $("#view-task-modal");
            var taskPerformers = viewModal.find("#TaskPerformers").val();
            var taskReview = null;
            if (viewModal.find("#TaskReview").length > 0) {
                taskReview = viewModal.find("#TaskReview").val();
            }

            $("#submit-delete-task").click(function () {
                $('#delete-task-modal').modal('hide');
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Task/deleteTask',
                    type: "POST",
                    data: {
                        taskID: taskID,
                        taskPerformers: taskPerformers,
                        taskReview: taskReview
                    },

                    success: function (response) {
                        if (response == "success") {
                            taskID = 0;
                            showToast($("#toast-notify-content"), 'success', 'Đã xóa thành công.');
                            $('#view-task-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == "fail") {
                            showToast($("#toast-notify-content"), 'danger', 'Xóa thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            });
        }
    });

    container.on('hidden.bs.modal', '#delete-task-modal', function () {
        $('#view-task-modal').css("z-index", "1055");
    });

    container.on('hidden.bs.modal', '#notify-modal', function () {
        $('#view-task-modal').css("z-index", "1055");
    });

    function showNotifyModel(content) {
        $('#notify-modal').find(".notify-content").text(content);
        $('#view-task-modal').css("z-index", "1050");
        $('#notify-modal').modal("show");
    }

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
                    showToast($("#toast-notify-content"), 'success', 'Tải lên thành công.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify-content"), 'danger', 'Tải lên thất bại.');
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
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
                    showToast($("#toast-notify-content"), 'success', 'Đã xóa tập tin.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify-content"), 'danger', 'Xóa tập tin thất bại.');
                } else if (response == 'notFound') {
                    showToast($("#toast-notify-content"), 'danger', 'Tập tin không tồn tại.');
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
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
                    showToast($("#toast-notify-content"), 'danger', 'Tập tin không tồn tại.');
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
                showToast($("#toast-notify-content"), 'danger', 'Tập tin không tồn tại.');
            }
        });
    });

    //Add comment
    var commentEditor;

    container.on('focus', '#comment-input', function () {
        ClassicEditor
            .create(document.querySelector('#comment-input'), {
                toolbar: ['Undo', 'Redo', '|', 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
            })
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
                        showToast($("#toast-notify-content"), 'danger', 'Gửi bình luận thất bại.');
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
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
                    showToast($("#toast-notify-content"), 'success', 'Đã xóa bình luận.');
                } else if (response == 'fail') {
                    showToast($("#toast-notify-content"), 'danger', 'Xóa bình luận thất bại.');
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    // Send Task
    container.on('click', '#send-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find('#view-task-name').val();
        var priority = viewModal.find('#view-task-priority').val();
        var deadlineTask = viewModal.find("#deadline-task").val();
        var description = descriptionEditor.getData();
        var taskPerformers = viewModal.find("#TaskPerformers").val();
        var deadlineTaskPerformers = viewModal.find("#deadline-TaskPerformers").val();
        var taskReview = viewModal.find("#TaskReview").val();
        var deadlineTaskReview = viewModal.find("#deadline-TaskReview").val();

        if (deadlineTaskPerformers > (deadlineTask - deadlineTaskReview) || deadlineTaskReview > (deadlineTask - deadlineTaskPerformers)) {
            showToast($("#toast-notify-content"), 'warning', 'Thời gian không hợp lệ.');
        } else if (name.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Tên công việc không được để trống.');
        } else if (taskPerformers == null) {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng chọn người thực hiện.');
        } else if (taskReview == null) {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng chọn người thẩm định.');
        } else if (taskPerformers == taskReview) {
            showToast($("#toast-notify-content"), 'warning', 'Người thực hiện và người thẩm định không được giống nhau.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + "/Task/sendTask",
                type: "POST",
                data: {
                    taskID: taskID,
                    name: name,
                    priority: priority,
                    deadlineTask: deadlineTask,
                    description: description,
                    taskPerformers: taskPerformers,
                    deadlineTaskPerformers: deadlineTaskPerformers,
                    taskReview: taskReview,
                    deadlineReview: deadlineTaskReview
                },

                success: function (response) {
                    if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Đã gửi.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Gửi thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    })

    container.on('click', '#send-child-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find('#view-task-name').val();
        var priority = viewModal.find('#view-task-priority').val();
        var deadlineTask = viewModal.find("#deadline-task").val();
        var description = descriptionEditor.getData();
        var taskPerformers = viewModal.find("#TaskPerformers").val();
        var deadlineTaskPerformers = viewModal.find("#deadline-TaskPerformers").val();

        if (deadlineTaskPerformers > deadlineTask) {
            showToast($("#toast-notify-content"), 'warning', 'Thời gian không hợp lệ.');
        } else if (name.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Tên công việc không được để trống.');
        } else if (taskPerformers == null) {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng chọn người thực hiện.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + "/Task/sendTaskChild",
                type: "POST",
                data: {
                    taskID: taskID,
                    name: name,
                    priority: priority,
                    deadlineTask: deadlineTask,
                    description: description,
                    taskPerformers: taskPerformers,
                    deadlineTaskPerformers: deadlineTaskPerformers,
                },

                success: function (response) {
                    if (response == "absurd") {
                        showToast($("#toast-notify-content"), 'warning', 'Không thể giao việc cho chính mình, cấp trên và cùng cấp.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Đã gửi.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Gửi thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    })

    // Save Task
    container.on('click', '#save-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find("#view-task-name").val();
        var priority = viewModal.find("#view-task-priority").val();
        var description = descriptionEditor.getData();
        var deadlineTask = viewModal.find("#deadline-task").val();
        var deadlineTaskPerformer = viewModal.find("#deadline-TaskPerformers").val();
        var deadlineTaskReview = viewModal.find("#deadline-TaskReview").val();
        var progress = viewModal.find("#progress-range").val();

        if (deadlineTaskPerformer > (deadlineTask - deadlineTaskReview) || deadlineTaskReview > (deadlineTask - deadlineTaskPerformer)) {
            showToast($("#toast-notify-content"), 'warning', 'Thời gian không hợp lệ.');
        } else if (name.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Tên công việc không được để trống.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + "/Task/updateTask",
                type: "POST",
                data: {
                    taskID: taskID,
                    name: name,
                    priority: priority,
                    description: description,
                    deadlineTask: deadlineTask,
                    deadlinePerformer: deadlineTaskPerformer,
                    deadlineReview: deadlineTaskReview,
                    progress: progress
                },

                success: function (response) {
                    if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Cập nhật thành công.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Cập nhật thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            })
        }
    });

    container.on('click', '#save-child-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find("#view-task-name").val();
        var priority = viewModal.find("#view-task-priority").val();
        var description = descriptionEditor.getData();
        var deadlineTask = viewModal.find("#deadline-task").val();
        var deadlineTaskPerformer = viewModal.find("#deadline-TaskPerformers").val();
        var progress = viewModal.find("#progress-range").val();

        if (deadlineTaskPerformer > deadlineTask) {
            showToast($("#toast-notify-content"), 'warning', 'Thời gian không hợp lệ.');
        } else if (name.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Tên công việc không được để trống.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + "/Task/updateChildTask",
                type: "POST",
                data: {
                    taskID: taskID,
                    name: name,
                    priority: priority,
                    description: description,
                    deadlineTask: deadlineTask,
                    deadlinePerformer: deadlineTaskPerformer,
                    progress: progress
                },

                success: function (response) {
                    if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Cập nhật thành công.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Cập nhật thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            })
        }
    });

    // Progress
    container.on('input', '#progress-range', function () {
        var progress = $(this).val();
        $('#progress-text').text(progress + '%');

        if (progress == 100) {
            $('#appraisal-task-btn').removeClass('d-none');
            $('#send-signature-child-btn').removeClass('d-none');
            $('#send-signature-btn').removeClass('d-none');
        } else {
            $('#appraisal-task-btn').addClass('d-none');
            $('#send-signature-child-btn').addClass('d-none');
            $('#send-signature-btn').addClass('d-none');
        }
    });

    // Appraisal task
    container.on('click', '#appraisal-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find('#view-task-name').val();
        var description = descriptionEditor.getData();
        var taskReview = viewModal.find("#TaskReview").val();
        var deadlineReview = viewModal.find("#deadline-TaskReview").val();
        var progress = viewModal.find('#progress-range').val();
        if (progress == 100) {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + '/Task/sendAppraisal',
                type: "POST",
                data: {
                    taskID: taskID,
                    name: name,
                    description: description,
                    taskReview: taskReview,
                    deadlineReview: deadlineReview,
                    progress: progress
                },
                success: function (response) {
                    if (response == 'success') {
                        showToast($("#toast-notify-content"), 'success', 'Gửi thành công.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == 'fail') {
                        showToast($("#toast-notify-content"), 'danger', 'Gửi thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    });

    // Recall task
    container.on('click', '#recall-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find('#view-task-name').val();
        var taskReview = viewModal.find("#TaskReview").val();

        $('#modal-loading').removeClass("d-none");
        $.ajax({
            url: baseURL + '/Task/recallTask',
            type: "POST",
            data: {
                taskID: taskID,
                name: name,
                taskReview: taskReview
            },
            success: function (response) {
                if (response == 'signing') {
                    showToast($("#toast-notify-content"), 'warning', 'Công việc đang được trình ký.');
                    $('#modal-loading').addClass("d-none");
                } else if (response == 'success') {
                    showToast($("#toast-notify-content"), 'success', 'Thu hồi thành công.');
                    $('#modal-loading').addClass("d-none");
                } else if (response == 'fail') {
                    showToast($("#toast-notify-content"), 'danger', 'thu hồi thất bại.');
                    $('#modal-loading').addClass("d-none");
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                $('#modal-loading').addClass("d-none");
            }
        });
    });

    container.on('click', '#recall-child-task-btn', function () {
        var viewModal = $("#view-task-modal");
        var name = viewModal.find('#view-task-name').val();

        $('#modal-loading').removeClass("d-none");
        $.ajax({
            url: baseURL + '/Task/recallChildTask',
            type: "POST",
            data: {
                taskID: taskID,
                name: name,
            },
            success: function (response) {
                if (response == 'success') {
                    showToast($("#toast-notify-content"), 'success', 'Thu hồi thành công.');
                    $('#modal-loading').addClass("d-none");
                } else if (response == 'fail') {
                    showToast($("#toast-notify-content"), 'danger', 'thu hồi thất bại.');
                    $('#modal-loading').addClass("d-none");
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            },
            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                $('#modal-loading').addClass("d-none");
            }
        });
    });

    // Refuse task
    container.on('click', '#refuse-task-btn', function () {
        if (taskID != 0) {
            $('#view-task-modal').css("z-index", "1050");
            $.ajax({
                url: baseURL + "/Task/viewFeedback",
                type: "POST",
                data: {
                    taskID: taskID,
                    view: "refuse"
                },
                dataType: 'json',

                success: function (response) {
                    $('#feedback-task-modal').html(response.content);
                    $('#feedback-task-modal').modal('show');
                    $('#submit-comment-task').click(function () {
                        var viewModal = $("#view-task-modal");
                        var name = viewModal.find('#view-task-name').val();
                        var taskPerformers = viewModal.find("#TaskPerformers").val();
                        var taskReviewer = viewModal.find("#TaskReview").val();
                        var feedbackModel = $('#feedback-task-modal');
                        var content = feedbackModel.find('#feedback-area').val();
                        if (content.trim() == "") {
                            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập nhận xét.');
                        } else {
                            $('#feedback-task-modal').modal('hide');
                            $('#modal-loading').removeClass("d-none");
                            $.ajax({
                                url: baseURL + '/Task/refuseTask',
                                type: 'POST',
                                data: {
                                    taskID: taskID,
                                    name: name,
                                    taskPerformers: taskPerformers,
                                    taskReviewer: taskReviewer,
                                    content: content
                                },

                                success: function (response) {
                                    if (response == "success") {
                                        showToast($("#toast-notify-content"), 'success', 'Đã từ chối thành công.');
                                        $('#modal-loading').addClass("d-none");
                                    } else if (response == "fail") {
                                        showToast($("#toast-notify-content"), 'danger', 'Từ chối thất bại.');
                                        $('#modal-loading').addClass("d-none");
                                    } else {
                                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                        $('#modal-loading').addClass("d-none");
                                    }
                                },

                                error: function () {
                                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                }
                            });
                        }
                    });
                },

                error: function (xhr, status, error) {
                    console.error(error);
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            });
        }
    });

    container.on('click', '#refuse-child-task-btn', function () {
        if (taskID != 0) {
            $('#view-task-modal').css("z-index", "1050");
            $.ajax({
                url: baseURL + "/Task/viewFeedback",
                type: "POST",
                data: {
                    taskID: taskID,
                    view: "refuse"
                },
                dataType: 'json',

                success: function (response) {
                    $('#feedback-task-modal').html(response.content);
                    $('#feedback-task-modal').modal('show');
                    $('#submit-comment-task').click(function () {
                        var viewModal = $("#view-task-modal");
                        var name = viewModal.find('#view-task-name').val();
                        var taskPerformers = viewModal.find("#TaskPerformers").val();
                        var feedbackModel = $('#feedback-task-modal');
                        var content = feedbackModel.find('#feedback-area').val();
                        if (content.trim() == "") {
                            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập nhận xét.');
                        } else {
                            $('#feedback-task-modal').modal('hide');
                            $('#modal-loading').removeClass("d-none");
                            $.ajax({
                                url: baseURL + '/Task/refuseChildTask',
                                type: 'POST',
                                data: {
                                    taskID: taskID,
                                    name: name,
                                    taskPerformers: taskPerformers,
                                    content: content
                                },

                                success: function (response) {
                                    if (response == "success") {
                                        showToast($("#toast-notify-content"), 'success', 'Đã từ chối thành công.');
                                        $('#modal-loading').addClass("d-none");
                                    } else if (response == "fail") {
                                        showToast($("#toast-notify-content"), 'danger', 'Từ chối thất bại.');
                                        $('#modal-loading').addClass("d-none");
                                    } else {
                                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                        $('#modal-loading').addClass("d-none");
                                    }
                                },

                                error: function () {
                                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                }
                            });
                        }
                    });
                },

                error: function (xhr, status, error) {
                    console.error(error);
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            });
        }
    });

    container.on('hidden.bs.modal', '#feedback-task-modal', function () {
        $('#view-task-modal').css("z-index", "1055");
    });

    container.on('click', '#feedback-task-btn', function () {
        if (taskID != 0) {
            $('#view-task-modal').css("z-index", "1050");
            $.ajax({
                url: baseURL + "/Task/viewFeedback",
                type: "POST",
                data: {
                    taskID: taskID,
                    view: "content"
                },
                dataType: 'json',

                success: function (response) {
                    $('#feedback-task-modal').html(response.content);
                    $('#feedback-task-modal').modal('show');
                },

                error: function (xhr, status, error) {
                    console.error(error);
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            });
        }
    });

    // Signature
    container.on('click', '#send-signature-btn', function () {
        if (taskID != 0) {
            var viewModal = $("#view-task-modal");
            var name = viewModal.find('#view-task-name').val();
            var taskPerformers = viewModal.find("#TaskPerformers").val();
            var progress = viewModal.find('#progress-range').val();
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + '/Task/sendSignatureTask',
                type: 'POST',
                data: {
                    taskID: taskID,
                    name: name,
                    taskPerformers: taskPerformers,
                    progress: progress
                },

                success: function (response) {
                    if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Trình ký thành công.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Trình ký thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            });
        }
    });

    container.on('click', '#send-signature-child-btn', function () {
        if (taskID != 0) {
            var viewModal = $("#view-task-modal");
            var name = viewModal.find('#view-task-name').val();
            var progress = viewModal.find('#progress-range').val();
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + '/Task/sendSignatureChildTask',
                type: 'POST',
                data: {
                    taskID: taskID,
                    name: name,
                    progress: progress
                },

                success: function (response) {
                    if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Trình ký thành công.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Trình ký thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            });
        }
    });

    container.on('click', '#signature-btn', function () {
        if (taskID != 0) {
            $.ajax({
                url: baseURL + "/Task/viewFeedback",
                type: "POST",
                data: {
                    taskID: taskID,
                    view: "approve"
                },
                dataType: 'json',

                success: function (response) {
                    var viewModal = $("#view-task-modal");
                    var name = viewModal.find('#view-task-name').val();
                    var taskPerformers = viewModal.find("#TaskPerformers").val();
                    var taskReviewer = viewModal.find("#TaskReview").val();
                    $('#view-task-modal').css("z-index", "1050");
                    $('#feedback-task-modal').html(response.content);
                    $('#feedback-task-modal').modal('show');
                    $('#submit-comment-task').click(function () {
                        var feedbackModel = $('#feedback-task-modal');
                        var content = feedbackModel.find('#feedback-area').val();
                        if (content.trim() == "") {
                            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập nhận xét.');
                        } else {
                            $('#feedback-task-modal').modal('hide');
                            $('#modal-loading').removeClass("d-none");
                            $.ajax({
                                url: baseURL + '/Task/signatureTask',
                                type: 'POST',
                                data: {
                                    taskID: taskID,
                                    name: name,
                                    content: content,
                                    taskPerformers: taskPerformers,
                                    taskReviewer: taskReviewer,
                                },

                                success: function (response) {
                                    if (response == "success") {
                                        showToast($("#toast-notify-content"), 'success', 'Duyệt thành công.');
                                        $('#modal-loading').addClass("d-none");
                                    } else if (response == "fail") {
                                        showToast($("#toast-notify-content"), 'danger', 'Duyệt thất bại.');
                                        $('#modal-loading').addClass("d-none");
                                    } else {
                                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                        $('#modal-loading').addClass("d-none");
                                    }
                                },

                                error: function () {
                                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                }
                            });
                        }
                    });
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            });
        }
    })

    container.on('click', '#signature-child-btn', function () {
        if (taskID != 0) {
            $.ajax({
                url: baseURL + "/Task/viewFeedback",
                type: "POST",
                data: {
                    taskID: taskID,
                    view: "approve"
                },
                dataType: 'json',

                success: function (response) {
                    var viewModal = $("#view-task-modal");
                    var name = viewModal.find('#view-task-name').val();
                    var taskPerformers = viewModal.find("#TaskPerformers").val();
                    $('#view-task-modal').css("z-index", "1050");
                    $('#feedback-task-modal').html(response.content);
                    $('#feedback-task-modal').modal('show');
                    $('#submit-comment-task').click(function () {
                        var feedbackModel = $('#feedback-task-modal');
                        var content = feedbackModel.find('#feedback-area').val();
                        if (content.trim() == "") {
                            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập nhận xét.');
                        } else {
                            $('#feedback-task-modal').modal('hide');
                            $('#modal-loading').removeClass("d-none");
                            $.ajax({
                                url: baseURL + '/Task/signatureChildTask',
                                type: 'POST',
                                data: {
                                    taskID: taskID,
                                    name: name,
                                    content: content,
                                    taskPerformers: taskPerformers,
                                },

                                success: function (response) {
                                    if (response == "success") {
                                        showToast($("#toast-notify-content"), 'success', 'Duyệt thành công.');
                                        $('#modal-loading').addClass("d-none");
                                    } else if (response == "fail") {
                                        showToast($("#toast-notify-content"), 'danger', 'Duyệt thất bại.');
                                        $('#modal-loading').addClass("d-none");
                                    } else {
                                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                        $('#modal-loading').addClass("d-none");
                                    }
                                },

                                error: function () {
                                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                                }
                            });
                        }
                    });
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', "Lỗi hệ thống vui lòng thử lại sau.");
                }
            });
        }
    })

    //=====================================admin============================================
    //=====================================department=======================================
    //view department
    container.on('click', '#table-data[view="department"] > tbody > tr', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            url: baseURL + '/Admin/viewDepartment',
            type: 'POST',
            data: {
                departmentID: id
            },

            success: function (response) {
                $('#view-department-modal').html(response);
                $('#view-department-modal').modal('show');
                updateDeparment(id);
                deleteDepartment(id);
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    container.on('hidden.bs.modal', '#view-department-modal', function () {
        $('#view-department-modal').html('');
    });

    //add department
    container.on('click', '#add-department-submit', function () {
        var departmentName = $('#add-department-name').val();
        if (departmentName.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên phòng ban.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + '/Admin/addDepartment',
                type: 'POST',
                data: {
                    departmentName: departmentName
                },
                success: function (response) {
                    if (response == 'success') {
                        showToast($("#toast-notify-content"), 'success', 'Thêm phòng ban thành công.');
                        $('#add-department-modal').modal('hide');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == 'fail') {
                        showToast($("#toast-notify-content"), 'danger', 'Thêm phòng ban thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },
                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    });

    container.on('hidden.bs.modal', '#add-department-modal', function () {
        $('#add-department-name').val('');
    })

    //update department
    function updateDeparment(id) {
        $('#view-department-save').click(function () {
            var name = $('#view-department-name').val();
            if (name.trim() == "") {
                showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên phòng ban.');
            } else {
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Admin/updateDepartment',
                    type: 'POST',
                    data: {
                        departmentId: id,
                        departmentName: name
                    },
                    success: function (response) {
                        if (response == 'success') {
                            showToast($("#toast-notify-content"), 'success', 'Cập nhật phòng ban thành công.');
                            $('#view-department-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == 'fail') {
                            showToast($("#toast-notify-content"), 'danger', 'Cập nhật phòng ban thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            }
        });
    }

    //delete department
    function deleteDepartment(id) {
        $('#view-department-delete').click(function () {
            $('#view-department-modal').css("z-index", "1050");
            $('#delete-department-modal').modal('show');
            $('#submit-delete-department').click(function () {
                $('#delete-department-modal').modal('hide');
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Admin/deleteDepartment',
                    type: 'POST',
                    data: {
                        departmentId: id,
                    },
                    success: function (response) {
                        if (response == 'success') {
                            showToast($("#toast-notify-content"), 'success', 'Đã xóa thành công.');
                            $('#view-department-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == 'fail') {
                            showToast($("#toast-notify-content"), 'danger', 'Xóa thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            });
        });

        container.on('hidden.bs.modal', '#delete-department-modal', function () {
            $('#view-department-modal').css("z-index", "1055");
        });
    }

    //=====================================position=======================================
    // view position
    container.on('click', '#table-data[view="position"] > tbody > tr', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            url: baseURL + '/Admin/viewPosition',
            type: 'POST',
            data: {
                positionID: id
            },

            success: function (response) {
                $('#view-position-modal').html(response);
                $('#view-position-modal').modal('show');
                updatePosition(id);
                deletePosition(id);
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    container.on('hidden.bs.modal', '#view-position-modal', function () {
        $('#view-position-modal').html('');
    });
    // add position
    container.on('click', '#add-position-submit', function () {
        var positionName = $('#add-position-name').val();
        var description = $('#add-position-description').val();
        if (positionName.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên chức vụ.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                url: baseURL + '/Admin/addPosition',
                type: 'POST',
                data: {
                    positionName: positionName,
                    description: description
                },
                success: function (response) {
                    if (response == 'success') {
                        showToast($("#toast-notify-content"), 'success', 'Thêm chức vụ thành công.');
                        $('#add-position-modal').modal('hide');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == 'fail') {
                        showToast($("#toast-notify-content"), 'danger', 'Thêm chức vụ thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },
                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            });
        }
    });

    container.on('hidden.bs.modal', '#add-position-modal', function () {
        $('#add-position-name').val('');
        $('#add-position-description').val('');
    });

    //update position
    function updatePosition(id) {
        $('#view-position-save').click(function () {
            var positionName = $('#view-position-name').val();
            var description = $('#view-position-description').val();
            if (positionName.trim() == "") {
                showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên chức vụ.');
            } else {
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Admin/updatePosition',
                    type: 'POST',
                    data: {
                        positionID: id,
                        positionName: positionName,
                        description: description
                    },
                    success: function (response) {
                        if (response == 'success') {
                            showToast($("#toast-notify-content"), 'success', 'Cập nhật phòng ban thành công.');
                            $('#view-position-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == 'fail') {
                            showToast($("#toast-notify-content"), 'danger', 'Cập nhật phòng ban thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            }
        });
    }

    //delete position
    function deletePosition(id) {
        $('#view-position-delete').click(function () {
            $('#view-position-modal').css("z-index", "1050");
            $('#delete-position-modal').modal('show');
            $('#submit-delete-position').click(function () {
                $('#delete-position-modal').modal('hide');
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Admin/deletePosition',
                    type: 'POST',
                    data: {
                        positionId: id,
                    },
                    success: function (response) {
                        if (response == 'success') {
                            showToast($("#toast-notify-content"), 'success', 'Đã xóa thành công.');
                            $('#view-position-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == 'fail') {
                            showToast($("#toast-notify-content"), 'danger', 'Xóa thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            });
        });

        container.on('hidden.bs.modal', '#delete-position-modal', function () {
            $('#view-position-modal').css("z-index", "1055");
        });
    }

    //=====================================user=======================================
    //add user
    container.on('click', '#add-user-submit', function () {
        var name = $('#add-user-name').val();
        var position = $('#add-user-position').val();
        var department = $('#add-user-department').val();
        var gmail = $('#add-user-gmail').val();
        var phone = $('#add-user-phone').val();
        var role = $('input[name="role"]:checked').attr("data-id");
        var roles = [role];
        $('input[name="additional_permissions"]:checked').each(function () {
            roles.push($(this).attr("data-id"));
        });

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (name.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên người dùng.');
        } else if (gmail.trim() == "") {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập gmail.');
        } else if (!emailPattern.test(gmail)) {
            showToast($("#toast-notify-content"), 'warning', 'Định dang gmail không hợp lệ.');
        } else if (role == null) {
            showToast($("#toast-notify-content"), 'warning', 'Vui lòng chọn quyền.');
        } else {
            $('#modal-loading').removeClass("d-none");
            $.ajax({
                type: "POST",
                url: baseURL + "/Admin/addUser",
                data: {
                    "name": name,
                    "position": position,
                    "department": department,
                    "gmail": gmail,
                    "phone": phone,
                    "roles": roles
                },
                success: function (response) {
                    if (response == 'gmail-exist') {
                        showToast($("#toast-notify-content"), 'warning', 'Gmail đã tồn tại trong hệ thống.');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "success") {
                        showToast($("#toast-notify-content"), 'success', 'Thêm người dùng thành công.');
                        $('#add-user-modal').modal('hide');
                        $('#modal-loading').addClass("d-none");
                    } else if (response == "fail") {
                        showToast($("#toast-notify-content"), 'danger', 'Thêm người dùng thất bại.');
                        $('#modal-loading').addClass("d-none");
                    } else {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                },

                error: function () {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    $('#modal-loading').addClass("d-none");
                }
            });
        }
    });

    container.on('hidden.bs.modal', '#add-user-modal', function () {
        $('#add-user-name').val('');
        $('#add-user-position').prop('selectedIndex', 0);
        $('#add-user-department').prop('selectedIndex', 0);
        $('#add-user-gmail').val('');
        $('#add-user-phone').val('');
        $('input[name="role"]').prop('checked', false);
        $('input[name="role"]:last').prop('checked', true);
        $('input[name="additional_permissions"]').prop('checked', false);
    });

    //view user
    container.on('click', '#table-data[view="user"] > tbody > tr', function () {
        var id = $(this).attr('data-id');
        $.ajax({
            url: baseURL + '/Admin/viewUser',
            type: 'POST',
            data: {
                userID: id
            },

            success: function (response) {
                $('#view-user-modal').html(response);
                $('#view-user-modal').modal('show');
                deleteUser(id);
                updateUser(id);
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    container.on('hidden.bs.modal', '#view-user-modal', function () {
        $('#view-user-modal').html('');
    });

    //delete user
    function deleteUser(id) {
        $('#delete-user-submit').click(function () {
            $('#view-user-modal').css("z-index", "1050");
            $('#delete-user-modal').modal('show');
            $('#submit-delete-user').click(function () {
                $('#delete-user-modal').modal('hide');
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    url: baseURL + '/Admin/deleteUser',
                    type: 'POST',
                    data: {
                        userID: id,
                    },
                    success: function (response) {
                        if (response == 'success') {
                            showToast($("#toast-notify-content"), 'success', 'Đã xóa thành công.');
                            $('#view-user-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == 'fail') {
                            showToast($("#toast-notify-content"), 'danger', 'Xóa thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            });
        });

        container.on('hidden.bs.modal', '#delete-user-modal', function () {
            $('#view-user-modal').css("z-index", "1055");
        });
    }

    // update user
    function updateUser(id) {
        $('#save-user-submit').click(function () {
            var name = $('#view-user-name').val();
            var position = $('#view-user-position').val();
            var department = $('#view-user-department').val();
            var phone = $('#view-user-phone').val();
            var role = $('input[name="role"]:checked').attr("data-id");
            var roles = [role];
            $('input[name="additional_permissions"]:checked').each(function () {
                roles.push($(this).attr("data-id"));
            });

            if (name.trim() == "") {
                showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập tên người dùng.');
            } else {
                $('#modal-loading').removeClass("d-none");
                $.ajax({
                    type: "POST",
                    url: baseURL + "/Admin/updateUser",
                    data: {
                        "userID": id,
                        "name": name,
                        "position": position,
                        "department": department,
                        "phone": phone,
                        "roles": roles
                    },
                    success: function (response) {
                        if (response == "success") {
                            showToast($("#toast-notify-content"), 'success', 'Cập nhật thành công.');
                            $('#view-user-modal').modal('hide');
                            $('#modal-loading').addClass("d-none");
                        } else if (response == "fail") {
                            showToast($("#toast-notify-content"), 'danger', 'Cập nhật thất bại.');
                            $('#modal-loading').addClass("d-none");
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                            $('#modal-loading').addClass("d-none");
                        }
                    },

                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        $('#modal-loading').addClass("d-none");
                    }
                });
            }
        });
    }

    //===================================setting===================================================
    // update avatar
    container.on('change', '#avatar', function () {
        var fileInput = $(this)[0];
        var avatar = fileInput.files[0];
        var formData = new FormData();
        formData.append('avatar', avatar);
        $.ajax({
            type: "POST",
            url: baseURL + "/Setting/updateAvatar",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log(response);
                if (response == "success") {
                    showToast($("#toast-notify-content"), 'success', 'Cập nhật ảnh đại diện thành công.');
                } else if (response == "fail") {
                    showToast($("#toast-notify-content"), 'danger', 'Cập nhật ảnh đại diện thất bại.');
                } else {
                    showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                }
            },

            error: function () {
                showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
            }
        });
    });

    // change pass
    container.on('click', '#change-password-btn', function (e) {
        e.preventDefault();
        $('#change-password-modal').modal('show');
        $('#change-password-submit').click(function () {
            var oldPass = $('#InputPasswordOld').val();
            var newPass = $('#InputPassword1').val();
            var confirmPass = $('#InputPassword2').val();
            var valid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[0-9a-zA-Z!@#$%^&*()_+]{8,}$/;
            if (oldPass.trim() == "") {
                showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập mật khẩu cũ');
            } else if (newPass.trim() == "") {
                showToast($("#toast-notify-content"), 'warning', 'Vui lòng nhập mật khẩu mới');
            } else if (!valid.test(newPass.trim())) {
                showToast($("#toast-notify-content"), 'warning', 'Mật khẩu phải có ít nhất 8 ký tự bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
            } else if (newPass.trim() != confirmPass.trim()) {
                showToast($("#toast-notify-content"), 'warning', 'Mật khẩu không trùng khớp');
            } else {
                $.ajax({
                    type: "POST",
                    url: baseURL + "/Setting/changePassword",
                    data: {
                        oldPass: oldPass,
                        newPass: newPass
                    },
                    success: function (response) {
                        if(response == 'oldPassError') {
                            showToast($("#toast-notify-content"), 'warning', 'Mật khẩu cũ không đúng');
                        } else if (response == "success") {
                            showToast($("#toast-notify-content"), 'success', 'Đổi mật khẩu thành công.');
                            $('#change-password-modal').modal('hide');
                        } else if (response == "fail") {
                            showToast($("#toast-notify-content"), 'danger', 'Đổi mật khẩu thất bại.');
                        } else {
                            showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                        }
                    },
                    error: function () {
                        showToast($("#toast-notify-content"), 'danger', 'Lỗi hệ thống vui lòng thử lại sau.');
                    }
                });
            }
        })
    });

    container.on('hidden.bs.modal', '#change-password-modal', function () {
        $('#InputPasswordOld').val('');
        $('#InputPassword1').val('');
        $('#InputPassword2').val('');
        $('#InputPasswordOld').attr('type', 'password');
        $('#InputPassword1').attr('type', 'password');
        $('#InputPassword2').attr('type', 'password');
        $('#eye-old').removeClass('bi-eye');
        $('#eye-old').addClass('bi-eye-slash');
        $('#eye').removeClass('bi-eye');
        $('#eye').addClass('bi-eye-slash');
        $('#eye2').removeClass('bi-eye');
        $('#eye2').addClass('bi-eye-slash');
    });

});