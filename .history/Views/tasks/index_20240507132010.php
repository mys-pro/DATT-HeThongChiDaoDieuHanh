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
                        <th class="bg-body-secondary text-center" scope="col">Tên công việc</th>
                        <th class="bg-body-secondary text-center" scope="col">Đơn vị thực hiện</th>
                        <th class="bg-body-secondary text-center" scope="col">Thẩm định</th>
                        <th class="bg-body-secondary text-center" scope="col">Thời gian bắt đầu</th>
                        <th class="bg-body-secondary text-center" scope="col">Thời gian dự kiến</th>
                        <th class="bg-body-secondary text-center" scope="col">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-cell="STT" class="text-center"></td>
                        <td data-cell="Tên công việc" class="text-center"></td>
                        <td data-cell="Đơn vị thực hiện" class="text-center"></td>
                        <td data-cell="Thẩm định" class="text-center"></td>
                        <td data-cell="Thời gian bắt đầu" class="text-center"></td>
                        <td data-cell="Thời gian dự kiến" class="text-center"></td>
                        <td data-cell="Trạng thái" class="text-center"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>