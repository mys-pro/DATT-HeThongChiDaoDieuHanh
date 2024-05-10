<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $pageTitle ?></span>
    <div class="row g-0">
        <div class="col d-flex">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                <li class="filter-item me-2">
                    <select id="department-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option disabled selected hidden>Phòng ban</option>
                        <?php foreach($departmentFilter as $value): ?>
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
        </div>
    </div>

    <div class="row g-0">
        <div class="col">
            <table id="table-report" class="table table-striped border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="bg-body-secondary text-center" scope="col">STT</th>
                        <th class="bg-body-secondary text-center" scope="col">Tên công việc</th>
                        <th class="bg-body-secondary text-center" scope="col">Đơn vị thực hiện</th>
                        <th class="bg-body-secondary text-center" scope="col">Thẩm định</th>
                        <th class="bg-body-secondary text-center" scope="col">Thời gian bắt đầu</th>
                        <th class="bg-body-secondary text-center" scope="col">Thời gian dự kiến</th>
                        <th class="bg-body-secondary text-center" scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($report as $value) :
                        $count++;
                    ?>
                        <tr>
                            <td data-cell="STT" class="text-center border-0"><?= $count ?></td>
                            <td data-cell="Tên công việc" class="text-center border-0"><?= $value['TaskName'] ?></td>
                            <td data-cell="Đơn vị thực hiện" class="text-center border-0"><?= $value['DepartmentName'] ?></td>
                            <td data-cell="Thẩm định" class="text-center border-0"><?php if($value['Reviewer'] == 1) echo "x" ?></td>
                            <td data-cell="Thời gian bắt đầu" class="text-center border-0"><?= $value['DateCreated'] ?></td>
                            <td data-cell="Thời gian dự kiến" class="text-center border-0"><?= $value['ExpectedDate'] ?></td>
                            <td data-cell="Trạng thái" class="text-center border-0"><?= $value['Status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>