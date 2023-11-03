<?php

require 'classes/Qr.php';

$Qr = new Qr();

//$result = $Qr->init($user['id']);
$result = $Qr->init(25115);

?>

<link rel="stylesheet" type="text/css" href="assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css?<?=time() ?>"/>

<div class="title"><?=$lang['qr_title'] ?></div>
<div class="sub-page-body clear-after">

    <?php if (isset($result['errorCode']) && $result['errorCode'] == 10) { ?>

        <iframe
            src="https://api.apw.ge/ufc_qr/begin?token=<?=$result['token'] ?>"
            allow="camera"
            width="100%"
            height="600px"
            frameBorder="0"
            class="qr">
        </iframe>


    <?php } else { ?>

        <div class="msg msg-error" role="alert"><?=@$result['errorMessage'] ?></div>

    <?php } ?>

</div>

<script>

</script>