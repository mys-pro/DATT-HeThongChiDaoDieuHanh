<?php

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle, 'statistical' => $statistical]);
view('blocks.footer');
?>

<script>
    const labels = [
        <?php
        $result = "";
        foreach ($statistical as $item) {
            $result .= "'${item['DepartmentName']}', ";
        }
        echo rtrim($result, ", ");
        ?>
    ];
    const labelAdjusted = labels.map(label => label.split(' '));
    const barData = {
        labels: labelAdjusted,
        datasets: [{
                label: 'Hoàn thành trước hạn',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Hoàn thành trước hạn']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
                backgroundColor: ['#36A2EB']
            },

            {
                label: 'Hoàn thành đúng hạn',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Hoàn thành đúng hạn']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
                backgroundColor: ['#4BC0C0']
            },

            {
                label: 'Hoàn thành trễ hạn',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Hoàn thành trễ hạn']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
                backgroundColor: ['#FFCD56']
            },

            {
                label: 'Chờ duyệt',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Chờ duyệt']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
                backgroundColor: ['#9966ff']
            },

            {
                label: 'Chưa hoàn thành',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Chưa hoàn thành']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
                backgroundColor: ['#c9cbcf']
            },

            {
                label: 'Quá hạn',
                data: [
                    <?php
                    $result = "";
                    foreach ($statistical as $item) {
                        $result .= "'${item['Quá hạn']}', ";
                    }
                    echo rtrim($result, ", ");
                    ?>
                ],
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