<?php
view('blocks.logins.header');
view('forgotten.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputEmail').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            var email = $("#InputEmail").val();
            if (email != '') {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailPattern.test(email)) {
                    $(".wrong-account").text("");
                } else {
                    $(".wrong-account").text("Định dạng email không hợp lệ.");
                }
            } else {
                $(".wrong-account").text("Vui lòng nhập email.");
            }
        });
    });
</script>