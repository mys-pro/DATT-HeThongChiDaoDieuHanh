<div class="sidebar shadow-sm offcanvas offcanvas-start p-3 d-flex flex-column border-0" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="sidebar__header d-flex position-relative me-2">
        <span class="text-black fs-5 fw-semibold">Quản lý công việc</span>
    </div>
    <hr class="me-2">

    <ul class="sidebar__content-list list-unstyled p-0 m-0">
        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() ?>/ac/thong-ke" class="rounded-3 text-decoration-none text-secondary d-block <?= getActiveMenu($active, 'statistical') ?>">
                <i class="bi bi-bar-chart me-3"></i>
                <span>Thống kê</span>
            </a>
        </li>

        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() ?>/ac/bao-cao" class="rounded-3 text-decoration-none text-secondary d-block <?= getActiveMenu($active, 'report') ?>">
                <i class="bi bi-file-text me-3"></i>
                <span>Báo cáo</span>
            </a>
        </li>

        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() ?>/ac/cong-viec" class="rounded-3 text-decoration-none text-secondary d-block <?= getDropdownList($active, 'task') ?> position-relative <?= getActiveMenu($active, 'task') ?>" data-bs-toggle="collapse" data-bs-target="#sidebarToggleExternalContent">
                <i class="bi bi-clipboard2-check me-3"></i>
                <span>Công việc</span>
                <i class="bi bi-caret-down-fill"></i>
            </a>

            <ul class="sidebar__dropdown collapse list-inline text-secondary <?= getDropdownItem($active, 'task') ?>" id="sidebarToggleExternalContent">
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=tat-ca" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(!isset($_REQUEST["v"]) || $_REQUEST["v"] == "tat-ca") echo "active" ?>">
                        Tất cả
                    </a>
                </li>
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=chua-hoan-thanh" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(isset($_REQUEST["v"]) && $_REQUEST["v"] == "chua-hoan-thanh") echo "active" ?>">
                        Chưa hoàn thành
                    </a>
                </li>
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=hoan-tat" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(isset($_REQUEST["v"]) && $_REQUEST["v"] == "hoan-tat") echo "active" ?>">
                        Hoàn tất
                    </a>
                </li>
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=cho-phe-duyet" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(isset($_REQUEST["v"]) && $_REQUEST["v"] == "cho-phe-duyet") echo "active" ?>">
                        Chờ phê duyệt
                    </a>
                </li>
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=tu-choi-phe-duyet" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(isset($_REQUEST["v"]) && $_REQUEST["v"] == "tu-choi-phe-duyet") echo "active" ?>">
                        Từ chối phê duyệt
                    </a>
                </li>
                <li class="sidebar__dropdown-item mt-2">
                    <a href="?v=du-thao" class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center <?php if(isset($_REQUEST["v"]) && $_REQUEST["v"] == "du-thao") echo "active" ?>">
                        Dự thảo
                    </a>
                </li>
            </ul>
        </li>

        <li class="sidebar__content-item mb-2">
            <a href="./approval.html" class="rounded-3 text-decoration-none text-secondary d-block">
                <i class="bi bi-folder-check me-3"></i>
                <span>Xét duyệt</span>
            </a>
        </li>
    </ul>

    <hr class="me-2">
    <div class="sidebar__footer me-2">
        <button type="button" class="bg-transparent overflow-hidden border-0 rounded-3 text-danger text-start w-100 py-2" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-box-arrow-left me-3"></i>
            <span>Đăng xuất</span>
        </button>
    </div>
</div>