<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/Image/icon.png" />
    <title>Hệ thống chỉ đạo điều hành</title>
    <link rel="stylesheet" href="../../public/css/material_blue.css">
    <link rel="stylesheet" href="../../bootstrap/bootstrap-icons-1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../bootstrap/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../public/css/Styles.css">
    <script src="../../public/js/flatpickr.js"></script>
    <script src="../../public/js/jquery-3.7.1.min.js"></script>
    <script src="../../public/js/chart-4.4.1.min.js"></script>
    <script src="../../bootstrap/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../public/js/script.js"></script>
</head>

<body>
    <div class="app login-bg d-flex align-items-center">
        <div class="mx-auto">
            <div class="mb-3 d-flex flex-column align-items-center">
                <img class="header__navbar-img mb-2" src="../../public/Image/Logo.png" alt="" width="86px"
                    height="86px">
                <div class="header__navbar-name mx-2 text-white text-center">
                    <h6 class="fw-bold p-0 m-0">UBND HUYỆN CHÂU THÀNH</h6>
                    <h6 class="fw-normal p-0 m-0">Hệ thống chỉ đạo điều hành</h6>
                </div>
            </div>
            <form class="form-login bg-white rounded-3">
                <div class="mb-4">
                    <h3 class="text-center ">Quên mật khẩu</h3>
                </div>
                <div class="mb-4">
                    <span class="text-center w-100 d-inline-block">Vui lòng nhập email để lấy mã xác nhận</span>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="InputUsername1" placeholder="Nhập email đăng nhập">
                </div>
                <div class="input-group mb-3 w-100">
                    <span class="wrong-account text-center text-danger w-100 d-inline-block d-none"></span>
                </div>
                <button type="button" class="btn btn-primary btn-login w-100 mb-3">Lấy lại mật khẩu</button>
                <a href="" class="w-100 text-center d-inline-block text-decoration-none">Quay lại đăng nhập</a>
            </form>
        </div>
    </div>
</body>

</html>