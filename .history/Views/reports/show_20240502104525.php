<?php
view('blocks.header');
view('blocks.task_sidebar', ['active' => $active]);
view('reports.index', ['pageTitle' => $pageTitle, 'report' => $report]);
view('blocks.footer');
?>
<script>
    $(document).ready(function() {
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
                    foreach ($statistical as $department) :
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