<div class="content w-100 px-2 overflow-hidden">
    <span class="text-black fs-5 p-3 d-inline-block fw-semibold"><?= $pageTitle ?></span>
    <div class="row g-0">
        <div class="col d-flex">
            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
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
        foreach ($statistical as $item) :
            $count++;
        ?>
            <div class="col">
                <canvas id="doughnutChart<?= $count ?>" class="bg-white p-2 shadow-sm w-100 h-100"></canvas>
            </div>
        <?php endforeach; ?>
    </div>
</div>