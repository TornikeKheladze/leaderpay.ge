<div class="sub-page-body clear-after">
  <!-- <div class="caution">
    <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> გაფრთხილება!</b> თქვენი ანგარიში არ არის ვერიფიცირებული
    <div class="close msg-colose" rel="#"></div>
  </div> -->
  <div class="col-md-12 <?php if(!isset($_GET['aa'])) { echo "none"; } ?>">


    <div class="title clear-after">პირადი ინფორმაცია</div>
    <div class="row">
      <div class="col-md-8 mininfo">
        <div class="row">
          <div class="col-md-4">
              <div class="avatar-item">
                <?php

                  if ($user['image'] == 1) {

                    $avatar = 'user/upload/avatar/'.$user['avatar'];

                  } else {

                    $avatar = 'assets/img/ku.png';

                  }

                 ?>
                <img class="" src="<?php echo $avatar; ?>">
              </div>
              <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_avatar');" class="get-popup change_avatar_btn">ავატარის შეცვლა</a>
          </div>
          <div class="col-md-8">
            <div class="caution">
              <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> გაფრთხილება!</b> თქვენი ანგარიში არ არის ვერიფიცირებული
              <div class="close msg-colose" rel="#"></div>
            </div>
          </div>

        </div> <!-- end row -->

        <div class="r ">
          <div class="item clear">
            <div class="col-md-6">
              <span><?php echo $lang['first_name']; ?>:</span>
            </div>
            <div class="col-md-6">
              <h6><?php echo $user['first_name']; ?></h6>
            </div>
          </div>
          <div class="item clear">
            <div class="col-md-6">
              <span><?php echo $lang['last_name']; ?>:</span>
            </div>
            <div class="col-md-6">
              <h6><?php echo $user['last_name']; ?></h6>
            </div>
          </div>
          <div class="item clear">
            <div class="col-md-6">
              <span><?php echo $lang['wallet_number']; ?>:</span>
            </div>
            <div class="col-md-6">
              <h6><?php echo $user['personal_number']; ?></h6>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
      </div>
    </div> <!-- end row -->
    <div class="row">
      <div class="col-md-12">
        <div class="images-c clear">
          <div class="up-item">
            <label for="fileinput">
              <div class="icon"></div>
              ატვირთე დოკუმენტი <input type="file" class="fileinput" name="fileinput" id="fileinput">
            </label>
          </div>
          <div class="up-item" style="display: none;">
            <div class="img-result">
              <div class="remove"></div>
              <img src="" alt="">
            </div>
          </div>
        </div>
        <a href="#" class="btn btn-gradiet btn-center drop" rel="personal_infos_table"> <i class="fa fa-pencil-square-o"></i> პირადი ინფორმაციის რედაქტირება</a>
      </div><!-- end col -->
    </div><!-- end row -->
  </div> <!-- end col-md-12 -->
  <div class="col-md-12 pinfo-header ">

    <?php if ($user['verify_id'] == 1) { ?>

      <a href="https://apw.ge/verification.php" class="verif-btn no toltip" aria-label="თქვენი ანგარიში არ არის ვერიფიცირებული"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> დაუმოწმებელი</a>

    <?php } elseif ($user['verify_id'] == 2) { ?>

      <a href="" class="verif-btn yes toltip" aria-label="თქვენი ანგარიში იდენტიფიცირებული"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> იდენტიფიცირებული</a>

    <?php } elseif ($user['verify_id'] == 3) { ?>

      <a href="" class="verif-btn yes toltip" aria-label="თქვენი ანგარიში ვერიფიცირებული"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> ვერიფიცირებული</a>

    <?php } ?>

    <div class="profile_info">

        <?php

          // if ($user['image'] == 1) {
          //
          //   $avatar = $user['avatar'];
          //
          // } else {
          //
          //   $avatar = 'assets/img/ku.png';
          //
          // }
          $avatar = 'assets/img/ku.png';

         ?>

        <div class="profile-image" style="background: url('<?php echo $avatar; ?>') no-repeat top center">
        </div>
        <h2><?php echo $user['first_name']; ?> <?php echo $user['last_name']; ?></h2>
        <h3><?php echo $user['personal_number']; ?></h3>
    </div>
  </div>
  <div class="col-md-12 simple-border " id="personal_infos_table">
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['first_name']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['first_name']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3  text-right">
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['last_name']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['last_name']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">

        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p>სქესი: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span>
            <?php
                $gender = array(
                  1 => 'მამრობითი',
                  2 => 'მდედრობითი',
                );

                echo $gender[$user['gender']];

            ?>
          </span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_gender');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
          <div class="col-md-2 col-sm-2 col-xs-2">
              <p>sms ბალანსის შევსების დროს: </p>
          </div>
          <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span>
            <?php
                $sms = [1 => 'კი', 0 => 'არა'];

                echo $sms[$user['deposit_sms']];
            ?>
          </span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-3 text-right">
              <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_sms');" class="get-popup">
                  <img src="assets/img/edit.png" alt="edit">
                  <span class="edit"><?php echo $lang['update']; ?></span>
              </a>
          </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['email']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['email']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_email');" class="get-popup" >
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['place_of_birth']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['birth_place']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_birth_place');" class="get-popup" >
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['date_of_birth']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['birth_date']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_birth_date');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end inf-item div -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['personal_number']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['personal_number']; ?></span>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['legal_address']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['legal_address']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_legal_address');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['real_address']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['real_address']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_real_address');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['document_number']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['passport_number']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_passport_number');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['passport_registration_date']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['issue_date']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_issue_date');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['passport_valid']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['expiry_date']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_expiry_date');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
      </div> <!-- end  inf-itemdiv -->
      <div class="col-md-12 inf-item clear">
        <div class="col-md-2 col-sm-2 col-xs-2">
          <p><?php echo $lang['telephone_number']; ?>: </p>
        </div>
        <div class="col-md-8 col-sm-6 col-xs-6 text-right">
          <span><?php echo $user['mobile']; ?></span>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-3 text-right">
          <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_phone');" class="get-popup">
            <img src="assets/img/edit.png" alt="edit">
            <span class="edit"><?php echo $lang['update']; ?></span>
          </a>
        </div>
     </div>
    </div> <!-- end inf-item div -->
  </div>
</div>

<script>

  function iframeLoaded() {
    var iFrameID = document.getElementById('if');
    if(iFrameID) {
          // here you can make the height, I delete it first, then I make it again
          iFrameID.height = "";
          iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight +50+ "px";
      }
  }

</script>
<!-- main popup -->
<div class="popup" style="display: none;">
  <div class="pupup-content">
    <div class="close-p"></div>
    <div id="iframe" style="display: block;"><iframe id="if" onload="iframeLoaded()" frameborder="none" src=""></iframe></div>
  </div>
</div>
<!-- End main popup -->
<script>

  $('.close-p').click(function() {
    location.reload();
  })

</script>
