$(document).ready(function() {
    $('.sidebar__collapse-btn').click(function() {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar-item > a[data-bs-toggle="collapse"]').click(function() {
        $('#navToggleExternalContent').collapse('show');
    });

    $('.sidebar-item > a').click(function() {
        $('.sidebar-item > a').removeClass("active");
        $(this).addClass("active");
        $('#navToggleExternalContent').collapse('hide');
    });

    $('.sidebar-item-child > a').click(function() {
        $('.sidebar-item-child').removeClass("active");
        $(this).parent('.sidebar-item-child').addClass("active");
    });
});