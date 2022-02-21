<?php

  session_start();


  require_once('../classes/config.php');
  require_once('../classes/db.php');
  require_once('../classes/sms.php');

  $db = new db();

  $sms = new sms();

  // check user
  if ($db->check_auch() === true) {

    // get user info
    $username = $_SESSION["user_name"];
    $token = $_SESSION["token"];
    $user = $db->get_date("users"," `personal_number` = '".$username."' AND `token` = '".$token."' ");

  } else {

    die();

  }


 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>apw.ge - რედაქტირება</title>
    <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel="stylesheet" href="../assets/plugins/intl-tel-input/intlTelInput.css">
    <link rel="stylesheet" href="../assets/css/style.css?<?php echo time(); ?>">
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>

    <style>
      @font-face {
        font-family: 'title-bold';
        src: url('../assets/fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.eot');
        src: url('../assets/fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.eot') format('embedded-opentype'),
             url('../assets/fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.woff2') format('woff2'), url('../fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.woff') format('woff'),
             url('../assets/fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.ttf') format('truetype'), url('../fonts/DejaVuNeueCaps-Bold/DejaVuNeueCaps-Bold.svg') format('svg');
      }

      @font-face {
        font-family: 'title';
        src: url('../assets/fonts/DejaVuNeueCaps/DejaVuNeueCaps.eot');
        src: url('../assets/fonts/DejaVuNeueCaps/DejaVuNeueCaps.eot') format('embedded-opentype'),
             url('../assets/fonts/DejaVuNeueCaps/DejaVuNeueCaps.woff2') format('woff2'), url('../fonts/DejaVuNeueCaps/DejaVuNeueCaps.woff') format('woff'),
             url('../assets/fonts/DejaVuNeueCaps/DejaVuNeueCaps.ttf') format('truetype'), url('../fonts/DejaVuNeueCaps/DejaVuNeueCaps.svg') format('svg');
      }
      .date-row {
        margin: 0;
      }
      .up-item {
        width: 80px !important;
        height: 80px;
      }
    </style>
  </head>
  <body>

    <?php

    // dates
    $year_array = array(
      "2040" => "2040",
      "2039" => "2039",
      "2038" => "2038",
      "2037" => "2037",
      "2036" => "2036",
      "2035" => "2035",
      "2034" => "2034",
      "2033" => "2033",
      "2032" => "2032",
      "2031" => "2031",
      "2030" => "2030",
      "2029" => "2029",
      "2028" => "2028",
      "2027" => "2027",
      "2026" => "2026",
      "2025" => "2025",
      "2024" => "2024",
      "2023" => "2023",
      "2022" => "2022",
      "2021" => "2021",
      "2020" => "2020",
      "2019" => "2019",
      "2018" => "2018",
      "2017" => "2017",
      "2016" => "2016",
      "2015" => "2015",
      "2014" => "2014",
      "2013" => "2013",
      "2012" => "2012",
      "2011" => "2011",
      "2010" => "2010",
      "2009" => "2009",
      "2008" => "2008",
      "2007" => "2007",
      "2006" => "2006",
      "2005" => "2005",
      "2004" => "2004",
      "2003" => "2003",
      "2002" => "2002",
      "2001" => "2001",
      "2000" => "2000",
      "1999" => "1999",
      "1998" => "1998",
      "1997" => "1997",
      "1996" => "1996",
      "1995" => "1995",
      "1994" => "1994",
      "1993" => "1993",
      "1992" => "1992",
      "1991" => "1991",
      "1990" => "1990",
      "1989" => "1989",
      "1988" => "1988",
      "1987" => "1987",
      "1986" => "1986",
      "1985" => "1985",
      "1984" => "1984",
      "1983" => "1983",
      "1982" => "1982",
      "1981" => "1981",
      "1980" => "1980",
      "1979" => "1979",
      "1978" => "1978",
      "1977" => "1977",
      "1976" => "1976",
      "1975" => "1975",
      "1974" => "1974",
      "1973" => "1973",
      "1972" => "1972",
      "1971" => "1971",
      "1970" => "1970",
      "1969" => "1969",
      "1968" => "1968",
      "1967" => "1967",
      "1966" => "1966",
      "1965" => "1965",
      "1964" => "1964",
      "1963" => "1963",
      "1962" => "1962",
      "1961" => "1961",
      "1960" => "1960",
      "1959" => "1959",
      "1958" => "1958",
      "1957" => "1957",
      "1956" => "1956",
      "1955" => "1955",
      "1954" => "1954",
      "1953" => "1953",
      "1952" => "1952",
      "1951" => "1951",
      "1950" => "1950",
      "1949" => "1949",
      "1948" => "1948",
      "1947" => "1947",
      "1946" => "1946",
      "1945" => "1945",
      "1944" => "1944",
      "1943" => "1943",
      "1942" => "1942",
      "1943" => "1941",
      "1940" => "1940",
      "1939" => "1939",
      "1938" => "1938",
      "1937" => "1937",
      "1936" => "1936",
      "1935" => "1935",
      "1934" => "1934",
      "1933" => "1933",
      "1932" => "1932",
      "1931" => "1931",
      "1930" => "1930",
      "1929" => "1929",
      "1928" => "1928",
      "1927" => "1927",
      "1926" => "1926",
      "1925" => "1925",
      "1924" => "1924",
      "1923" => "1923",
      "1922" => "1922",
      "1921" => "1921",
      "1920" => "1920",
      "1919" => "1919",
      "1918" => "1918",
      "1917" => "1917",
      "1916" => "1916",
      "1915" => "1915",
      "1914" => "1914",
      "1913" => "1913",
      "1912" => "1912",
      "1911" => "1911",
      "1910" => "1910",
      "1909" => "1909",
      "1908" => "1908",
      "1907" => "1907",
      "1906" => "1906",
      "1905" => "1905",
    );
    $month_array = array(
      "01" => "იანვარი",
      "02" => "თებერვალი",
      "03" => "მარტი",
      "04" => "აპრილი",
      "05" => "მაისი",
      "06" => "ივნისი",
      "07" => "ივლისი",
      "08" => "აგვიოსტო",
      "09" => "სექტემბერი",
      "10" => "ოქტომბერი",
      "11" => "ნოემბერი",
      "12" => "დეკემბერი",
    );
    $day_array = array(
      "01" => "1",
      "02" => "2",
      "03" => "3",
      "04" => "4",
      "05" => "5",
      "06" => "6",
      "07" => "7",
      "08" => "8",
      "09" => "9",
      "10" => "10",
      "11" => "11",
      "12" => "12",
      "13" => "13",
      "14" => "14",
      "15" => "15",
      "16" => "16",
      "17" => "17",
      "18" => "18",
      "19" => "19",
      "20" => "20",
      "21" => "21",
      "22" => "22",
      "23" => "23",
      "24" => "24",
      "25" => "25",
      "26" => "26",
      "27" => "27",
      "28" => "28",
      "29" => "29",
      "30" => "30",
      "31" => "31",
    );



      if (isset($_GET['action'])) {

        $action = $_GET['action'];

        if ($action == 'change_avatar') {

          if (isset($_POST['submit'])) {

            // upload
            $extensions = array("png","PNG","jpg","jpge");

            // delete old image
            $image_name = trim($user['avatar']);

            if ($image_name != '' && $image_name != null) {

              if (file_exists("upload/avatar/".$image_name)) {

                unlink("upload/avatar/".$image_name);

              }

              $image_upload = $db->image_upload("avatar","upload/avatar/",$_FILES,$extensions);

            } else {

              $image_upload = $db->image_upload("avatar","upload/avatar/",$_FILES,$extensions);

            }


            if ($image_upload != false) {

              $image = $image_upload;

              $params = array(
                  "image" => 1,
                  "avatar" => $image,
              );

              $avatar_change = $db->update("users", $params, $user["id"]);

              if ($avatar_change == true) {
                ?>

                  <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                    ავატარი წარმატებით შეიცვალა
                  </div>

                <?php

                $avatar_change = true;
              }

            }  else {

              ?>
              <div class="msg msg-error">
                ავატარის ცვლილება ვერ განხორციელდა
              </div>
              <?php

              $avatar_change = false;


            }


          }



          ?>
          <form  method="post" class="up-form <?php echo (isset($avatar_change)) ? 'none' : ''; ?>" id="avatar" enctype="multipart/form-data">
            <h3 class="text-center" style="font-family: 'title'">ავატარის შეცვლა</h3>
            <div class="form-group req">
              <div class="images-c clear">
                <div class="up-item">
                  <label for="fileinput">
                    <div class="icon"></div>
                    ატვირთე დოკუმენტი <input type="file" class="fileinput" name="avatar" id="fileinput">
                  </label>
                </div>
                <div class="up-item" style="display: none;">
                  <div class="img-result">
                    <div class="remove"></div>
                    <img src="" alt="">
                  </div>
                </div>
              </div>
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_password') {

            if (isset($_POST['submit'])) {

              $old_password = $user['password'];
              $curent_password = hash('sha256', $_POST['curent_password']);
              $new_password = hash('sha256', $_POST['new_password']);
              $repeat_password = hash('sha256', $_POST['repeat_password']);

              if ($old_password == $curent_password) {

                if ($new_password == $repeat_password) {

                  $params = array(
                      "password" => $new_password
                  );

                  $update_password = $db->update("users", $params, $user["id"]);

                  if ($update_password == true) {
                    ?>

                      <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                        პაროლი წარმატებით შეიცვალა
                      </div>

                    <?php

                    $password_change = true;
                  }


                } else {

                  ?>
                  <div class="msg msg-error">
                    გამეორებული პაროლი არასწორია
                  </div>
                  <?php

                }

              } else {

                ?>
                <div class="msg msg-error">
                  მიმდინარე პაროლი არასწორია
                </div>
                <?php

              }

            }
          ?>
          <form  method="post" class="up-form <?php echo (isset($password_change)) ? 'none' : ''; ?>" id="password">
            <h3 class="text-center" style="font-family: 'title'">პაროლის შეცვლა</h3>
            <div class="form-group req">
              <label for="curent_password">მიმდინარე პაროლი:</label>
               <input data-rule-required="true" data-msg-required="აუცილებელია"   name="curent_password" type="password" id="curent_password" value="" class="input">
            </div>
            <div class="form-group req">
              <label for="new_password">ახალი პაროლი:</label>
               <input data-rule-required="true" data-msg-required="აუცილებელია"   name="new_password" type="password" id="new_password" value="" class="input">
            </div>
            <div class="form-group req">
              <label for="repeat_password">გაიმეორეთ პაროლი:</label>
               <input data-rule-required="true" data-msg-required="აუცილებელია"   name="repeat_password" type="password" id="repeat_password" value="" class="input">
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_gender') {

          $old_gender = $user['gender'];


          if (isset($_POST['submit'])) {

            $gender = (int)$_POST['gender'];

            $params = array(
                "gender" => $gender
            );

            $update_gender = $db->update("users", $params, $user["id"]);

            if ($update_gender == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  სქესი წარმატებით შეიცვალა
                </div>

              <?php

              $gender_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($gender_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">სქესის შეცვლა</h3>
            <div class="form-group req">
              <label for="gender">აირჩიე სქესის</label>
              <select data-rule-required="true" data-msg-required="აუცილებელია" name="gender" id="gender" class="input">
                <option value="1" <?php echo ($old_gender == 1) ? 'selected' : ''; ?>>მამრობითი</option>
                <option value="2" <?php echo ($old_gender == 2) ? 'selected' : ''; ?>>მდედრობითი</option>
              </select>
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_sms') {

            $old_sms = $user['deposit_sms'];

            if (isset($_POST['submit'])) {

                $sms = (int) $_POST['deposit_sms'];

                $update_sms = $db->update('users', ['deposit_sms' => $sms], $user['id']);

                if ($update_sms == true) { ?>

                    <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                        წარმატებით შეიცვალა
                    </div>

                    <?php

                    $sms_change = true;

                } else { ?>

                    <div class="msg msg-error">
                        შეცდომა
                    </div>

                <?php }

            } ?>
            <form  method="post" class="up-form <?php echo (isset($sms_change)) ? 'none' : ''; ?>">
                <h3 class="text-center" style="font-family: 'title'">sms ბალანსის შევსების დროს</h3>
                <div class="form-group req">
                    <label for="deposit_sms">აირჩიეთ</label>
                    <select data-rule-required="true" data-msg-required="აუცილებელია" name="deposit_sms" id="deposit_sms" class="input">
                        <option value="1" <?php echo ($old_sms == 1) ? 'selected' : ''; ?>>კი</option>
                        <option value="0" <?php echo ($old_sms == 0) ? 'selected' : ''; ?>>არა</option>
                    </select>
                </div>
                <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
            </form>
            <?php

        } elseif ($action == 'change_email') {

          $old_email = $user['email'];


          if (isset($_POST['submit'])) {

            $email = $_POST['email'];

            $params = array(
      			    "email" => $email
      			);

            $update_email = $db->update("users", $params, $user["id"]);

            if ($update_email == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  ელ ფოსტა წარმატებით შეიცვალა
                </div>

              <?php

              $email_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($email_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">ელ-ფოსტის შეცვლა</h3>
            <div class="form-group req">
              <label for="email">ახალი ელ-ფოსტა:</label>
               <input data-rule-required="true" data-rule-email="true" data-msg-required="აუცილებელია"   name="email" type="text" id="email" value="<?=$old_email ?>" class="input">
            </div>
            <!-- <div class="form-group req">
              <label for="password">პაროლი:</label>
               <input data-rule-required="true" data-msg-required="აუცილებელია"   name="password" type="password" id="password" value="" class="input">
            </div> -->
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_birth_place') {

          $old_birth_place = $user['birth_place'];


          if (isset($_POST['submit'])) {


            $birth_place = $_POST['birth_place'];

            $params = array(
      			    "birth_place" => $birth_place
      			);

            $update_birth_place = $db->update("users", $params, $user["id"]);


            if ($update_birth_place == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  დაბადების ადგილი წარმატებით შეიცვალა
                </div>

              <?php

              $birth_place_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($birth_place_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">დაბადების ადგილის შეცვლა</h3>
            <div class="form-group req">
              <label for="birth_place">დაბადების ადგილი:</label>
               <input data-rule-required="true" maxlength="20" minlength="3"  data-msg-required="აუცილებელია"  name="birth_place" type="text" id="birth_place" value="<?=$old_birth_place ?>" class="input">
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_birth_date') {

          $old_birth_date = explode('-',$user['birth_date']);


          if (isset($_POST['submit'])) {


            $birth_year = $_POST['birth_year'];
            $birth_month = $_POST['birth_month'];
            $birth_day = $_POST['birth_day'];

            $birth_date = $birth_year.'-'.$birth_month.'-'.$birth_day;

            $params = array(
      			    "birth_date" => $birth_date,
                "payway" => '0'
      			);

            $update_date = $db->update("users", $params, $user["id"]);

            if ($update_date == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  დაბადების თარიღი წარმატებით შეიცვალა
                </div>

              <?php

              $birth_date_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($birth_date_change)) ? 'none' : ''; ?>" >
            <h3 class="text-center" style="font-family: 'title'">დაბადების თარიღი</h3>
            <div class="form-group req">
              <label for="birth_date">დაბადების თარიღი</label>
              <div class="row date-row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="birth_year" id="birth_year" class="input">
                    <option value="">წელი</option>

                    <?php foreach ($year_array as $year): ?>

                      <?php if ($year > 2005 ): ?>
                        <?php continue; ?>
                      <?php endif; ?>

                      <option value="<?=$year ?>" <?php echo ($old_birth_date[0] == $year) ? 'selected' : ''; ?>><?=$year ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="birth_month" id="birth_month" class="input">
                    <option value="">თვე</option>

                    <?php foreach ($month_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_birth_date[1] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="birth_day" id="birth_day" class="input">
                    <option value="">რიცხვი</option>

                    <?php foreach ($day_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_birth_date[2] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
              </div>
            </div>

            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_legal_address') {

          $old_legal_address = $user['legal_address'];


          if (isset($_POST['submit'])) {


            $legal_address = $_POST['legal_address'];

            $params = array(
                "legal_address" => $legal_address
            );

            $update_legal_address = $db->update("users", $params, $user["id"]);

            if ($update_legal_address == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  იურიდიული მისამართი წარმატებით შეიცვალა
                </div>

              <?php

              $legal_address_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($legal_address_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">იურიდიული მისამართი</h3>
            <div class="form-group req">
              <label for="legal_address">იურიდიული მისამართი:</label>
               <input data-rule-required="true" maxlength="20" minlength="3" data-msg-required="აუცილებელია"  name="legal_address" maxlength="40" type="text" id="legal_address" value="<?=$old_legal_address ?>" class="input">
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_real_address') {

          $old_real_address = $user['real_address'];


          if (isset($_POST['submit'])) {


            $real_address = $_POST['real_address'];

            $params = array(
                "real_address" => $real_address
            );

            $update_real_address = $db->update("users", $params, $user["id"]);

            if ($update_real_address == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  ფაქტიური მისამართი წარმატებით შეიცვალა
                </div>

              <?php

              $real_address_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($real_address_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">ფაქტიური მისამართი</h3>
            <div class="form-group req">
              <label for="real_address">ფაქტიური მისამართი:</label>
               <input data-rule-required="true" maxlength="20" minlength="3" data-msg-required="აუცილებელია"   name="real_address" maxlength="40" type="text" id="real_address" value="<?=$old_real_address ?>" class="input">
            </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_phone') {

          $old_mobile = $user['mobile'];


          if (isset($_POST['submit'])) {

            $mobile = $_POST['full_phone'];


            if (isset($_POST['code'])) {

              $sended_code = $_POST['code'];

              if (isset($_SESSION['code']) && $sended_code == $_SESSION['code']) {

                // update
                $params = array(
                    "mobile" => $mobile,
                    "payway" => '0'
                );

                $update_mobile = $db->update("users", $params, $user["id"]);


              } else {

                ?>
                <div class="msg msg-error" style="margin-top:30px" style="margin-top:10px">
                  SMS-ით მიღებული კოდი არასწორია
                </div>
                <?php

              } // code check

            }

            if (isset($update_mobile) && $update_mobile == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  ტელეფონის ნომერი წარმატებით შეიცვალა
                </div>

              <?php

              // delete session
              unset($_SESSION['code']);

              $phone_change = true;

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($phone_change)) ? 'none' : ''; ?> change_phone">
            <h3 class="text-center" style="font-family: 'title'">ტელეფონის ნომრი</h3>
            <div class="form-group req">
               <label for="phone">მიმდინარე ტელეფონის ნომერი</label>
                <input name="destination" value="<?php echo $old_mobile; ?>" type="txt" class="input" readonly>
             </div>
             <div class="form-group req">
                <label for="phone">ახალი ტელეფონის ნომერი</label>
                <input onkeypress="return isIntKey(event);" name="phone"  data-rule-required="true" type="tel" id="phone" class="input">
              </div>
             <div class="form-group req">
                <label for="code">SMS-ით მიღებული კოდი</label>
                <div class="send_btn"><span> <img src="/assets/img/sms.png" alt="send"> გაგზავნა</span></div>
                <input onkeypress="return isIntKey(event);"  data-rule-required="true" maxlength="6" minlength="6" name="code" type="txt" id="code" class="input" autocomplete="off">
              </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_passport_number') {

          $old_passport_number = $user['passport_number'];


          if (isset($_POST['submit'])) {

            $passport_number = $_POST['passport_number'];

            $params = array(
                "passport_number" => $passport_number
            );

            $update_passport_number = $db->update("users", $params, $user["id"]);


            if ($update_passport_number == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  პასპორტის(საბუთის) ნომერი წარმატებით შეიცვალა
                </div>

              <?php

              $passport_number_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($passport_number_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">პასპორტის(საბუთის) ნომერი</h3>
            <div class="form-group req">
               <label for="passport_number">პასპორტის(საბუთის) ნომერი:</label>
                <input data-rule-required="true" maxlength="15" minlength="6" data-msg-required="აუცილებელია"  name="passport_number" maxlength="12" value="<?=$old_passport_number ?>" maxlength="20" type="txt" id="passport_number" class="input">
             </div>
            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php


        } elseif ($action == 'change_issue_date') {

          $old_issue_date = explode('-',$user['issue_date']);

          if (isset($_POST['submit'])) {


            $issue_year = $_POST['issue_year'];
            $issue_month = $_POST['issue_month'];
            $issue_day = $_POST['issue_day'];

            $issue_date = $issue_year.'-'.$issue_month.'-'.$issue_day;

            $params = array(
                "issue_date" => $issue_date
            );

            $update_issue = $db->update("users", $params, $user["id"]);


            if ($update_issue == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                პასპორტის რეგისტრიაცისიი თარიღი წარმატებით შეიცვალა
                </div>

              <?php

              $issue_date_change = true;

            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($issue_date_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">პასპორტის რეგისტრიაცისიი თარიღი</h3>
            <div class="form-group req">
              <label for="issue_date">პასპორტის რეგისტრიაცისიი თარიღი</label>
              <div class="row date-row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="issue_year" id="issue_year" class="input">
                    <option value="">წელი</option>

                    <?php foreach ($year_array as $year): ?>

                      <?php if ($year > date("Y") ): ?>
                        <?php continue; ?>
                      <?php endif; ?>

                      <option value="<?=$year ?>" <?php echo ($old_issue_date[0] == $year) ? 'selected' : ''; ?>><?=$year ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="issue_month" id="issue_month" class="input">
                    <option value="">თვე</option>

                    <?php foreach ($month_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_issue_date[1] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="issue_day" id="issue_day" class="input">
                    <option value="">რიცხვი</option>

                    <?php foreach ($day_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_issue_date[2] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
              </div>
            </div>

            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } elseif ($action == 'change_expiry_date') {

          $old_expiry_date = explode('-',$user['expiry_date']);

          if (isset($_POST['submit'])) {


            $expiry_year = $_POST['expiry_year'];
            $expiry_month = $_POST['expiry_month'];
            $expiry_day = $_POST['expiry_day'];

            $expiry_date = $expiry_year.'-'.$expiry_month.'-'.$expiry_day;

            $params = array(
                "expiry_date" => $expiry_date
            );

            $update_expiry = $db->update("users", $params, $user["id"]);

            if ($update_expiry == true) {
              ?>

                <div class="msg msg-succses" style="margin-top:30px" style="margin-top:10px">
                  პასპორტის მოქმედების ვადა წარმატებით შეიცვალა
                </div>

              <?php

              $expiry_date_change = true;


            } else {

              ?>

                <div class="msg msg-error">
                  შეცდომა
                </div>

              <?php

            }


          }

          ?>
          <form  method="post" class="up-form <?php echo (isset($expiry_date_change)) ? 'none' : ''; ?>">
            <h3 class="text-center" style="font-family: 'title'">პასპორტის მოქმედების ვადა</h3>
            <div class="form-group req">
              <label for="expiry_date">პასპორტის მოქმედების ვადა</label>
              <div class="row date-row">
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="expiry_year" id="expiry_year" class="input">
                    <option value="">წელი</option>

                    <?php foreach ($year_array as $year): ?>

                      <?php if ($year < date("Y") ): ?>
                        <?php continue; ?>
                      <?php endif; ?>

                      <option value="<?=$year ?>" <?php echo ($old_expiry_date[0] == $year) ? 'selected' : ''; ?>><?=$year ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="expiry_month" id="expiry_month" class="input">
                    <option value="">თვე</option>

                    <?php foreach ($month_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_expiry_date[1] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-4">
                  <select data-rule-required="true" data-msg-required="აუცილებელია" name="expiry_day" id="expiry_day" class="input">
                    <option value="">რიცხვი</option>

                    <?php foreach ($day_array as $key => $value): ?>

                      <option value="<?=$key ?>" <?php echo ($old_expiry_date[2] == $key) ? 'selected' : ''; ?>><?=$value ?></option>

                    <?php endforeach; ?>

                  </select>
                </div>
              </div>
            </div>

            <button type="submit" class="g1-btn btn-b" name="submit"><i class="ic-reg"></i> შეცვლა</button>
          </form>
          <?php

        } else {

          echo "404";

        }


      } else {

        echo "404";

      }

    ?>

    <!-- validation -->
    <script type="text/javascript" src="../assets/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="../assets/plugins/jquery-validation/js/localization/messages_ge.js"></script>
    <!-- input masks -->
    <script type="text/javascript" src="../assets/plugins/inputmask/jquery.inputmask.bundle.js"></script>
    <!-- telephone -->
    <script src="../assets/plugins/intl-tel-input/intlTelInput.js"></script>
    <script>

      //phone countryes
      $("#phone").intlTelInput({
        hiddenInput: "full_phone",
        preferredCountries: ["ge"],
        utilsScript: "../assets/plugins/intl-tel-input/utils.js",
        separateDialCode: true,
      });

      // tefefhone mask
       $("#phone").inputmask({"mask": "999 99 99 99"});

       // get phone sufix


       // check is input value integer
        function isIntKey(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
          } else {
            return true;
          }
        }


        $("form").each(function() {
          $(this).validate({
              errorPlacement: function(error, element) {
                  // to append radio group validation erro after radio group
                  //error.insertAfter(element);
                  error.insertAfter(element);
                }
            });
        })

        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {



                if (input.files) {

                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $(placeToInsertImagePreview).empty();
                            $(placeToInsertImagePreview).parent().css("display","block");
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[0]);
                }

            };

            $('#fileinput').on('change', function() {
                imagesPreview(this, '.img-result');
            });
        });




        function send_sms(form) {

            var data = $(form).serializeArray();

            data.push({name: "sender", value: "apw.ge"});

          //

          $.ajax({
             type: "POST",
             url: 'http://apw.ge/loads/sms.php?send',
             data: data,
             dataType: "json",
             success: function(data) {

               if (data.errorCode != 100) {

                 $('body').prepend('<div class="msg msg-error" style="margin-top:30px" style="margin-top:10px">'+
                                     data.errorMessage+
                                   '</div>');

               }

            }  // success

          }); // ajax

        } // send_sms


        $(document).ready(function() {

          // timer
          function timer(timer) {

            var interval = setInterval(function() {
                timer--;
                $('#timer').text(timer);
                if (timer === 0) clearInterval(interval);
            }, 1000);

          }


          var clickDisabled = false;

          $(".send_btn").click(function() {

              if (clickDisabled) {

                return false;

              }

              // loading
              var load_btn = $('.send_btn');
              $(load_btn).find('span').css("visibility","hidden");
              $(load_btn).append('<div id="timer">60</div>');
              // loading

              timer(60);



              // delete session
              $.get("http://apw.ge/loads/sms.php?delete_sesion", function(){});

              send_sms(".change_phone");

              clickDisabled = true;

              setTimeout(function(){

                clickDisabled = false;

                // loading
                $(load_btn).find('span').css("visibility","visible");
                $(load_btn).find('#timer').remove();
                // loading

                // delete session
                $.get("http://apw.ge/loads/sms.php?delete_sesion", function(){});

              }, 60000);

          });


        });

    </script>
  </body>
</html>
