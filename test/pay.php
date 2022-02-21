<?php
    require_once "classes/billing.php";

    $billing=new billing();

    if (isset($_GET['id'])){
        $id=intval($_GET['id']);
    }else{
        header('Location: index.php');
    }

    $service=$billing->get_service($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pay</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        .bs-example{
            margin: 20px;
        }
    </style>
</head>
<body>
<div class="bs-example">
    <form>
        <div class="block" >
            <div class="col-sm-4">
                <div  style="margin-top: 20px;">
                    <input type="hidden" name="service_id" value="<?= $service['service']['id']?>">
                    <!-- ? ? ? -->
                    <h5><?php  echo $service['service']['name']?></h5><br>
                    <?php 
                        foreach ($service['service']['params_info'] as $params_info) {
                    ?>
                    <label for="<?= $params_info['name']?>"><?= $params_info['name']?></label>
                    <input type="text" name="<?= $params_info['name']?>" id="<?= $params_info['name']?>">
                        <?php
                        }
                        ?>
                    <button >Check</button>

                </div>

            </div>
        </div>
    </form>
</div>
</body>
</html>
