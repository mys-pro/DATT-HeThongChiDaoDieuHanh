<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= getWebRoot() ?>/public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/material_blue.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= getWebRoot() ?>/public/css/Styles.css">
</head>

<body>
    <div class="app login-bg d-flex align-items-center">
        <div class="mx-auto">
            <div class="mb-3 d-flex flex-column align-items-center">
                <img class="header__navbar-img mb-2" src="<?= getWebRoot() ?>/public/Image/Logo.png" alt="" width="86px" height="86px">
                <div class="header__navbar-name mx-2 text-white text-center">
                    <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                    <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                </div>
            </div>
            <form class="form-login bg-white rounded-3">
                <div class="mb-4">
                    <h3 class="text-center ">Đăng nhập</h3>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Tên đăng nhập hoặc gmail">
                </div>
                <div class="input-group mb-4 w-100">
                    <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Mật khẩu">
                    <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
                        <i id="eye" class="bi bi-eye-slash"></i>
                        <!-- <i class="bi bi-eye show-pass d-none"></i> -->
                    </button>
                  </div>
                <button type="submit" class="btn btn-primary btn-login w-100 mb-3">ĐĂNG NHẬP</button>
                <a href="" class="w-100 text-center d-inline-block text-decoration-none">Quên mật khẩu?</a>
            </form>
        </div>
    </div>

    <!-- ============================================= script ============================================= -->
    <script src="<?= getWebRoot() ?>/public/js/flatpickr.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/jquery-3.7.1.min.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/chart-4.4.1.min.js"></script>
    <script src="<?= getWebRoot() ?>/bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= getWebRoot() ?>/public/js/script.js"></script>
</body>

</html>