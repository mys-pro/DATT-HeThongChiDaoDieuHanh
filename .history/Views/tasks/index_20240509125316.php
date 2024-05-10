<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $pageTitle ?></span>
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
            <table id="table-report" class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="bg-body-secondary text-center" scope="col">STT</th>
                        <th class="bg-body-secondary text-start" scope="col">Tên công việc</th>
                        <th class="bg-body-secondary text-start" scope="col">Tình trạng</th>
                        <th class="bg-body-secondary text-center" scope="col">Ngày giao việc</th>
                        <th class="bg-body-secondary text-center" scope="col">Hạn hoàn thành</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($taskList as $index => $value): ?>
                        <tr>
                            <td data-cell="STT" class="text-center"><?= $index + 1 ?></td>
                            <td data-cell="Tên công việc" class="text-start"><?= $value["TaskName"] ?>123123123123dasdasdasd áda</td>
                            <td data-cell="Tình trạng" class="text-start"><?= $value["Status"] ?></td>
                            <td data-cell="Ngày giao việc" class="text-center"><?= empty($value["DateCreated"]) ? $value["DateStart"] : $value["DateCreated"]; ?>
                            </td>
                            <td data-cell="Hạn hoàn thành" class="text-center"><?= $value["Deadline"] ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>