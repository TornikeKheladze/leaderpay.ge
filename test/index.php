<?php
    require_once "classes/billing.php";
    $billing=new billing();
    $category=$billing->get_category();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Service</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="list-group">
        <a class="list-group-item " style="background-color: #5a6676; color: white;">სერვისის კატეგორიები</a>
        <?php
            if ($category['errorCode']==1000){
                foreach ($category['categories'] as $category) {
        ?>
                    <a href="service.php?id=<?php echo $category['id']?>" class="list-group-item"><?php echo $category['name_ge'] ?></a>
                <?php
                }
            }else{
                echo $category['errorMessage'];
            }

        ?>
    </div>
</div>
</body>
</html>