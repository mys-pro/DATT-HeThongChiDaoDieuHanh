<?php
    if(!isset($_SESSION["UserInfo"])) {
        header("Location:".getWebRoot());
    } else {
        $userInfo = $_SESSION["UserInfo"][0];
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= getWebRoot() ?>/Public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/material_blue.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/Styles.css">

    <script src="<?= getWebRoot() ?>/public/js/flatpickr.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/jquery-3.7.1.min.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/chart-4.4.1.min.js"></script>
    <script src="<?= getWebRoot() ?>/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/script.js"></script>
</head>

<body>
    <div class="app bg-body-tertiary">
        <header class="app__header position-fixed top-0 start-0 end-0 z-3">
            <nav class="header__navbar navbar">
                <div class="container-xxl">
                    <a class="btn-offcanvas rounded-circle text-white d-flex justify-content-center align-items-center me-2" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <i class="bi bi-list fs-5"></i>
                    </a>

                    <a href="<?= getWebRoot() ?>" class="header__navbar-logo navbar-brand p-0 d-flex me-auto overflow-hidden">
                        <img class="header__navbar-img" src="<?= getWebRoot() ?>/public/Image/Logo.png" alt="" width="40px" height="40px">
                        <div class="header__navbar-name mx-2 text-white d-flex flex-column justify-content-center">
                            <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                            <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                        </div>
                    </a>

                    <ul class="header__navbar-list-right list-inline p-0 m-0 d-flex align-items-center">
                        <li class="header__navbar-item">
                            <a class="rounded-circle d-inline-block w-100 h-100 text-white d-flex justify-content-center align-items-center" href="#">
                                <i class="bi bi-gear fs-5"></i>
                            </a>
                        </li>

                        <li class="header__navbar-item ms-2 position-relative">
                            <a class="rounded-circle d-inline-block w-100 h-100 text-white d-flex justify-content-center align-items-center" href="#" role="button" id="dropdown-apps">
                                <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                            </a>

                            <div class="list-apps z-3 bg-white rounded-3 position-absolute p-2 border border-1 hide">
                                <div class="row row-cols-3 g-2">
                                    <div class="col">
                                        <a href="<?= getWebRoot() ?>/ac/cong-viec" class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                            <img src="<?= getWebRoot() ?>/public/Image/task-icon.png" alt="" width="36px" height="36px">
                                            Công việc
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="<?= getWebRoot() ?>/kb/quan-tri-he-thong" class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                            <img src="<?= getWebRoot() ?>/public/Image/admin-icon.png" alt="" width="36px" height="36px">
                                            Hệ thống
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="header__navbar-item ms-2">
                            <img class="header__navbar-avatar rounded-circle" src="data:image/jpeg;base64,<?= base64_encode($userInfo["Avatar"]) ?>" alt="" width="36px" height="36px">
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="app__body">
            <div class="app__container container-xxl d-flex p-0">