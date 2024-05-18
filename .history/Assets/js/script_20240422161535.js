$(document).ready(function() {
    $('.sidebar__menu-btn').click(function() {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar__content-item > a').click(function() {
        $('.sidebar__content-item > a').removeClass("active");
        $(this).addClass("active");
        $('#sidebarToggleExternalContent').collapse('hide');
    });

    $('.sidebar-item > a[data-bs-toggle="collapse"]').click(function() {
        $('.sidebar-item-child > a').removeClass("active");
        $('.sidebar-item-child > a:first').addClass("active");
      });

    $('.sidebar-item-child > a').click(function() {
        $('.sidebar-item-child > a').removeClass("active");
        $(this).addClass("active");
    });

    $('#dropdown-apps').click(function() {
        $('.list-apps').toggleClass('hide')
    });
});