<?php
  $currencies = $db->get_unlimited_list("currencies"," id > 0","id","DESC");
 ?>
 
<div class="title"><?php echo $lang['send_money']; ?></div>
<div class="sub-page-body clear-after">
  <form id="transfer" action="loads/transfer.php" rel="info" method="post" autocomplete="off">
    <div class="form-group col-md-12">
      <label for="to"><?php echo $lang['receiverc_number']; ?></label>
      <input onkeypress="return isIntKey(event);" maxlength="11" type="text" name="to" id="to" class="input" autocomplete="off">
      <input type="hidden" name="from" id="from" value="<?php echo $user['personal_number']; ?>">
    </div>
    <div class="load_labels" style="display: none">
      <div class="form-group col-md-12">
        <label for="currency_id" style="display: block;"><?php echo $lang['currency']; ?></label>
        <select name="currency_id" id="currency_id" class="input select2me"  style="max-width: 100%">
          <?php foreach ($currencies as $c) { ?>
            <option value="<?php echo $c['id']; ?>"><?php echo $c['title']; ?></option>
          <?php } //endforeach; ?>
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="amount"><?php echo $lang['amount']; ?></label>
        <input type="text" name="amount" id="amount" class="input" value="" placeholder = "შეიტანეთ თანხა">
      </div>
      <div class="form-group col-md-12">
        <label for="com"><?php echo $lang['commission'] ?></label>
        <input name="com" type="number"  id="com" class="input"  value ="" autocomplete="off">
      </div>
      <div class="form-group col-md-12">
        <label for="generated">ჩამოგეჭრებათ</label>
        <input name="generated" type="number" id="generated" class="input" value="" autocomplete="off">
      </div>
    </div>
    <div class="form-group col-md-12 text-right">
      <hr>
      <button type="submit" class="g1-btn transfer">
        <span style="visibility: visible;"><?php echo $lang['send_money']; ?></span>
      </button>
    </div>
  </form>
</div>

<!-- validation -->
<script type="text/javascript" src="./assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="./assets/plugins/jquery-validation/js/localization/messages_ge.js"></script>
<script>
  $(document).ready(function(){
    var form = $('#transfer');
      form.validate({
         focusInvalid: false, // do not focus the last invalid input
         errorElement: 'span',
         rules: {
           currency_id: {
             required: true,
             number: true,
           },
           to: {
             required: true,
             minlength: 11,
             maxlength: 11,
             number: true,
            },
           amount: {
             required: true,
             number: true
            }
           },
            onkeyup: function(element) {
              // console.log(element);
              $(element).valid();
              simple_comission();
            },
           submitHandler: function (form) {
             transfers(form, 11);
             // console.log(form); // console log forms
             return false; // required to block normal submit since you used ajax
           },
       });
  });

</script>

