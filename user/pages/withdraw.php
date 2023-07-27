<?php
    $cards = $db->get_unlimited_list('cards', "is_deleted = '0' AND status_id = '1' AND personal_number = '$username'", 'created_at', 'DESC');

    $operationsPercent = $db->get_date('card_operations_percents', "id = '1'");

?>

<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css?<?=time() ?>"/>

<div class="title"><?=$lang['withdraw_title'] ?></div>
<div class="sub-page-body clear-after">
    <div class="row">
        <div class="col-md-12">
            <div class="loads"></div>
        </div>
        <div class="col-md-12 text-right">
            <button type="submit" class="g1-btn add_new_card" style="padding: 10px !important">
                <span><img src="assets/img/add.png?" alt=""> <?=$lang['add_new_card'] ?></span>
            </button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <?php if ($cards != false) {

                foreach($cards as $c) {
                    $expiry_year = substr( $c['expiry'], 0, 2);
                    $expiry_year = "20$expiry_year";
                    $expiry_month = substr( $c['expiry'], 2, 2);
                    $expiry = "$expiry_year-$expiry_month";
                    $current_y_m = date('Y-m');

                    ?>

                    <div class="card-item">

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <div class="t"><?=$c['type'] ?></div>
                                <div class="n"><span class="card_n"><?=$c['name'] ?></span> მოქმედების ვადა</div>
                                <div class="d <?=($current_y_m > $expiry) ? 'e' : '' ?>"><?=$expiry ?></div>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                                <form action="" method="post" class="withdraw-form">
                                    <input type="hidden" name="card_id" value="<?=$c['card_id'] ?>">
                                    <input type="text" name="amount" placeholder="თანხა" class="input float amount-in">
                                    <input type="text" name="generated" placeholder="ჩამოგეჭრებათ" class="input float generated-in" readonly="readonly">
                                    <button type="submit" class="g1-btn"><i class="fa fa-credit-card" aria-hidden="true"></i> <span><?=$lang['withdraw'] ?></span></button>
                                    <button type="button" class="g1-btn s-btn" rel="<?=$c['card_id'] ?>"><i class="fa fa-times" aria-hidden="true"></i> <span><?=$lang['delete'] ?></span></button>
                                </form>
                            </div>
                        </div>

                    </div>

                <?php } ?>
            <?php } else { ?>

                <div class="msg msg-danger">თქვენ არ გაქვთ დამახსოვრებული ბარათები!</div>

            <?php } ?>

        </div>
    </div>

</div>
<br>
<hr>
<br>
<div class="title clear-after">ოპერაციები</div>
<table id="datatable_ajax" class="table" cellspacing="0" width="min-width: 800px;">
    <thead>
        <tr>
            <th>სტატუსი</th>
            <th>ტიპი</th>
            <th>თანხა</th>
            <th><?=$lang['date'] ?></th>
            <th>საკომისიო</th>
        </tr>
        <tr role="row" class="filter">
            <td>
                <select name="status_id" id="status_id" class="form-control form-filter input-sm">
                    <option value="">ყველა</option>
                    <option value="1">რეგისტრირებული</option>
                    <option value="2">შესრულებული</option>
                    <option value="3">გაუქმებული</option>
                </select>
            </td>
            <td>
                <select name="type_id" id="type_id" class="form-control form-filter input-sm">
                    <option value="">ყველა</option>
                    <option value="2">თანხის გატანა</option>
                    <option value="1">ბარათის მიბმა</option>
                </select>
            </td>
            <td style="width: 20%;">
                <div style="width: 45%; float: left">
                    <input type="text" class="form-control form-filter input-sm" name="from_amount" autocomplete="off" placeholder="დან">
                </div>
                <div style="width: 45%; float: right">
                    <input type="text" class="form-control form-filter input-sm" name="to_amount" autocomplete="off" placeholder="მდე">
                </div>
            </td>
            <td style="width: 25%;">
                <div style="width: 45%; float: left">
                    <input type="text" class="form-control form-filter input-sm date-input" name="from_date" autocomplete="off" placeholder="დან">
                </div>
                <div style="width: 45%; float: right">
                    <input type="text" class="form-control form-filter input-sm date-input" name="to_date" autocomplete="off" placeholder="მდე">
                </div>
            </td>
            <td>
                <button type="button" class="btn btn-info btn-sm filter-submit" id="filter-submit"><i class="fa fa-search"></i></button>
            </td>
        </tr>
    </thead>
</table>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="text-align: center">გატანის დადასტურება
                    <button type="button" style="border: none;background: transparent;float: right;" data-dismiss="modal"><i style="font-size: 2em;color: #e71f1f;" class="fa fa-times-circle" aria-hidden="true"></i></button>
                </h5>
            </div>
            <div class="modal-body">
                <ul class="list">
                    <li class="clear">
                        <div class="col-md-5 li-block">ბაღათი</div>
                        <div class="col-md-7 li-block bill_n"></div>
                    </li>
                    <li class="clear">
                        <div class="col-md-5 li-block">თანხა</div>
                        <div class="col-md-7 li-block bill_a"></div>
                    </li>
                    <li class="clear">
                        <div class="col-md-5 li-block">საკომისიო</div>
                        <div class="col-md-7 li-block bill_c"></div>
                    </li>
                </ul>

                <div style="padding: 0 12px 0 12px">
                    <form action="" method="post" class="confirm-form">
                        <input type="hidden" id="f_card_id" value="">
                        <input type="hidden" id="f_amount" value="">
                        <ul class="list">
                            <li class="clear">
                                <div class="form-group">
                                    <label for="code">SMS-ით მიღებული კოდი</label>
                                    <input onkeypress="return isIntKey(event);" data-rule-required="true" maxlength="6" minlength="6" type="txt" id="sms_code" class="gen_code input" autocomplete="off">
                                </div>
                            </li>
                        </ul>
                        <button type="submit" class="g1-btn btn-b confirm_pay" name="submit"><i class="fa fa-check"></i> დადასტურება</button>
                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- datatable-->
<script type="text/javascript" src="assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>

<script src="assets/plugins/datatables/datatable.js?<?=time() ?>"></script>
<script src="assets/pages/operations.js?<?=time() ?>"></script>

<script>

    jQuery(document).ready(function() {
        TableAjax.init();
        $('.form-filter').blur(function() {
            $('#filter-submit').trigger('click');
        });
        $('.form-filter').change(function() {
            $('#filter-submit').trigger('click');
        });
    });

    $('.withdraw-form').on('keyup', '.amount-in', function() {

        var amount = $(this).val();

        var percent = <?=$operationsPercent['percent'] ?>;
        var min_commision = <?=$operationsPercent['min_commision'] ?>;

        var countpercent = (percent / 100) * amount;
        var commision = (countpercent > min_commision) ? countpercent : min_commision;

        var generated = parseFloat(amount) + parseFloat(commision);

        if (isNaN(generated)) {
            generated = 0;
        }

        $(this).next().val(generated.toFixed(2));

    });

    $(document).on('click', '.s-btn', function(e) {

        if (confirm('<?=$lang['delete_question'] ?>')) {

            var card_id = $(this).attr('rel');

            $.ajax({
                type: 'POST',
                url: 'loads/withdraw.php?action=deleteCard',
                data: {card_id: card_id},
                dataType: 'json',
                success: function(data) {
                    if (data.errorCode == 1) {

                        $(".s-btn[rel='" + card_id +"']").closest('.card-item').remove();
                        $('.loads').html('<div class="msg msg-succses" role="alert"><?=$lang['delete_success'] ?></div>');
                    } else {

                        $('.loads').html('<div class="msg msg-error" role="alert">' + data.errorMessage + '</div>');
                    }
                }

            });

        }

    });
    $(document).on('click', '.add_new_card', function(e) {

        window.location.replace("https://leaderpay.ge/loads/withdraw.php?action=addNewCard");

    });

    $('.withdraw-form').submit(function(e) {
        e.preventDefault();

        $('input').removeClass('er');

        var card_id = $(this).children('input[name="card_id"]').val();
        var amount = $(this).children('input[name="amount"]').val();
        var generated = $(this).children('input[name="generated"]').val();
        var expiry = $(this).parent().parent().find('.e');

        if (amount < <?=$operationsPercent['min_amount'] ?>) {

            popup('მინიმალური გასატანი თანხა შეადგენს <?=$operationsPercent['min_amount'] ?> ლარს');

            $(this).children('input[name="amount"]').addClass('er');
            return false;

        }

        if (amount > <?=$operationsPercent['max_amount'] ?>) {

            popup('მაქსიმალური გასატანი თანხა შეადგენს <?=$operationsPercent['max_amount'] ?> ლარს!');

            $(this).children('input[name="amount"]').addClass('er');
            return false;

        }

        if (expiry.length) {

            popup('ბარათი ვადაგასულია!');
            return false;

        }

        if (generated > <?=$user['balance'] ?>) {

            popup('თქვენს ანგარიშზე არ არის საკმარისი თანხა ტრანზაქციის განსახორციელებლად!');
            return false;

        }

        $('.loads').empty();
        $.ajax({
            type: 'POST',
            url: 'loads/withdraw.php?action=sms',
            data: {card_id: card_id, amount: amount},
            dataType: 'json',
            success: function(data) {
                if (data.errorCode == 1) {

                    $('.bill_a').html(amount);
                    $('.bill_c').html(data.data.commision);
                    $('.bill_n').html(data.data.card_name);

                    $('#f_card_id').val(data.data.card_id);
                    $('#f_amount').val(amount);


                    $('#withdraw').modal('show');

                } else {
                    $('.loads').html('<div class="msg msg-error" role="alert">' + data.errorMessage + '</div>');

                }
            }

        });
    });

    $(document).on('click', '.s-btn', function(e) {

        if (confirm('<?=$lang['delete_question'] ?>')) {

            var card_id = $(this).attr('rel');

            $.ajax({
                type: 'POST',
                url: 'loads/withdraw.php?action=deleteCard',
                data: {card_id: card_id},
                dataType: 'json',
                success: function(data) {
                    if (data.errorCode == 1) {

                        $(".s-btn[rel='" + card_id +"']").closest('.card-item').remove();
                        $('.loads').html('<div class="msg msg-succses" role="alert"><?=$lang['delete_success'] ?></div>');
                    } else {

                        $('.loads').html('<div class="msg msg-error" role="alert">' + data.errorMessage + '</div>');
                    }
                }

            });

        }

    });

    $('.confirm-form').submit(function(e) {
        e.preventDefault();

        var card_id = $('#f_card_id').val();
        var amount = $('#f_amount').val();
        var sms = $('#sms_code').val();

        if (sms.length != 6) {
            popup('sms კოდი არასწორია!');
            return false;
        }

        $('.loads').empty();
        $.ajax({
           type: 'POST',
           url: 'loads/withdraw.php?action=withdraw',
           data: {card_id: card_id, amount: amount, sms: sms},
           dataType: 'json',
           success: function(data) {

               $('#withdraw').modal('hide');

               if (data.errorCode == 1) {

                   $('.loads').html('<div class="msg msg-succses" role="alert">' + data.errorMessage + '</div>');

                   $('input').val('');
                   $('#filter-submit').trigger('click');

               } else {
                   $('.loads').html('<div class="msg msg-error" role="alert">' + data.errorMessage + '</div>');

               }
           }

        });

    });
</script>