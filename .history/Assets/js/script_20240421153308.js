$(document).ready(function() {
    $('.sidebar__collapse-btn').click(function() {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar-item > a').click(function() {
        $('.sidebar-item > a').removeClass("active");
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