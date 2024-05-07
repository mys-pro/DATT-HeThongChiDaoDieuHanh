$(document).ready(function () {
    //============================================= Login =============================================//
    $('.btn-eye').click(function() {
        console.log(thís);
        var password = $('.form-login #InputPassword1');
        if(password.type == "password") {
            password.type = "text";
            $('.hide-pass').addClass('d-none');
            $('.show-pass').removeClass('d-none');
        } else {
            password.type = "password";
            $('.hide-pass').removeClass('d-none');
            $('.show-pass').addClass('d-none');
        }
    });

    //============================================= Sidebar =============================================//
    $('.btn-sidebar').click(function () {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar__content-item > a').click(function () {
        $('.sidebar__content-item > a').removeClass("active");
        $(this).addClass("active");
        $('#sidebarToggleExternalContent').collapse('hide');
    });

    $('.sidebar__content-item > a:not([data-bs-toggle="collapse"])').click(function () {
        if ($('.btn-offcanvas').css('display') != 'none') {
            bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
        }
    });

    $('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function (event) {
        $('.sidebar__dropdown-item > a').removeClass("active");
        $('.sidebar__dropdown-item:first-of-type > a').addClass("active");
        window.open($('.sidebar__dropdown-item:first-of-type > a').attr('href'), '_self');
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