$(document).ready(function() {
    $(".sidebar__collapse-btn").click(function() {
        $(".sidebar").toggleClass("hide");
        $(".sidebar").toggleClass("open");
    });
});