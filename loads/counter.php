<?php
// header("Refresh:0");
require '../classes/config.php';
require '../classes/db.php';
$db = new db();
?>
<script>
  ///
  $(".count_a").lettering();
  ///
</script>

<?php

  if (isset($_GET['operations'])) {

    echo "<div class='count_a'>".$db->table_count("user_balance_history"," `id` > 0 ")."<div>";

  } else if(isset($_GET['users'])) {

    echo "<div class='count_a'>".$db->table_count("users"," `id` > 0 ")."<div>";

  } else {

    echo "0";

  }

 ?>
