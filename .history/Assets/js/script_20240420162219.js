$(document).ready(function() {
    $(".sidebar__collapse-btn").click(function() {
        $(".sidebar").toggleClass("open");
    });

    $('.sidebar-item > a').click(function() {
        $('.sidebar-item > a').removeClass("active");
        $(this).addClass("active");
        $('#navToggleExternalContent').collapse('hide');
      });
});