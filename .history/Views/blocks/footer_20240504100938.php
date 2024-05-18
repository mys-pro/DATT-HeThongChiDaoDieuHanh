<?php
    $welcome = false;
    if(isset($_SESSION['Welcome']) && $_SESSION['Welcome'] === true) {
        $welcome = $_SESSION;
        unset($_SESSION['show_welcome']);
    }
?>

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
                <button id="logout" type="button" class="btn btn-danger">Đăng xuất</button>
            </div>
        </div>
    </div>
</div>
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="welcomeToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <img src="<?= getWebRoot() ?>/Public/Image/icon.png" class="rounded me-2" alt="...">
            <strong class="me-auto">Hệ thống</strong>
            <!-- <small>11 mins ago</small> -->
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Hello, world! This is a toast message.
        </div>
    </div>
</div>
</div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#logout').click(function() {
            window.location.href = '<?= getWebRoot() ?>/User/logout';
        });

        var welcome = <?= $welcome ?>;
        if (welcome) {
            var toastLiveExample = document.getElementById('liveToast')
            var toast = new bootstrap.Toast(toastLiveExample)
            toast.show()
        }
    });
</script>