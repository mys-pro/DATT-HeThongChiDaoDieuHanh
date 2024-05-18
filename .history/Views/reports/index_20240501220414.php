<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $pageTitle ?></span>
    <div class="row g-0">
        <div class="col d-flex">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                <li class="filter-item me-2">
                    <select id="priority-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option value="all" selected>Tổng hợp</option>
                        <option value="made">Đã thực hiện</option>
                        <option value="unfulfilled">Chưa thực hiện</option>
                    </select>
                </li>

                <li class="filter-item me-2">
                    <select id="date-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option value="MONTH" selected>Năm này</option>
                        <option value="YEAR">Tháng này</option>
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
            <table class="table table-hover border shadow-sm mb-2">
                <thead>
                    <tr>
                        <th class="bg-body-secondary text-center" scope="col">#</th>
                        <th class="bg-body-secondary text-center" scope="col">First</th>
                        <th class="bg-body-secondary text-center" scope="col">Last</th>
                        <th class="bg-body-secondary text-center" scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th class="text-center" scope="row">1</th>
                        <td class="text-center">Mark</td>
                        <td class="text-center">Otto</td>
                        <td class="text-center">@mdo</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>