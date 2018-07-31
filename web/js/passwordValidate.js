/** Password validation **/
$(document).ready(function () {
    let passwordInput = $("input.validate-password"),
        password_repeatInput = $("input.validate-password_repeat"),
        button = $(".submit-btn"),
        errorBlock = $(".password-error_message");

    passwordInput.keyup(function (e) {
        let passwordValue = passwordInput.val(),
            password_repeatValue = password_repeatInput.val();
        validatePasswords(passwordValue, password_repeatValue);
    });
    password_repeatInput.keyup(function (e) {
        let passwordValue = passwordInput.val(),
            password_repeatValue = password_repeatInput.val();
        validatePasswords(passwordValue, password_repeatValue);
    });

    function validatePasswords(password, password_repeat) {
        button.hide();
        // console.log('password: ',password);
        // console.log('password_repeat: ',password_repeat);
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
        button.show();
        return true;
    }
});