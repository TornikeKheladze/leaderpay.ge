
    $.ajax({
        type: 'POST',
        url: 'loads/registration.php',
        data: {'verification': 1},
        dataType: 'json',
        success: function(data) {

            setTimeout(function() {

                if (data.errorCode == 10) {

                    $('.identomat').attr('src', 'https://widget.identomat.com/?session_token=' + data.data.session);
                    $('#iToken').val(data.data.session);

                } else {

                    var errorMsg = '<div class="msg msg-error">';
                    errorMsg += data.errorMessage;
                    errorMsg += '</div>';
                    $('.vr').html(errorMsg);

                }

            }, 3000);
        }  // success
    }); // ajax

    addEventListener('message', function (e) {

        if (e.origin !== 'https://widget.identomat.com') return;
        if (e.data !== 'DONE') return;

        var token = $('#iToken').val();
        $.ajax({
            type: 'POST',
            url: 'loads/registration.php',
            data: {'verification': 2, 'iToken': token},
            dataType: 'json',
            success: function(data) {

                setTimeout(function() {

                    if (data.errorCode == 10) {

                        var errorMsg = '<div class="msg msg-succses">';
                        errorMsg += data.errorMessage;
                        $('.vr').html(errorMsg);

                    } else {

                        var errorMsg = '<div class="msg msg-error">';
                        errorMsg += data.errorMessage;
                        $('.vr').html(errorMsg);

                    }

                }, 3000);
            }  // success
        }); // ajax

    });
