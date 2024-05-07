<?php
view('blocks.logins.header');
view('forgotten.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputUsername1').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').focus();
            }
        });

        $('.btn-submit').click(function() {
            var email = $('#email').val();
            var regex = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
            if (regex.test(email)) {
                $('#result').text('Địa chỉ email hợp lệ và là địa chỉ Gmail.');
            } else {
                $('#result').text('Địa chỉ email không hợp lệ hoặc không phải là địa chỉ Gmail.');
            }
        });
    });
</script>