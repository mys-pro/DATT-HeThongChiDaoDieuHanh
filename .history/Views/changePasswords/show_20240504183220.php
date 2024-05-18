<?php
view('blocks.logins.header');
view('changePasswords.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputPassword1').keypress(function(event) {
            if (event.which === 13) {
                $('#InputPassword2').focus();
            }
        });

        $('#InputPassword2').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });
    });
</script>