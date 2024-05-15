<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $data['pageTitle'] ?></span>
    <div class="row g-0">
        <div class="col d-flex justify-content-between">
            <div class="search d-flex p-2">
                <input class="form-control me-2" type="search" placeholder="Tìm công việc..." aria-label="Search">
                <button id="btn-search" class="btn btn-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
            <button id="btn-add-task" class="btn btn-primary my-2 me-2" type="submit">
                <i class="bi bi-plus-lg"></i>
            </button>
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-data" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">STT</th>
                        <th class="text-start" scope="col">Tên công việc</th>
                        <th class="text-start" scope="col">Tình trạng</th>
                        <th class="text-start" scope="col">Người giao</th>
                        <th class="text-center" scope="col">Hạn hoàn thành</th>
                        <th class="text-center" scope="col" style="min-width: 100px">Tiến độ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['taskList'] as $index => $value) : ?>
                        <tr>
                            <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                            <td data-cell="Tên công việc" class="text-start text-break"><?= $value["TaskName"] ?></td>
                            <td data-cell="Tình trạng" class="text-start" data-value="<?= $value["Status"] ?>">
                                <span class="badge bg-opacity-25 fw-semibold"><?= $value["Status"] ?></span>
                            </td>
                            <td data-cell="Người giao" class="text-start">
                                <img class="rounded-circle" src="data:image/jpeg;base64,<?= $value["Avatar"] ?>" alt="" width="32px" height="32px">
                                <span class="ms-2"><?= $value["FullName"] ?></span>
                            </td>
                            <td data-cell="Hạn hoàn thành" class="text-center"><?= $value["Deadline"] ?>
                            </td>
                            <td data-cell="Tiến độ" class="text-center">
                                <div class="progress-task d-flex align-items-center">
                                    <div class="progress flex-fill me-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: <?= $value["Progress"] ?>%"></div>
                                    </div>
                                    <span class="progress-text text-start"><?= $value["Progress"] ?>%</span>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function customStatus() {
                const $cell1Elements = $('[data-cell="Tình trạng"]');
                $cell1Elements.each(function() {
                    const dataValue = $(this).attr('data-value');
                    if (dataValue == "Hoàn thành trước hạn") {
                        $(this).children().addClass("bg-primary text-primary");
                    } else if (dataValue == "Hoàn thành") {
                        $(this).children().addClass("bg-success text-success");
                    } else if (dataValue == "Hoàn thành trễ hạn") {
                        $(this).children().addClass("bg-warning text-warning");
                    } else if (dataValue == "Chờ duyệt") {
                        $(this).children().addClass("bg-info text-info");
                    } else if (dataValue == "Trễ hạn") {
                        $(this).children().addClass("bg-danger text-danger");
                    } else {
                        $(this).children().addClass("bg-secondary text-secondary");
                    }
                });
            }
            customStatus();

            function fetchDataAndUpdate() {
                $.ajax({
                    url: window.location.href,
                    type: 'POST',
                    data: {
                        fetchData: true
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var html = "";
                        data.forEach((index, value) => {
                            html += '<tr> \n' +
                            '<td data-cell="STT" class="text-center"><?= index + 1 ?></td>' +
                            '<td data-cell="Tên công việc" class="text-start text-break"><?= $value["TaskName"] ?></td>' +
                            '<td data-cell="Tình trạng" class="text-start" data-value="<?= $value["Status"] ?>">' +
                                '<span class="badge bg-opacity-25 fw-semibold"><?= $value["Status"] ?></span>' +
                            '</td>' +
                            '<td data-cell="Người giao" class="text-start">' +
                                '<img class="rounded-circle" src="data:image/jpeg;base64,<?= $value["Avatar"] ?>" alt="" width="32px" height="32px">' +
                                '<span class="ms-2"><?= $value["FullName"] ?></span>' +
                            '</td>' +
                            '<td data-cell="Hạn hoàn thành" class="text-center"><?= $value["Deadline"] ?></td>' +
                            '<td data-cell="Tiến độ" class="text-center">' +
                                '<div class="progress-task d-flex align-items-center">' +
                                    '<div class="progress flex-fill me-2" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">' +
                                        '<div class="progress-bar" style="width: <?= $value["Progress"] ?>%"></div>' +
                                    '</div>' +
                                    '<span class="progress-text text-start"><?= $value["Progress"] ?>%</span>' +
                                '</div>' +
                            '</td>' +
                        '</tr>'
                        });
                        // var tableData = $(response).find('#table-data').html();
                        // $("#table-data").html(tableData);
                        // customStatus();
                    },
                });
            }

            setInterval(fetchDataAndUpdate, 3000);
        })
    </script>
</div>