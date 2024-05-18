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

//============================================= Table report=============================================//
if($('#table-report').length) {
    var columnTotal = [0, 0, 0, 0, 0, 0, 0];
    $('#table-report tbody tr').each(function(){
        $(this).find('td:gt(1)').each(function(index){ // Lấy từ cột thứ ba trở đi (index > 1)
            var cellValue = parseInt($(this).text());
            columnTotal[index] += cellValue;
        });
    });
    
    $('#totalRowReport td:gt(0)').each(function(index){ // Hiển thị từ cột thứ ba trở đi
        $(this).text(columnTotal[index]);
    });
}