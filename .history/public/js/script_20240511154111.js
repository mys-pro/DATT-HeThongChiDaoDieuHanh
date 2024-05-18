$(document).ready(function () {
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
    //============================================= Sidebar =============================================//
    $('.btn-sidebar').click(function () {
        $(".sidebar").toggleClass("open");
    });

    var sidebarContent = $(".sidebar").html();

    $('.sidebar__content-item > a').click(function () {
        $('.sidebar__content-item > a').removeClass("active");
        $(this).addClass("active");
        $('#sidebarToggleExternalContent').collapse('hide');
    });

    var savedSidebarContent = localStorage.getItem("savedSidebarContent");
    if (savedSidebarContent) {
        $(".sidebar").html(savedSidebarContent);
    } else {
        localStorage.setItem("savedSidebarContent", sidebarContent);
    }

    $('.sidebar__content-item > a').click(function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        localStorage.setItem("savedSidebarContent", sidebarContent);
        window.location.href = url;
    });

    $('.sidebar__content-item > a:not([data-bs-toggle="collapse"])').click(function () {
        if ($('.btn-offcanvas').css('display') != 'none') {
            bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
        }
    });

    $('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function () {
        var href = this.getAttribute("href");
        if (href) {
            var url = new URL(href);
            if (url.origin + url.pathname != window.location.origin + window.location.pathname) {
                window.location.href = href;
            }
        }
    });

    $('.sidebar__dropdown-item > a').click(function () {
        $('.sidebar__dropdown-item > a').removeClass("active");
        $(this).addClass("active");
        if ($('.btn-offcanvas').css('display') != 'none') {
            bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
        }
    });

    $('.sidebar__dropdown-item > a').click(function () {
        $('.sidebar__dropdown-item > a').removeClass("active");
        $(this).addClass("active");
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

    $('.sidebar__dropdown-item > a').click(function (event) {
        event.preventDefault();
        var url = $(this).attr("href");
        history.pushState(null, null, url);
    });

    //============================================= flatpickr =============================================//
    $('#date-filter').change(function () {
        if ($(this).val() == 'DATE') {
            $('#date-item').removeClass('d-none');
        } else {
            $('#date-item').addClass('d-none');
        }
    });

    flatpickr("#date-input", {
        dateFormat: "d-m-Y",
        mode: "range"
    });
});