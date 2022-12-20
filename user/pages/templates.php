    <?php
        require 'classes/Billing.php';
        $Billing = new Billing($db, 'Wallet');

        $lng = strtoupper($lang_id);

    ?>
    <div class="title">ჩემი შაბლონები</div>
    <div class="sub-page-body">
        <div class="loads"></div>
        <ul class="list">
            <li class="clear head">
                <div class="col-md-2 li-block" title="ლოგო">ლოგო</div>
                <div class="col-md-3 li-block" title="სახელი">სახელი</div>
                <div class="col-md-2 li-block" title="აბონენტი">აბონენტი</div>
                <div class="col-md-2 li-block" title="დავალიანება">დავალიანება</div>
                <div class="col-md-3 li-block text-right">მოქმედება</div>
            </li>
            <div class="load_carts">

                <?php

                    $personal_number = $user['personal_number'];

                    $services = $db->getListSql("SELECT * FROM save_service WHERE user_id = '$personal_number' ORDER BY created_at DESC");

                    if (!$services) { ?>

                        <div class="caution" style="color: #6a6a6a; border: 1px dashed #4e4e4e; border-radius: 5px;">
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> თქვენ არ გაქვთ შენახული შაბლონები
                            <div class="close msg-colose" rel="#"></div>
                        </div>

                    <?php }

                    $timeOut = 0;
                    foreach($services as $s) {

                        $timeOut += 2000;

                        $json = json_decode($s['json']);

                        $service = $Billing->service($s['service_id']);
                        $service = @$service['service'];

                        $key = @key($json);

                        ?>

                        <li class="clear">
                            <div class="col-md-2 li-block">
                                <img src="https://uploads.allpayway.ge/files/services/<?=$service['image'] ?>" class="img-responsive" alt="<?=$service['lang'][$lng] ?>">
                            </div>
                            <div class="col-md-3 li-block"><?=$service['lang'][$lng] ?></div>
                            <div class="col-md-2 li-block"><?=$json->$key ?></div>
                            <div class="col-md-2 li-block" id="loadFor_<?=$s['service_id'] ?>">
                                <img src="assets/img/loading.gif" class="img-responsive" alt="<?=$service['lang'][$lng] ?>">
                            </div>
                            <div class="col-md-3 li-block text-right">
                                <form action="pay.php?step=2&id=<?=$s['service_id'] ?>" method="post">
                                    <?php foreach($json as $k => $v) { ?>

                                        <input type="hidden" name="<?=$k ?>" value="<?=$v ?>">

                                    <?php } ?>
                                    <button type="submit" class="g1-btn" style="padding: 5px 20px 5px 20px !important;"><span>გადახდა</span></button>
                                    <button type="button" class="g1-btn s-btn" rel="<?=$s['id'] ?>" style="padding: 3px 10px 3px 10px !important;"><i class="fa fa-times" aria-hidden="true"></i> <span>წაშლა</span></button>
                                </form>
                            </div>
                        </li>

                        <script>

                            $(document).ready(function() {

                                setTimeout(function() {

                                    $.ajax({
                                        type: 'POST',
                                        url: 'loads/payByWallet.php?action=info',
                                        data: <?=$s['json'] ?>,
                                        dataType: 'json',
                                        success: function(data) {

                                            var debt = "<span class='plus'>" + parseFloat(data.debt) + "</span>";
                                            if (parseFloat(data.debt) < 0) {

                                                var debt = "<span class='minus'>" + parseFloat(data.debt) + "</span>";

                                            }

                                            if (parseFloat(data.credit) > 0) {

                                                var debt = "<span class='plus'>" + parseFloat(data.credit) + "</span>";

                                            }

                                            $("#loadFor_" + "<?=$s['service_id'] ?>").html(debt);

                                        }

                                    });

                                }, <?=$timeOut ?>);


                            });

                        </script>

                    <?php } ?>

            </div>
        </ul>

    </div>

    <script>
        $(document).on('click', '.s-btn', function(e) {

            if (confirm('ნამდვილად გსურთ გაუქმება?')) {

                var id = $(this).attr('rel');

                $(this).closest('.clear').remove();

                $.ajax({
                    type: 'POST',
                    url: 'loads/payByWallet.php?action=deleteService',
                    data: {id: id},
                    dataType: 'json',
                    success: function(data) {
                        $('.loads').html('<div class="msg msg-succses" role="alert">წარმატებით წაიშალა</div>');

                    }

                });

            }


        });
    </script>