<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= getWebRoot() ?>/public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet"
        href="<?= getWebRoot() ?>/library/bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/material_blue.css?v=<?= time() ?>">
    <link rel="stylesheet"
        href="<?= getWebRoot() ?>/library/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/select2.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/select2-bootstrap-5-theme.min.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/Styles.css?v=<?= time() ?>">

    <script src="<?= getWebRoot() ?>/public/js/jquery-3.7.1.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/flatpickr.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/library/ckeditor5-build-classic/ckeditor.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/select2.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/chart-4.4.1.min.js?v=<?= time() ?>"></script>
    <script
        src="<?= getWebRoot() ?>/library/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/script.js?v=<?= time() ?>"></script>
    <script src="<?= getWebRoot() ?>/public/js/pusher.min.js?v=<?= time() ?>"></script>
</head>

<body>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="login-toast" class="toast align-items-center border-0" role="alert" aria-live="assertive"
            aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="toast-body__icon fs-2 lh-1"></i>
                    <span class="toast-body__text">Thành công</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <div class="app login-bg d-flex align-items-center">
        <div class="mx-auto">
            <div class="mb-3 d-flex flex-column align-items-center">
                <img class="header__navbar-img mb-2" src="<?= getWebRoot() ?>/public/Image/Logo.png" alt="" width="86px"
                    height="86px">
                <div class="header__navbar-name mx-2 text-white text-center">
                    <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                    <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                </div>
            </div>