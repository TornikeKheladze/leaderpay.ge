<?php
  require_once('includes/head.php');

  //
  $active = 'register';
  $page_title = $lang['verification'];

  if ($db->check_auch() === false) {
    header('Location: index.php');
  }

  include 'includes/header.php';


?>

  <div class="container page">
    <div class="row">
      <div class="col-md-12">
        <div class="page-bg fluid clear">
          <h3 class="page-title">
            <span class="t r"><?=$lang['verification'] ?></span>
          </h3>
          <div class="msg msg-danger">რეგისტრაცია დროებით გათიშულია!</div>
          <div class="vr" style="display: none;">
            <iframe
                src=""
                allow="camera"
                width="100%"
                height="800px"
                frameBorder="0"
                class="identomat">
            </iframe>
            <input type="hidden" name="iToken" id="iToken" value="">
          </div>

        </div><!-- end page-bg -->
      </div><!-- end col -->
    </div><!-- end row -->

  </div><!-- end container -->

<?php
  $page_script = '<script src="assets/pages/verification.js?' . time() . '"></script>';

  include 'includes/footer.php';
?>
