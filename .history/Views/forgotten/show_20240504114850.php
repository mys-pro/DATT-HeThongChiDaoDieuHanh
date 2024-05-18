<?php
view('blocks.logins.header');
view('forgotten.index');
view('blocks.logins.footer');
?>

<script>
    $(document).ready(function() {
        $('#InputUsername1').keypress(function(event) {
            if (event.which === 13) {
                $('.btn-submit').click();
            }
        });

        $('.btn-submit').click(function() {
            var email = $('#InputUsername1').val();
            alert(email);
            var regex = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
            if (regex.test(email)) {

            } else {
                $('.wrong-account').text('Đinh dạng email không hợp lệ.');
            }
        });
    });
</script>