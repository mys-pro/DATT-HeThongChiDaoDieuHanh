<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>
    <div class="row g-0">
        <div class="col d-flex">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                <li class="filter-item me-2">
                    <select id="department-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option disabled selected hidden>Phòng ban</option>
                        <?php foreach ($data['departmentFilter'] as $value) : ?>
                            <option value="<?= $value['DepartmentID'] ?>"><?= $value['DepartmentName'] ?></option>
                        <?php endforeach; ?>
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
            <button title="Xuất file" id="Export-report" type="button" class="btn btn-secondary m-2 ms-0">
                <i class="bi bi-box-arrow-up-right"></i>
            </button>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-data" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">STT</th>
                        <th class="text-center" scope="col">Tên công việc</th>
                        <th class="text-center" scope="col">Đơn vị thực hiện</th>
                        <th class="text-center" scope="col">Thẩm định</th>
                        <th class="text-center" scope="col">Thời gian bắt đầu</th>
                        <th class="text-center" scope="col">Thời gian dự kiến</th>
                        <th class="text-center" scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['report'] as $index => $value) : ?>
                        <tr>
                            <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                            <td data-cell="Tên công việc" class="text-center"><?= $value['TaskName'] ?></td>
                            <td data-cell="Đơn vị thực hiện" class="text-center"><?= $value['DepartmentName'] ?></td>
                            <td data-cell="Thẩm định" class="text-center"><?php if ($value['Reviewer'] == 1) echo "x" ?></td>
                            <td data-cell="Thời gian bắt đầu" class="text-center"><?= $value['DateCreated'] ?></td>
                            <td data-cell="Thời gian dự kiến" class="text-center"><?= $value['ExpectedDate'] ?></td>
                            <td data-cell="Trạng thái" class="text-center"><?= $value['Status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var report = <?= json_encode($data['report']) ?>;
            var department = "";
            var date = 0;
            var dateStart = 0;
            var dateEnd = 0;
            $('#btn-filter-statistical').click(function() {
                department = $('#department-filter').val();
                var date = $('#date-filter').val();
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

                console.log(department);

                $.ajax({
                    url: '<?= getWebRoot() ?>/ac/bao-cao',
                    method: 'POST',
                    data: {
                        department: department,
                        date: date,
                        dateStart: dateStart,
                        dateEnd: dateEnd,
                    },
                    success: function(response) {
                        console.log(response);
                        report = JSON.parse(response);
                        var htmlString = "";
                        var count = 0
                        report.forEach(value => {
                            count++;
                            var reviewerCheck = '';
                            if (value['Reviewer'] == 1) {
                                reviewerCheck = 'x';
                            }
                            htmlString += '<tr>\n' +
                                '<td data-cell="STT" class="text-center">' + count + '</td>\n' +
                                '<td data-cell="Tên công việc" class="text-center">' + value['TaskName'] + '</td>\n' +
                                '<td data-cell="Đơn vị thực hiện" class="text-center">' + value['DepartmentName'] + '</td>\n' +
                                '<td data-cell="Thẩm định" class="text-center">' + reviewerCheck + '</td>' +
                                '<td data-cell="Thời gian bắt đầu" class="text-center">' + value['DateCreated'] + '</td>\n' +
                                '<td data-cell="Thời gian dự kiến" class="text-center">' + value['ExpectedDate'] + '</td>\n' +
                                '<td data-cell="Trạng thái" class="text-center">' + value['Status'] + '</td>\n'; +
                            '</tr>';
                        });
                        $("#table-data > tbody").html(htmlString);
                    },
                });
            });

            $('#Export-report').click(function() {
                $.ajax({
                    url: '<?= getWebRoot() ?>/PDF/report',
                    method: 'POST',
                    data: {
                        department: department,
                        date: date,
                        dateStart: dateStart,
                        dateEnd: dateEnd,
                    },
                    xhrFields: {
                        responseType: 'blob' // Xác định dạng dữ liệu nhận được là blob (file)
                    },
                    success: function(response) {
                        var blob = new Blob([response], {
                            type: 'application/pdf'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'BaoCao.pdf';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function(xhr, status, error) {
                        console.error('Lỗi khi gửi POST request:', error);
                    }
                });
            });
        });
    </script>
</div>