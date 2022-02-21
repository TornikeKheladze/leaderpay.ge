<div class="title"><?=$lang['settings'] ?></div>
<div class="sub-page-body col-md-12">
  <div class="col-md-12 setting">
    <input id='google_authenticator' name="google_authenticator" class='ios-switch' type='checkbox'>
    <label for='google_authenticator' class='ios-switch-label'></label>
    <span>ავტორიზება Google Authenticator-ით</span>
  </div>
  <div class="col-md-12 setting">
    <input id='sms_authenticator' checked name="sms_authenticator" class='ios-switch' type='checkbox'>
    <label for='sms_authenticator' class='ios-switch-label'></label>
    <span>ავტორიზება SMS-ით</span>
  </div>
  <div class="col-md-12" style="border-top: 1px solid #d3d3d3;padding-top: 20px;">
    <a href="#" onclick="iframe_popup('.popup','user/update.php?action=change_password');" style="color: #707070;border: 1px solid #b8b8b8;border-radius: 4px;padding: 6px;"><i class="fa fa-key" aria-hidden="true"></i> <?php echo $lang['change_password']; ?></a>
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
