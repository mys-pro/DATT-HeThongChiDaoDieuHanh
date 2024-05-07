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
                <a href="<?= getWebRoot() ?>/User/logout" type="button" class="btn btn-danger">Đăng xuất</a>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>