/** Password validation **/
$(document).ready(function () {
    let passwordInput = $("input.validate-password"),
        password_repeatInput = $("input.validate-password_repeat"),
        button = $(".submit-btn"),
        errorBlock = $(".password-error_message");

     passwordInput.keyup(validatePasswords);
     password_repeatInput.keyup(validatePasswords);

    passwordInput.bind('paste', function(){
      validatePasswords();
    });
    password_repeatInput.bind('paste', function(){
      validatePasswords();
    });

    function validatePasswords() {
        let password = passwordInput.val(),
            password_repeat = password_repeatInput.val();
        button.hide();
        let res = {};
        if (password.length < 8) {
            errorBlock.text("Password must contain at least 8 characters.");
            return false;
        }
        if (password !== password_repeat) {
            errorBlock.text("Passwords don't match");
            return false;
        }
        let regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

        if (!regex.test(password)) {
            errorBlock.text("Password must contain at least one lower and upper case character and a digit.");
            return false;
        }
        errorBlock.text("");
        
        if($('#check').prop('checked')) {
            button.slideDown();
            return true;
        }
        return false;
    }

    if(!$('#check').prop('checked')) {
        button.hide();
    }
    
    $("#check").change(function() {
        if(this.checked) {
           
            if(validatePasswords()){
                $(".submit-btn").slideDown();
            }
        } else {
            $(".submit-btn").slideUp();
        }
        
    });
});
