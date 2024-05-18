</div>
</div>
</div>

<footer class="app__footer">
    <div class="container-xxl">
        <span class="text-white my-3 d-inline-block">© Copyright 2024 - Ngô Hồng Toại - 21072006050</span>
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

<div class="modal fade" id="modal-loading">
    <div class="modal-dialog modal-dialog-centered bg-transparent">
        <div class="modal-content">
            <div class="spinner spinner-border text-primary mx-auto" role="status"></div>
            <span class="text-center fs-6 fw-bold mt-3">Loading...</span>
        </div>
    </div>
</div>
</div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#logout').click(function() {
            window.location.href = '<?= getWebRoot() ?>/Login/logout';
        });


        <?php if (isset($_SESSION['Welcome']) && $_SESSION['Welcome'] === true) : ?>
            var welcomeToast = $('#welcomeToast');
            var toastBootstrap = bootstrap.Toast.getOrCreateInstance(welcomeToast);
            toastBootstrap.show();
            <?php unset($_SESSION['Welcome']); ?>
        <?php endif; ?>
    });
</script>