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

// chart
const ctx = document.getElementById('general-chart');
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
const data = {
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

const config = {
    type: 'bar',
    data: data,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    },
};

new Chart(ctx, config);