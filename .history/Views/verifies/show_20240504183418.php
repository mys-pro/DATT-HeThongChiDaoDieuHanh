<?php
view('blocks.logins.header');
view('verifies.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#VerifyInput').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            $verifyInput = $('#VerifyInput').val();
            if($verifyInput == '') {
                $('.wrong-account').text('Vui lòng nhập mã xác nhận.');
            } else {
                $('.wrong-account').text('');
            }
        });
    });
</script>