<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $pageTitle ?></span>
    <div class="row g-0">
        <div class="col">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                <li class="filter-item me-2">
                    <select id="priority-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option value="all" selected>Tổng hợp</option>
                        <option value="1">Đã thực hiện</option>
                        <option value="2">Chưa thực hiện</option>
                    </select>
                </li>

                <li class="filter-item me-2">
                    <select id="date-filter" class="w-auto form-select text-secondary bg-transparent border-secondary">
                        <option value="month" selected>Tháng này</option>
                        <option value="year">Năm này</option>
                        <option value="option">Tùy chọn</option>
                    </select>
                </li>

                <li id="date-item" class="filter-item me-2 d-none">
                    <div class="input-group">
                        <input id="date" type="text" class="form-control text-secondary border-end-0 bg-transparent border-secondary" placeholder="Thời gian" aria-label="date-filter">
                        <label for="date" class="input-group-text text-secondary border-start-0 bg-transparent border-secondary">
                            <i class="bi bi-calendar-event-fill"></i>
                        </label>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>