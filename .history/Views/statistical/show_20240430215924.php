<?php
$result = "";
foreach ($statistical as $item) {
    $result .= "${item['Hoàn thành trước hạn']}, ";
}

echo rtrim($result,",", "");

die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle]);
view('blocks.footer');
?>

<script>
    const labels = [
        <?php
        foreach ($statistical as $item) {
            echo "'${item['DepartmentName']}', ";
        }
        ?>
    ];
    const labelAdjusted = labels.map(label => label.split(' '));
    const barData = {
        labels: labelAdjusted,
        datasets: [{
                label: 'Hoàn thành trước hạn',
                data: [10, 2, 15, 5, 8, 2, 12, 0, ],
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

    if ($('#barChart').length) {
        new Chart($('#barChart'), barConfig);
    }
</script>