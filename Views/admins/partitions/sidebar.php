<div class="sidebar shadow-sm offcanvas offcanvas-start p-3 d-flex flex-column border-0" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="sidebar__header d-flex position-relative me-2">
        <span class="text-black fs-5 fw-semibold">Quản trị hệ thống</span>
    </div>
    <hr class="me-2">

    <ul class="sidebar__content-list list-unstyled p-0 m-0">
        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() . "/kb/co-cau-to-chuc" ?>" class="rounded-3 text-decoration-none text-secondary d-block <?= $active == 'department' || $active == 'position' ? 'active' : '' ?>">
                <i class="bi bi-house me-3"></i>
                <span>Cơ cấu tổ chức</span>
            </a>
        </li>

        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() ?>/kb/nguoi-dung" class="rounded-3 text-decoration-none text-secondary d-block <?= getActiveMenu($active, 'user') ?>">
                <i class="bi bi-people me-3"></i>
                <span>Người dùng</span>
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