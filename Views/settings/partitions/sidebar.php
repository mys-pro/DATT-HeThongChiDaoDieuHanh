<div class="sidebar shadow-sm offcanvas offcanvas-start p-3 d-flex flex-column border-0" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="sidebar__header d-flex position-relative me-2">
        <span class="text-black fs-5 fw-semibold">Thiết lập</span>
    </div>
    <hr class="me-2">

    <ul class="sidebar__content-list list-unstyled p-0 m-0">
        <li class="sidebar__content-item mb-2">
            <a href="<?= getWebRoot() . "/thiet-lap/thong-tin-ca-nhan" ?>" class="rounded-3 text-decoration-none text-secondary d-block <?= getActiveMenu($active, 'userInfo') ?>">
                <i class="bi bi-person-vcard me-3"></i>
                <span>Thông tin cá nhân</span>
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