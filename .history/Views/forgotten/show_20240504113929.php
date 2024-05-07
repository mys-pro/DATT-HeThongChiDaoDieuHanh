<?php
view('blocks.logins.header');
view('forgotten.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputUsername1').keypress(function(event) {
            if (event.which === 13) {
                $('#InputPassword1').focus();
            }
        });

        $('#InputPassword1').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-login').click();
            }
        });

        $('.btn-login').click(function() {
            var username = $('#InputUsername1').val();
            var password = $('#InputPassword1').val();
        });
</script>