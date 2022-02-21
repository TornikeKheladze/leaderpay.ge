
<div class="title clear-after">
  <?php echo $lang['transactions'];  ?>
  <!-- <div class="title-btns fr text-right">
    <button type="button" class="btn btn-default btn-m" rel="all"><i class="fa fa-globe" aria-hidden="true"></i> ყველა</button>
    <button type="button" class="btn btn-default btn-m" rel="minus"><i class="fa fa-minus" aria-hidden="true"></i> გასავალი</button>
    <button type="button" class="btn btn-default btn-m" rel="plus"><i class="fa fa-plus" aria-hidden="true"></i> შემოსავალი</button>
  </div> -->
</div>

<div class="sub-page-body">
  <form class="transactions_filter" action="loads/transactions.php" method="post">
    <div class="row">
      <div class="col-md-4">
        <p class="title">თარიღის ფილტრი</p>
        <div class="input-daterange input-group" id="datepicker">
          <input type="text" class="input-sm form-control trans-filter-item date-input" name="from_date" placeholder="დან" autocomplete="off">
          <span class="input-group-addon"></span>
          <input type="text" class="input-sm form-control trans-filter-item date-input" name="to_date" placeholder="მდე" autocomplete="off">
        </div>
      </div>
      <div class="col-md-2">
      </div>
      <div class="col-md-4">
        <p class="title">თანხის ფილტრი</p>
        <div class="input-daterange input-group" id="datepicker">
          <input type="text" class="input-sm float form-control trans-filter-item" name="from_amount" placeholder="დან" autocomplete="off">
          <span class="input-group-addon"></span>
          <input type="text" class="input-sm float form-control trans-filter-item" name="to_amount" placeholder="მდე" autocomplete="off">
        </div>
      </div>
      <div class="col-md-2">
        <a href="#" class="reset_filter"> <img src="assets/img/reset.png" alt="reset"> გაუქმება</a>
      </div>
    </div>
  </form>
  <div class="transactions-list overflow-auto">
    <table class="table table-responsive table-hover table-striped toggle" id="TableAjax">
      <thead>

          <tr>
            <td>
              <?php echo $lang['date'];  ?><br>
            </td>
            <td><?php echo $lang['name'];  ?></td>
            <!-- <td><?php echo $lang['status'];  ?></td> -->
            <td>
              <?php echo $lang['money'];  ?><br>
            </td>
            <!-- <td><?php echo $lang['comission'];  ?></td> -->
            <td><?php echo $lang['balance'];  ?></td>
          </tr>

        </form>
      </thead>
      <tbody class="transactions_load">

      </tbody>
    </table>
  </div>
  <div class="text-center">
    <a href="#" class="more_t g1-btn" rel="10"> <i class="fa fa-angle-down"></i> მეტის ნახვა</a>
  </div>
</div>
