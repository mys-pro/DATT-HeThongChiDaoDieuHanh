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

$('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function (event) 
{
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
    if ($(this).val() == 'option') {
        $('#date-item').removeClass('d-none');
    } else {
        $('#date-item').addClass('d-none');
    }
});

flatpickr("#date", {
    dateFormat: "d-m-Y",
    mode: "range"
});

//============================================= Bar chart =============================================//
function fontSizeResponsive() {
    if (window.outerWidth >= 576) {
        Chart.defaults.font.size = 14;
    } else {
        Chart.defaults.font.size = 8;
    }
}


window.onresize = function () { fontSizeResponsive() };
fontSizeResponsive();
//============================================= Doughnut Chart =============================================//
const doughnutData = {
    labels: [
        'Hoàn thành trước hạn',
        'Hoàn thành đúng hạn',
        'Hoàn thành trễ hạn',
        'Chờ duyệt',
        'Chưa hoàn thành',
        'Quá hạn'
    ],
    datasets: [{
        // label: 'My First Dataset',
        data: [5, 11, 12, 6, 35, 3],
        backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCD56', '#9966ff', '#c9cbcf', '#ff6384'],
        hoverOffset: 4
    }]
};

const doughnutLabel = {
    id: 'doughnutLabel',
    beforeDatasetDraw(chart, args, pluginOptions) {
        const { ctx, data } = chart;

        ctx.save();
        const xCoor = chart.getDatasetMeta(0).data[0].x;
        const yCoor = chart.getDatasetMeta(0).data[0].y;
        ctx.font = 'bold 30px sans-serif';
        ctx.fillStyle = '#7A8489';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('15', xCoor, yCoor - 15);

        ctx.font = '16px sans-serif';
        ctx.fillText('Công việc', xCoor, yCoor + 15);
    }
};

const doughnutConfig = {
    type: 'doughnut',
    data: doughnutData,
    options: {
        maintainAspectRatio: false,
        cutout: '70%',

        plugins: {
            legend: {
                display: false,
            },

            title: {
                display: true,
                text: 'Văn phòng HĐND - UBND',
                align: 'center',

                font: {
                    size: 18,
                }
            }
        },
    },
    plugins: [doughnutLabel]
};

if ($('#doughnutChart1').length) {
    new Chart($('#doughnutChart1'), doughnutConfig);
}