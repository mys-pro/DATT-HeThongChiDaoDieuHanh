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
            var emailPattern = <?php echo "//^[^\s@]+@[^\s@]+\.[^\s@]+$//" ?>;
            alert(emailPattern.test(email));
            if (emailPattern.test(email)) {
                
            } else {
                $(".wrong-account").text("Email không hợp lệ.");
            }
        });
    });
</script>