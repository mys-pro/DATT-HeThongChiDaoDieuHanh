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
                    $.ajax({
                        url: '<?= getWebRoot() ?>/quen-mat-khau',
                        method: 'POST',
                        data: {
                            email: email,
                        },
                        success: function(response) {
                            if (response == 'wrong') {
                                $('.wrong-account').text('Email không tồn tại trong hệ thống.');
                            } else {
                                if(response == 'fail') {
                                    $('.wrong-account').text('Lỗi hệ thống, vui lòng thử lại sau.');
                                } else {
                                    $('.wrong-account').text('');
                                    $verify = response;
                                    $.ajax({
                                        
                                    });
                                }
                            }
                        },
                    });
                } else {
                    $(".wrong-account").text("Định dạng email không hợp lệ.");
                }
            } else {
                $(".wrong-account").text("Vui lòng nhập email.");
            }
        });
    });
</script>