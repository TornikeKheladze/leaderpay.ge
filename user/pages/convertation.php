<?php
    $currencies = $db->get_unlimited_list('currencies', '1', 'id', 'DESC');
?>

<div class="title"><?=$lang['convertation'] ?></div>
<div class="sub-page-body clear-after">
    <form id="exchange" action="loads/transfer.php" rel="info" method="post" autocomplete="off">
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-5">
                <select name="from_currency" id="from_currency" class="c-select select2-container select2me">
                    <?php foreach ($currencies as $c) { ?>
                        <option value="<?=$c['id'] ?>"><?=$c['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2"></div>
            <div class="col-md-5 col-sm-5 col-xs-5">
                <select name="to_currency" id="to_currency" class="c-select select2-container select2me">
                    <?php foreach ($currencies as $c) { ?>
                        <option id="<?=$c['id'] ?>" value="<?=$c['id'] ?>" <?=($c['id'] == 840) ? 'selected' : '' ?>><?=$c['title'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-5 col-sm-5 col-xs-5">
                <input type="text" name="from_amount" id="from_amount" class="float input" value="1.00" placeholder="შეიტანეთ თანხა">
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2">
                <span class="end-c"><?=$lang['from'] ?></span>
                <div class="loader-d"></div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-5">
                <input type="text" name="to_amount" id="to_amount" class="input" value="0.00" disabled="disabled" style="background: transparent; border: 3px solid #f1f1f1;">
                <span class="currency-span"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="error-span"></div>
            </div>
        </div>
        <div class="form-group col-md-12 text-center">
            <hr>
            <button type="submit" class="g1-btn exchange">
                <span style="visibility: visible;"><?=$lang['exchange'] ?></span>
            </button>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {

        $('#from_currency').on('change', function() {

            if (this.value != 981) {

                $('#to_currency').val(981).change();
            } else {
                $('#to_currency').val(840).change();

            }
        });

        getRate();
        $('#from_amount').keyup(function() {
            getRate();
        });
        $('.c-select').on('change', function() {
            getRate();
        });

        function getRate() {

            $('.loader-d').html('<div class="convert-loader"></div>');

            var amount = $('#from_amount').val();
            var from = $('#from_currency').val();
            var to = $('#to_currency').val();

            $.ajax({
                type: 'GET',
                url: 'loads/convertation.php',
                data: {method: 'rate', from: from, to: to, amount: amount},
                dataType: 'json',
                success: function(data) {

                    setTimeout(function() {

                        $('.convert-loader').remove();
                        $('.error-span').empty();
                        $('#from_amount').css({'border' : 'none'})

                        if (data.errorCode == 10) {

                            $('.currency-span').html(data.data.amount + ' ' + data.data.from + ' = ' + parseFloat(data.data.rate).toFixed(2) + ' ' + data.data.to);
                            $('#to_amount').val(parseFloat(data.data.rate).toFixed(2));

                        } else if (data.errorCode == 1) {

                            $('#from_amount').css({'border' : '1px solid #ff1818'});

                        } else if (data.errorCode == 2) {

                            $('.error-span').html(data.errorMessage);

                        }


                    }, 1000);

                }
            });

        }

        $("#exchange").submit(function(e){
            e.preventDefault();
            convertation();
            $(this).find("button[type='submit']").prop('disabled', true);
        });

        function convertation() {

            $('.loader-d').html('<div class="convert-loader"></div>');

            var amount = $('#from_amount').val();
            var from = $('#from_currency').val();
            var to = $('#to_currency').val();

            $.ajax({
                type: 'GET',
                url: 'loads/convertation.php',
                data: {method: 'convertation', from: from, to: to, amount: amount},
                dataType: 'json',
                success: function(data) {

                    setTimeout(function() {

                        $('.convert-loader').remove();
                        $('.error-span').empty();

                        if (data.errorCode == 10) {

                            $('.error-span').html("<div class='msg msg-succses' role='alert'>" + data.errorMessage + "</div>");
                            setTimeout(function() {
                                location.reload();
                            }, 3000);

                        } else {

                            $('.error-span').html("<div class='msg msg-error' role='alert'>" + data.errorMessage + "</div>");

                        }

                    }, 1000);

                }
            });

        }


    });

</script>