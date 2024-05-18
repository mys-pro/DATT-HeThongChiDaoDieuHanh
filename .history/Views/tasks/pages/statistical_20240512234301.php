<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>
    <div class="row g-0">
        <div class="col d-flex">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                <li class="filter-item me-2">
                    <select id="priority-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option disabled selected hidden>Độ ưu tiên</option>
                        <option value="0">Tất cả</option>
                        <option value="1">Thấp</option>
                        <option value="2">Vừa</option>
                        <option value="3">Cao</option>
                    </select>
                </li>

                <li class="filter-item me-2">
                    <select id="date-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option value="YEAR" selected>Năm này</option>
                        <option value="MONTH">Tháng này</option>
                        <option value="DATE">Tùy chọn</option>
                    </select>
                </li>

                <li id="date-item" class="filter-item me-2 d-none">
                    <div class="input-group">
                        <input id="date-input" type="text" class="form-control text-secondary border-end-0 bg-transparent border-secondary" placeholder="Thời gian" aria-label="date-input">
                        <label for="date-input" class="input-group-text text-secondary border-start-0 bg-transparent border-secondary">
                            <i class="bi bi-calendar-event-fill"></i>
                        </label>
                    </div>
                </li>
            </ul>
            <button id="btn-filter-statistical" type="button" class="btn btn-primary btn-filter m-2">Áp dụng</button>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <canvas id="barChart" class="bg-white p-4 shadow-sm"></canvas>
        </div>
    </div>

    <div class="row row-cols-xl-4 row-cols-md-3 row-cols-sm-2 row-cols-1 py-2 g-2">
        <?php
        $count = 0;
        foreach ($data['statistical'] as $item) :
            $count++;
        ?>
            <div class="col">
                <canvas id="doughnutChart<?= $count ?>" class="doughnutChart bg-white p-2 shadow-sm w-100 h-100"></canvas>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        $(document).ready(function() {
            //============================================= Bar chart =============================================//
            var doughnutChart = [];

            console.log(doughnutChart.attr("id"));

            var statistical = <?= json_encode($data['statistical']) ?>;
            var departmentName = [];
            var totalTasks = [];
            var dataChart = [];
            var dataChart1 = [];
            var dataChart2 = [];
            var dataChart3 = [];
            var dataChart4 = [];
            var dataChart5 = [];
            var doughnutChart = [];
            var count = 0;

            statistical.forEach(values => {
                departmentName.push(values['DepartmentName']);
                totalTasks.push(values['Tổng công việc']);
                dataChart.push(values['Hoàn thành trước hạn']);
                dataChart1.push(values['Hoàn thành đúng hạn']);
                dataChart2.push(values['Hoàn thành trễ hạn']);
                dataChart3.push(values['Chờ duyệt']);
                dataChart4.push(values['Chưa hoàn thành']);
                dataChart5.push(values['Quá hạn']);
                var data = [dataChart[count], dataChart1[count], dataChart2[count], dataChart3[count], dataChart4[count], dataChart5[count]];
                doughnutChart.push(data);
                count++;
            });

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

            const labels = departmentName;
            const labelAdjusted = labels.map(label => label.split(' '));
            const barData = {
                labels: labelAdjusted,
                datasets: [{
                        label: 'Hoàn thành trước hạn',
                        data: dataChart,
                        backgroundColor: ['#36A2EB']
                    },

                    {
                        label: 'Hoàn thành đúng hạn',
                        data: dataChart1,
                        backgroundColor: ['#4BC0C0']
                    },

                    {
                        label: 'Hoàn thành trễ hạn',
                        data: dataChart2,
                        backgroundColor: ['#FFCD56']
                    },

                    {
                        label: 'Chờ duyệt',
                        data: dataChart3,
                        backgroundColor: ['#9966ff']
                    },

                    {
                        label: 'Chưa hoàn thành',
                        data: dataChart4,
                        backgroundColor: ['#c9cbcf']
                    },

                    {
                        label: 'Quá hạn',
                        data: dataChart5,
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

            var barChart = new Chart($('#barChart'), barConfig);
            //============================================= Doughnut Chart =============================================//
            <?php
            $result = "";
            $count = 0;
            foreach ($data['statistical'] as $department) :
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
                        data: doughnutChart[<?= $count - 1 ?>],
                        backgroundColor: ['#36A2EB', '#4BC0C0', '#FFCD56', '#9966ff', '#c9cbcf', '#ff6384'],
                        hoverOffset: 4
                    }]
                };
            <?php endforeach; ?>

            <?php
            $count = 0;
            foreach ($data['statistical'] as $department) :
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
                        ctx.fillText(totalTasks[<?= $count - 1 ?>], xCoor, yCoor - 15);

                        ctx.font = '16px sans-serif';
                        ctx.fillText('Công việc', xCoor, yCoor + 15);
                    }
                };
            <?php endforeach; ?>

            <?php
            $count = 0;
            foreach ($data['statistical'] as $department) :
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
                                text: departmentName[<?= $count - 1 ?>],
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
            foreach ($data['statistical'] as $department) :
                $count++;
            ?>
                var dChart<?= $count ?> = new Chart($('#doughnutChart<?= $count ?>'), doughnutConfig<?= $count ?>);
            <?php endforeach; ?>

            //============================================= Filter =============================================//
            $('#btn-filter-statistical').click(function() {
                var priority = $('#priority-filter').val();
                var date = $('#date-filter').val();
                var dateStart = 0;
                var dateEnd = 0;
                var toDate = $('#date-input').val().split(" to ");
                if ($('#date-input').val() != "") {
                    if (toDate[0] != null) {
                        var dateTemp = toDate[0].split("-");
                        dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                    }

                    if (toDate[1] != null) {
                        var dateTemp = toDate[1].split("-");
                        dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                    }
                }

                $.ajax({
                    url: '<?= getWebRoot() ?>/ac/thong-ke',
                    method: 'POST',
                    data: {
                        priority: priority,
                        date: date,
                        dateStart: dateStart,
                        dateEnd: dateEnd,
                    },
                    success: function(response) {
                        statistical = JSON.parse(response);
                        departmentName = [];
                        totalTasks = [];
                        dataChart = [];
                        dataChart1 = [];
                        dataChart2 = [];
                        dataChart3 = [];
                        dataChart4 = [];
                        dataChart5 = [];
                        doughnutChart = [];
                        count = 0;

                        statistical.forEach(values => {
                            departmentName.push(values['DepartmentName']);
                            totalTasks.push(values['Tổng công việc']);
                            dataChart.push(values['Hoàn thành trước hạn']);
                            dataChart1.push(values['Hoàn thành đúng hạn']);
                            dataChart2.push(values['Hoàn thành trễ hạn']);
                            dataChart3.push(values['Chờ duyệt']);
                            dataChart4.push(values['Chưa hoàn thành']);
                            dataChart5.push(values['Quá hạn']);
                            var data = [dataChart[count], dataChart1[count], dataChart2[count], dataChart3[count], dataChart4[count], dataChart5[count]];
                            doughnutChart.push(data);
                            count++;
                        });

                        var dataAll = [dataChart, dataChart1, dataChart2, dataChart3, dataChart4, dataChart5];
                        count = 0;
                        barChart.data.datasets.forEach(values => {
                            values.data = dataAll[count];
                            count++;
                        });
                        barChart.update();

                        <?php
                        $count = 0;
                        foreach ($data['statistical'] as $department) :
                            $count++;
                        ?>
                            dChart<?= $count ?>.data.datasets[0].data = doughnutChart[<?= $count - 1 ?>];
                            dChart<?= $count ?>.update();
                        <?php endforeach; ?>
                    },
                });
            });
        });
    </script>
</div>