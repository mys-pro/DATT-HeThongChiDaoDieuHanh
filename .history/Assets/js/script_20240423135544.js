$('.sidebar__menu-btn').click(function () {
    $(".sidebar").toggleClass("open");
});

$('.sidebar__content-item > a').click(function () {
    $('.sidebar__content-item > a').removeClass("active");
    $(this).addClass("active");
    $('#sidebarToggleExternalContent').collapse('hide');
});

$('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function () {
    $('.sidebar__dropdown-item > a').removeClass("active");
    $('.sidebar__dropdown-item > a:first').addClass("active");
});

$('.sidebar__dropdown-item > a').click(function () {
    $('.sidebar__dropdown-item > a').removeClass("active");
    $(this).addClass("active");
});

$('#dropdown-apps').click(function () {
    $('.list-apps').toggleClass('hide')
});

//chart box
$('#general-chart')