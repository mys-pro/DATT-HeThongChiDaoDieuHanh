$(document).ready(function() {
    $(".sidebar__collapse-btn").click(function() {
        $(".sidebar").toggleClass("open");
        const widthSidebar = $(".sidebar").offsetWidth;
        alert(widthSidebar);
    });
});