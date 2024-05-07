<?php
$result = "";
foreach ($statistical as $department) {
    echo $department['DepartmentName'].'<br>;
}
die;

view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('statistical.index', ['pageTitle' => $pageTitle, 'statistical' => $statistical]);
view('blocks.footer');
?>

<script>
    //============================================= Filter =============================================//
    $('#priority-filter').change(function() {
        var value = $(this).val();
        $.ajax({
            url: '<?= getWebRoot() ?>/Task/statistical',
            type: "POST",
            data: {
                filter: value
            },
            success: function(response) {

            },
        });
    });
    //============================================= Bar chart =============================================//
    function fontSizeResponsive() {
        if (window.outerWidth >= 576) {
            Chart.defaults.font.size = 14;
        } else {
            Chart.defaults.font.size = 8;
        }
    }

    window.onresize = function() {
        fontSizeResponsive()
    };
    fontSizeResponsive();

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
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Hoàn thành trước hạn']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
                backgroundColor: ['#36A2EB']
            },

            {
                label: 'Hoàn thành đúng hạn',
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Hoàn thành đúng hạn']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
                backgroundColor: ['#4BC0C0']
            },

            {
                label: 'Hoàn thành trễ hạn',
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Hoàn thành trễ hạn']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
                backgroundColor: ['#FFCD56']
            },

            {
                label: 'Chờ duyệt',
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Chờ duyệt']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
                backgroundColor: ['#9966ff']
            },

            {
                label: 'Chưa hoàn thành',
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Chưa hoàn thành']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
                backgroundColor: ['#c9cbcf']
            },

            {
                label: 'Quá hạn',
                data: [<?php
                        $result = "";
                        foreach ($statistical as $item) {
                            $result .= "'${item['Quá hạn']}', ";
                        }
                        echo rtrim($result, ", ");
                        ?>],
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
    <?php
    $result = "";
    $count = 0;
    foreach ($statistical as $department) :
        $count++;
    ?>
        const doughnutData<?= $count ?> = {
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
                data: [<?php
                        unset($department['DepartmentName']);
                        unset($department['Tổng công việc']);
                        foreach ($department as $key => $value) {
                            $result .= "${value}, ";
                        }
                        echo rtrim($result, ", ");
                        $result = "";
                        ?>],
                backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCD56', '#9966ff', '#c9cbcf', '#ff6384'],
                hoverOffset: 4
            }]
        };
    <?php endforeach; ?>

    <?php
    $count = 0;
    foreach ($statistical as $department) :
        $count++;
    ?>
        const doughnutLabel<?= $count ?> = {
            id: 'doughnutLabel<?= $count ?>',
            beforeDatasetDraw(chart, args, pluginOptions) {
                const {
                    ctx,
                    data
                } = chart;

                ctx.save();
                const xCoor = chart.getDatasetMeta(0).data[0].x;
                const yCoor = chart.getDatasetMeta(0).data[0].y;
                ctx.font = 'bold 30px sans-serif';
                ctx.fillStyle = '#7A8489';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText('<?= $department['Tổng công việc'] ?>', xCoor, yCoor - 15);

                ctx.font = '16px sans-serif';
                ctx.fillText('Công việc', xCoor, yCoor + 15);
            }
        };
    <?php endforeach; ?>

    <?php
    $count = 0;
    foreach ($statistical as $department) :
        $count++;
    ?>
        const doughnutConfig<?= $count ?> = {
            type: 'doughnut',
            data: doughnutData<?= $count ?>,
            options: {
                maintainAspectRatio: false,
                cutout: '70%',

                plugins: {
                    legend: {
                        display: false,
                    },

                    title: {
                        display: true,
                        text: '<?= $department['DepartmentName'] ?>',
                        align: 'center',

                        font: {
                            size: 18,
                        }
                    }
                },
            },
            plugins: [doughnutLabel<?= $count ?>]
        };
    <?php endforeach; ?>

    <?php
    $count = 0;
    foreach ($statistical as $department) :
        $count++;
    ?>
        new Chart($('#doughnutChart<?= $count ?>'), doughnutConfig<?= $count ?>);
    <?php endforeach; ?>
</script>