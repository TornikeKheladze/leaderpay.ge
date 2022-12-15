$(document).ready(function() {
    var $validator = $('#password').validate({
        errorElement: 'span',
        rules: {
            'currentPassword': {required: true},
            'repeatPassword': {equalTo: '#newPassword'},
            'newPassword': {minlength: 8, required: true, passwordCheck: true},
        },
        messages: {
            'newPassword': {
                'passwordCheck': 'პაროლი ძალიან სუსტია. პაროლი უნდა შეიცავდეს მინიმუმ 1 ციფრს 1 სიმბოლოს 1 uppercase!'
            }
        }
    });

});


$.validator.addMethod('passwordCheck', function(value) {
    return /[a-z]/.test(value)
        && /[A-Z]/.test(value)
        && /\d/.test(value)
        && /[=!\-@._*\$\#\%\^\&\(\)\~\`\<\>\/\?\\\|\{\}\[\]\;\:\'\"\,\+]/.test(value)
});