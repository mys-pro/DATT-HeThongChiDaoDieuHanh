$(document).ready(function() {
    $('.sidebar__collapse-btn').click(function() {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar-item > a').click(function() {
        $('.sidebar-item > a').removeClass("active");
        $(this).addClass("active");
        $('#sidebarToggleExternalContent').collapse('hide');
    });

    $('.sidebar-item-child > a').click(function() {
        $('.sidebar-item-child > a').removeClass("active");
        $(this).addClass("active");
    });
});