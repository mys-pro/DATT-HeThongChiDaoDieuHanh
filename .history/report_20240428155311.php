<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet" href="./public/css/material_blue.css">
    <link rel="stylesheet" href="./bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/Styles.css">
</head>

<body>
    <div class="app bg-body-tertiary">
        <header class="app__header position-fixed top-0 start-0 end-0 z-3">
            <nav class="header__navbar navbar">
                <div class="container-xxl">
                    <a class="btn-offcanvas rounded-circle text-white d-flex justify-content-center align-items-center me-2"
                        data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                        aria-controls="offcanvasExample">
                        <i class="bi bi-list fs-5"></i>
                    </a>

                    <a href="./index.html" class="header__navbar-logo navbar-brand p-0 d-flex me-auto overflow-hidden">
                        <img class="header__navbar-img" src="./public/Image/Logo.png" alt="" width="40px" height="40px">
                        <div class="header__navbar-name mx-2 text-white d-flex flex-column justify-content-center">
                            <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                            <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                        </div>
                    </a>

                    <ul class="header__navbar-list-right list-inline p-0 m-0 d-flex align-items-center">
                        <li class="header__navbar-item">
                            <a class="rounded-circle d-inline-block w-100 h-100 text-white d-flex justify-content-center align-items-center"
                                href="#">
                                <i class="bi bi-gear fs-5"></i>
                            </a>
                        </li>

                        <li class="header__navbar-item ms-2">
                            <a class="rounded-circle d-inline-block w-100 h-100 text-white d-flex justify-content-center align-items-center"
                                href="#" role="button" id="dropdown-apps">
                                <i class="bi bi-grid-3x3-gap-fill fs-5"></i>
                            </a>

                            <div class="list-apps z-3 bg-white rounded-3 position-absolute p-2 border border-1 hide">
                                <div class="row row-cols-3 g-2">
                                    <div class="col">
                                        <a href="#"
                                            class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                            <img src="./public/Image/task-icon.png" alt="" width="36px" height="36px">
                                            Công việc
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a href="#"
                                            class="text-decoration-none text-secondary d-flex flex-column align-items-center px-1 py-2 rounded-3">
                                            <img src="./public/Image/admin-icon.png" alt="" width="36px" height="36px">
                                            Hệ thống
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="header__navbar-item ms-2">
                            <div
                                class="header__navbar-avatar bg-success bg-gradient rounded-circle w-100 h-100 text-white d-flex justify-content-center align-items-center">
                                TN
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <div class="app__body">
            <div class="app__container container-xxl d-flex p-0">
                <div class="sidebar shadow-sm offcanvas offcanvas-start p-3 d-flex flex-column border-0" tabindex="-1"
                    id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                    <div class="sidebar__header d-flex position-relative me-2">
                        <span class="text-black fs-5 fw-semibold">Quản lý công việc</span>
                    </div>
                    <hr class="me-2">

                    <ul class="sidebar__content-list list-unstyled p-0 m-0">
                        <li class="sidebar__content-item mb-2">
                            <a href="./statistical.html" class="rounded-3 text-decoration-none text-secondary d-block">
                                <i class="bi bi-bar-chart me-3"></i>
                                <span>Thống kê</span>
                            </a>
                        </li>

                        <li class="sidebar__content-item mb-2">
                            <a href="./report.html"
                                class="rounded-3 text-decoration-none text-secondary d-block active">
                                <i class="bi bi-file-text me-3"></i>
                                <span>Báo cáo</span>
                            </a>
                        </li>

                        <li class="sidebar__content-item mb-2">
                            <a href="./index.html"
                                class="rounded-3 text-decoration-none text-secondary d-block collapsed position-relative"
                                data-bs-toggle="collapse" data-bs-target="#sidebarToggleExternalContent">
                                <i class="bi bi-clipboard2-check me-3"></i>
                                <span>Công việc</span>
                                <i class="bi bi-caret-down-fill"></i>
                            </a>

                            <ul class="sidebar__dropdown collapse list-inline text-secondary"
                                id="sidebarToggleExternalContent">
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="./index.html"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
                                        Tất cả
                                    </a>
                                </li>
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="#"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
                                        Hoàn tất
                                    </a>
                                </li>
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="#"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
                                        Bị hủy
                                    </a>
                                </li>
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="#"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
                                        Chờ phê duyệt
                                    </a>
                                </li>
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="#"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
                                        Từ chối phê duyệt
                                    </a>
                                </li>
                                <li class="sidebar__dropdown-item mt-2">
                                    <a href="#"
                                        class="text-secondary text-decoration-none rounded-3 d-block d-flex justify-content-between align-items-center">
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
                        <button type="button"
                            class="bg-transparent overflow-hidden border-0 rounded-3 text-danger text-start w-100 py-2"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-left me-3"></i>
                            <span>Đăng xuất</span>
                        </button>
                    </div>
                </div>

                <div class="content w-100 px-2 overflow-hidden">
                    <span class="text-black fs-5 p-3 d-inline-block fw-semibold">Báo cáo</span>
                    <div class="row g-0">
                        <div class="col">
                            <ul class="filter-list list-unstyled m-0 p-2 d-flex position-relative">
                                <li class="filter-item me-2">
                                    <select id="priority-filter"
                                        class="w-auto form-select text-secondary bg-transparent border-secondary">
                                        <option value="low">Tổng hợp</option>
                                        <option value="medium">Đã hoàn thành</option>
                                        <option value="hight">Chưa hoàn thành</option>
                                    </select>
                                </li>

                                <li class="filter-item me-2">
                                    <select id="date-filter"
                                        class="w-auto form-select text-secondary bg-transparent border-secondary">
                                        <option value="month" selected>Tháng này</option>
                                        <option value="year">Năm này</option>
                                        <option value="option">Tùy chọn</option>
                                    </select>
                                </li>

                                <li id="date-item" class="filter-item me-2 d-none">
                                    <div class="input-group">
                                        <input id="date" type="text"
                                            class="form-control text-secondary border-end-0 bg-transparent border-secondary"
                                            placeholder="Thời gian" aria-label="date-filter">
                                        <label for="date"
                                            class="input-group-text text-secondary border-start-0 bg-transparent border-secondary">
                                            <i class="bi bi-calendar-event-fill"></i>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="row g-0">
                        <div class="col">
                            <!-- <div class="report-document mb-2">
                                <div class="report-document__toolbar"></div>
                                <div class="report-document__container">
                                    <div class="report-document__editor">
                                        <p style="margin-left:80px;text-align:center;"><span style="font-family:'Times New Roman', Times, serif;"><strong>UBND HUYỆN CHÂU THÀNH &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</strong></span></p>
                                        <p style="margin-left:80px;text-align:center;"><span style="font-family:'Times New Roman', Times, serif;"><strong>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Độc lập - Tự do - Hạnh phúc</strong></span></p>
                                    </div>
                                </div>
                            </div> -->
                            <object data="./pdf.php" width="100%" height="720px"></object> 
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="app__footer">
            <div class="container-xxl">
                <span class="text-white my-3 d-inline-block">© Copyright 2024 - Ngô Hồng Toại</span>
            </div>
        </footer>

        <div class="modal" tabindex="-1" id="logoutModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Đăng xuất</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Bạn có chắc chắn muốn đăng xuất?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Quay
                            lại</button>
                        <button type="button" class="btn btn-danger">Đăng xuất</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================= script ============================================= -->
    <script src="./public/js/flatpickr.js"></script>
    <script src="./public/ckeditor/ckeditor.js"></script>
    <script src="./public/js/chart-4.4.1.min.js"></script>
    <script src="./public/js/jquery-3.7.1.min.js"></script>
    <script src="./bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="./public/js/script.js"></script>
</body>

</html>