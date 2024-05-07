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
                $('.btn-forgot').click();
            }
        });

        $('.btn-forgot').click(function() {
            
        });
    });
</script>