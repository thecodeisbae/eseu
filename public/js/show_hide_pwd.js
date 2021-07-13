$(function() {
    $('#disp').on('click', function(event) {
        event.preventDefault();
        if ($('#pwd').attr("type") == "text") {
            $('#pwd').attr('type', 'password');
            $('#eye').removeClass("fa-eye");
            $('#eye').addClass("fa-eye-slash");
        } else if ($('#pwd').attr("type") == "password") {
            $('#pwd').attr('type', 'text');
            $('#eye').removeClass("fa-eye-slash");
            $('#eye').addClass("fa-eye");
        }
    });
});