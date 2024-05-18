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
            <form action="<?= getWebRoot() ?>/dang-nhap" method="POST" class="form-login bg-white rounded-3">
                <div class="mb-4">
                    <h3 class="text-center ">Đăng nhập</h3>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" id="InputAccount1" placeholder="Nhập tài khoản" name = "account">
                </div>
                <div class="input-group mb-3 w-100">
                    <input type="password" class="form-control border-end-0" id="InputPassword1" placeholder="Nhập mật khẩu" name = "password">
                    <button class="btn-eye bg-transparent border border-start-0 rounded-end" type="button" id="button-addon2">
                        <i id="eye" class="bi bi-eye-slash"></i>
                    </button>
                </div>
                <div class="input-group mb-3 w-100">
                    <span class="text-center text-danger w-100 d-inline-block d-none">Tài khoản hoặc mật khẩu không đúng</span>
                </div>
                <button type="submit" class="btn btn-primary btn-login w-100 mb-3" name="login">ĐĂNG NHẬP</button>
                <a href="" class="w-100 text-center d-inline-block text-decoration-none">Quên mật khẩu?</a>
            </form>
        </div>
    </div>
</body>
</html>

<script>
    $(document).ready(function() {
        var report = <?= json_encode($report) ?>;
        $('#btn-filter-statistical').click(function() {
            var department = $('#department-filter').val();
            var date = $('#date-filter').val();
            var dateStart = 0;
            var dateEnd = 0;
            var toDate = $('#date-input').val().split(" to ");
            if ($('#date-input').val() != "") {
                if (toDate[0] != null) {
                    var dateTemp = toDate[0].split("-");
                    dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }

                if (toDate[1] != null) {
                    var dateTemp = toDate[1].split("-");
                    dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }
            }
            $.ajax({
                url: '<?= getWebRoot() ?>/ac/bao-cao',
                method: 'POST',
                data: {
                    department: department,
                    date: date,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                },
                success: function(response) {
                    report = JSON.parse(response);
                    console.log(report);
                    var htmlString = "";
                    var count = 0
                    report.forEach(value => {
                        count++;
                        var reviewerCheck = '';
                        if (value['Reviewer'] == 1) {
                            reviewerCheck = 'x';
                        }
                        htmlString += '<tr>\n' +
                            '<td class="text-center">' + count + '</td>\n' +
                            '<td class="text-center">' + value['TaskName'] + '</td>\n' +
                            '<td class="text-center">' + value['DepartmentName'] + '</td>\n' +
                            '<td class="text-center">' + reviewerCheck + '</td>' +
                            '<td class="text-center">' + value['DateCreated'] + '</td>\n' +
                            '<td class="text-center">' + value['ExpectedDate'] + '</td>\n' +
                            '<td class="text-center">' + value['Status'] + '</td>\n'; +
                        '</tr>';
                    });
                    $("#table-report > tbody").html(htmlString);
                },
            });
        });

        $('#Export-report').click(function() {
            var department = $('#department-filter').val();
            var date = $('#date-filter').val();
            var dateStart = 0;
            var dateEnd = 0;
            var toDate = $('#date-input').val().split(" to ");
            if ($('#date-input').val() != "") {
                if (toDate[0] != null) {
                    var dateTemp = toDate[0].split("-");
                    dateStart = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }

                if (toDate[1] != null) {
                    var dateTemp = toDate[1].split("-");
                    dateEnd = dateTemp[2] + "-" + dateTemp[1] + "-" + dateTemp[0];
                }
            }
            $.ajax({
                url: '<?= getWebRoot() ?>/PDF/report',
                method: 'POST',
                data: {
                    department: department,
                    date: date,
                    dateStart: dateStart,
                    dateEnd: dateEnd,
                },
                xhrFields: {
                    responseType: 'blob' // Xác định dạng dữ liệu nhận được là blob (file)
                },
                success: function(response) {
                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'BaoCao.pdf';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi khi gửi POST request:', error);
                }
            });
        });
    });
</script>