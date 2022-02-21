<?php
    require_once "classes/billing.php";

    $billing=new billing();
    if (isset($_GET['id'])){
        $id=intval($_GET['id']);
    }else{
        header('Location: index.php');
    }

    $services=$billing->get_services($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Services</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <style>

    </style>
</head>
<body>

<div class="container">
    <div class="list-group">
        <a class="list-group-item " style="background-color: #5a6676; color: white;">სერვისები</a>
        <?php
            if ($services['errorCode']==1000){
                foreach ($services['services'] as $services){
        ?>
                    <a href="pay.php?id=<?php $services['id'] ?>"class="list-group-item"><?php echo $services['name']?> </a>
                    <?php
                }
            }else{
                echo $services['errorMessage'];
            }
        ?>
    </div>
</div>
</body>
</html>