//============================================= Sidebar =============================================//
$('.btn-sidebar').click(function () {
    $(".sidebar").toggleClass("open");
});

$('.sidebar__content-item > a').click(function () {
    $('.sidebar__content-item > a').removeClass("active");
    $(this).addClass("active");
    $('#sidebarToggleExternalContent').collapse('hide');
    console.log($(window).width());
});

$('.sidebar__content-item > a:not([data-bs-toggle="collapse"])').click(function () {
    if ($('.btn-offcanvas').css('display') != 'none') {
        bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
    }
});

$('.sidebar__content-item > a[data-bs-toggle="collapse"]').click(function () {
    $('.sidebar__dropdown-item > a').removeClass("active");
    $('.sidebar__dropdown-item > a:first').addClass("active");
});

$('.sidebar__dropdown-item > a').click(function () {
    $('.sidebar__dropdown-item > a').removeClass("active");
    $(this).addClass("active");
    bootstrap.Offcanvas.getInstance($('#offcanvasExample')).hide();
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
Chart.defaults.font.size = 14;
const labels = ['Văn phòng HĐND - UBND', 'Tài chính - Kế hoạch', 'Nông nghiệp - PTNT', 'Nội vụ', 'Lao động - TB&XH', 'Tài nguyên - MT', 'Công Thương', 'Tư pháp'];
const labelAdjusted = labels.map(label => label.split(' '));
const barData = {
    labels: labelAdjusted,
    datasets: [
        {
            label: 'Hoàn thành trước hạn',
            data: [10, 2, 15, 5, 8, 2, 12, 0],
            backgroundColor: ['#36A2EB']
        },

        {
            label: 'Hoàn thành đúng hạn',
            data: [15, 20, 15, 10, 11, 27, 18, 9],
            backgroundColor: ['#4BC0C0']
        },

        {
            label: 'Hoàn thành trễ hạn',
            data: [1, 5, 10, 2, 3, 5, 4, 1],
            backgroundColor: ['#FFCD56']
        },

        {
            label: 'Chờ duyệt',
            data: [10, 5, 5, 2, 2, 1, 9, 0],
            backgroundColor: ['#9966ff']
        },

        {
            label: 'Chưa hoàn thành',
            backgroundColor: ['#c9cbcf']
        },

        {
            label: 'Quá hạn',
            data: [, , , 2, , 1, , 4],
            backgroundColor: ['#ff6384']
        },
    ]
};

const barConfig = {
    type: 'bar',
    data: barData,
    options: {
        maintainAspectRatio: false,
        maxBarThickness: 32,
        plugins: {
            tooltip: {
                callbacks: {
                    title: (context) => {
                        return context[0].label.replaceAll(',', ' ');
                    }
                }
            },

            legend: {
                position: 'bottom',
            },

            title: {
                display: true,
                text: 'Tình hình thực hiện công việc',
                align: 'start',
                padding: {
                    bottom: 26,
                },

                font: {
                    size: 18,
                }
            }
        },

        scales: {
            x: {
                stacked: true,
                grid: {
                    display: false,
                },

                // ticks: {
                //     font: {
                //         size: 10,
                //     }
                // }
            },

            y: {
                beginAtZero: true,
                stacked: true,
                title: {
                    display: true,
                    text: 'Số lượng công việc',
                }
            }
        }
    },
};

new Chart($('#barChart'), barConfig);

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

new Chart($('#doughnutChart1'), doughnutConfig);