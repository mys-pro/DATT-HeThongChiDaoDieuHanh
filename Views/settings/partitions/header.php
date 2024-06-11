<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= getWebRoot() ?>/Public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet" href="<?= getWebRoot() ?>/library/bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/material_blue.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/library/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/select2.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/select2-bootstrap-5-theme.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/Styles.css?v=<?= time() ?>">

    <script src="<?= getWebRoot() ?>/public/js/jquery-3.7.1.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/flatpickr.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/library/ckeditor5-build-classic/ckeditor.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/select2.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/chart-4.4.1.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/library/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/script.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/pusher.min.js?v=<?= time() ?>"></script>
</head>

<body>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="welcomeToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Xin chào, <?= $_SESSION["UserInfo"][0]["FullName"] ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="#toast-notify">
        <div id="toast-notify-content" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center text-break">

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="app bg-body-tertiary">
        <nav class="navbar navbar-expand fixed-top">
            <div class="container-xxl">
                <a class="btn-offcanvas rounded-circle text-white d-flex justify-content-center align-items-center me-2" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                    <i class="bi bi-list fs-5"></i>
                </a>

                <a href="<?= getWebRoot() ?>/ac/cong-viec" class="header__navbar-logo navbar-brand p-0 d-flex me-auto overflow-hidden">
                    <img class="navbar-img" src="<?= getWebRoot() ?>/public/Image/Logo.png" alt="" width="40px" height="40px">
                    <div class="navbar-name mx-2 text-white d-flex flex-column justify-content-center">
                        <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                        <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                    </div>
                </a>

                <div class="navbar-right ms-auto flex-grow-0">
                    <ul class="navbar-nav p-0 m-0 flex-row align-items-center">
                        <li class="nav-item"><a class="nav-link rounded-circle text-white d-flex justify-content-center align-items-center" href="<?= getWebRoot() . "/thiet-lap/thong-tin-ca-nhan" ?>"><i class="bi bi-gear fs-5"></i></a></li>

                        <li id="dropdown-notify" class="nav-item dropdown ms-2">
                            <a id="dropdown-notify-btn" class="nav-link dropdown-toggle rounded-circle text-white d-flex justify-content-center align-items-center" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                <?php if ($quantityNotify != 0) : ?>
                                    <span class="position-absolute top-0 start-50 badge rounded-pill bg-danger">
                                        <?= $quantityNotify < 99 ? $quantityNotify : "99+" ?>
                                    </span>
                                <?php endif; ?>
                            </a>

                            <div id="dropdown-notify-box" class="dropdown-menu mt-2">
                                <h5 class="text-center">Thông báo</h5>
                                <hr class="m-0 my-2">
                                <ul id="dropdown-notify-list" class="ps-2">
                                </ul>
                            </div>
                        </li>

                        <li id="dropdown-apps" class="nav-item dropdown ms-2">
                            <a class="nav-link rounded-circle text-white dropdown-toggle d-flex justify-content-center align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="100,0">
                                <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                            </a>
                            <ul id="dropdown-apps-list" class="dropdown-menu mt-2 py-2 pe-2">
                                <li class="ps-2">
                                    <a href="<?= getWebRoot() ?>/ac/cong-viec" class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                        <img src="<?= getWebRoot() ?>/public/Image/task-icon.png" alt="" width="36px" height="36px">
                                        Công việc
                                    </a>
                                </li>
                                <?php if (checkRole($_SESSION["Role"], 6)) : ?>
                                    <li class="ps-2">
                                        <a href="<?= getWebRoot() ?>/kb/quan-tri-he-thong" class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                            <img src="<?= getWebRoot() ?>/public/Image/admin-icon.png" alt="" width="36px" height="36px">
                                            Hệ thống
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <li class="nav-item ms-2">
                            <img class="header__navbar-avatar rounded-circle" src="data:image/jpeg;base64,<?= base64_encode($_SESSION["UserInfo"][0]["Avatar"]) ?>" alt="" width="36px" height="36px">
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="app__body">
            <div class="app__container container-xxl d-flex p-0">