    <div class="sub-page-body clear-after">
        <div class="title clear-after">პირადი ინფორმაცია</div>
            <div class="col-md-12 mininfo">
                <div class="row">
                    <div class="col-md-4" style="display: none">
                        <div class="avatar-item" style="background: #4dd376;"></div>
                    </div>
                    <div class="col-md-8">
                    <?php if ($user['verify_id'] == 1) { ?>
                        <div class="caution">
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> გაფრთხილება!</b> თქვენი ანგარიში არ არის ვერიფიცირებული
                            <div class="close msg-colose" rel="#"></div>
                        </div>
                    <?php }  ?>
                    </div>
                </div> <!-- end row -->

                <div class="r">
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
                <br><br>
                <div class="r">
                    <a style="font-size: 11px;" href="assets/files/limits.pdf" target="_blank"><img src="assets/img/pdf.png" alt="pdf"> ტარიფებს და საოპერაციო ლიმიტებს</a>
                    <br><br>
                    <a style="font-size: 11px;" href="assets/files/privacy_policy.pdf" target="_blank"><img src="assets/img/pdf.png" alt="pdf"> პერსონალური ინფორმაცია და კონფიდენციალურობის პოლიტიკას</a>
                    <br><br>
                    <a style="font-size: 11px;" href="assets/files/contract.pdf" target="_blank"><img src="assets/img/pdf.png" alt="pdf"> ხელშეკრულებას ელექტრონული საფულეში რეგისტრაციასა და მის სარგებლობასთან დაკავშირებით</a>
                </div>

            </div>
        </div> <!-- end row -->
    </div>
