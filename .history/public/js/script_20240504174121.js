$(document).ready(function () {
    //============================================= Login =============================================//
    $('.btn-eye').click(function() {
        var password = $('#InputPassword1');
        if(password.attr("type") == "password") {
            password.attr('type', 'text');
            $('#eye').removeClass('bi-eye-slash');
            $('#eye').addClass('bi-eye');
        } else {
            password.attr('type', 'password');
            $('#eye').removeClass('bi-eye');
            $('#eye').addClass('bi-eye-slash');
        }
    });

    $('.btn-eye2').click(function() {
        var password = $('#InputPassword2');
        if(password.attr("type") == "password") {
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

    $(document).click(function(event) { 
        if(!$(event.target).closest('.list-apps hide').length && !$(event.target).is('.list-apps')) {
            $(".list-apps").hide();
        }       
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