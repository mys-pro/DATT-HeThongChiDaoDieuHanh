//============================================= Sidebar =============================================//
$('.btn-sidebar').click(function () {
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

//============================================= flatpickr =============================================//
flatpickr("#date-filter", {
    dateFormat: "d-m-Y",
    mode: "range"
});

//============================================= Bar chart =============================================//
const labels = ['Văn phòng HĐND-UBND', 'Tài chính - Kế hoạch', 'Nông nghiệp - PTNT', 'Nội vụ', 'Lao động - TB&XH', 'Tài nguyên - MT', 'Công Thương', 'Tư pháp'];
const labelAdjusted = labels.map(label => {
    var words = label.split(' ');
    var twoWordElements = [];
    for (var i = 0; i < words.length; i += 2) {
        var twoWords = words[i];
        if (words[i + 1]) {
            twoWords += ' ' + words[i + 1];
        }
        twoWordElements.push(twoWords);
    }

    return twoWordElements;
})
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
            legend: {
                position: 'bottom',
            }
        },

        font: {
            size: 15
        },

        scales: {
            x: {
                stacked: true,
                grid: {
                    display: false,
                }
            },

            y: {
                beginAtZero: true,
                stacked: true,
                title: {
                    display: true,
                    text: 'Số lượng công việc'
                },
            },
        }
    },
};

new Chart($('#barChart'), barConfig);

//============================================= Doughnut Chart =============================================//
// const doughnutData = {
//     labels: [
//         'Hoàn thành trước hạn',
//         'Hoàn thành đúng hạn',
//         'Hoàn thành trễ hạn',
//         'Chờ duyệt',
//         'Chưa hoàn thành',
//         'Quá hạn'
//     ],
//     datasets: [{
//         // label: 'My First Dataset',
//         data: [5, 11, 12, 6, 35, 3],
//         backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCD56', '#9966ff', '#c9cbcf', '#ff6384'],
//         hoverOffset: 4
//     }]
// };

// const doughnutLabel = {
//     id: 'doughnutLabel',
//     beforeDatasetDraw(chart, args, pluginOptions) {
//         const {ctx, data} = chart;

//         ctx.save();
//         const xCoor = chart.getDatasetMeta(0).data[0].x;
//         const yCoor = chart.getDatasetMeta(0).data[0].y;
//         ctx.font = 'bold 30px sans-serif';
//         ctx.fillStyle = '#7A8489';
//         ctx.textAlign = 'center';
//         ctx.textBaseline = 'middle';
//         ctx.fillText('15', xCoor, yCoor - 15);

//         ctx.font = '16px sans-serif';
//         ctx.fillText('Công việc', xCoor, yCoor + 15);
//     }
// };

// const doughnutConfig = {
//     type: 'doughnut',
//     data: doughnutData,
//     options: {
//         cutout: '80',

//         plugins: {
//             legend: {
//                 display: false,
//             }
//         },
//     },
//     plugins: [doughnutLabel]
// };

// new Chart($('#doughnutChart1'), doughnutConfig);