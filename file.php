<?php
require_once "../class/Config.php";
require_once "../class/User.php";
require_once "../class/Client.php";
require_once "../class/pdf/mpdf.php";
$User = new User();
$User->checkAuth();

$Client = new Client();

$personal_number = trim($get["personal_number"]);
$document_number = trim($get["document_number"]);
$first_name = trim($get["first_name"]);
$last_name = trim($get["last_name"]);
$birth_date = trim($get["birth_date"]);

$first_name1 = $Client->geoToeng($first_name);
$last_name1 = $Client->geoToeng($last_name);

// get document
$user_document = $Client->getData("users_documents"," document_number = '".$document_number."'");

list($y,$m,$d) = explode("-",$birth_date);

$filename = md5($_SESSION["AuthorizedUserId"]) . "-document.pdf";
//create new PDF document
$pdf = new mPDF('utf-8', 'Letter', 0, '', 10, 10, 10, 10, 10, 10);
//set document information
$pdf->SetAuthor('leaderpay');
$pdf->SetTitle("კონფიდენციალურობის დოკუმენტი");
$pdf->SetSubject('კონფიდენციალურობის დოკუმენტი');
//add a page
$pdf->AddPage();
$tbl = '<style>@page {margin: 0px;}body { margin: 40px;font-family: serif; font-size: 11px; } h3 {margin: 2px 0 2px 0;} .left{width: 60%;float: left;font-size:12px;} .right{width: 40%;float: right;text-align: right;font-size:11px;} .clear { clear:both; }</style><img style="width: 50px;opacity: 0.8;margin-top:-20px;" src="../assets/img/coin.png"/><div style="color: green;font-weight: bold;position: absolute;left: 90px;top: 34px;opacity: 0.8;">ყველა გადახდის გზა</div>';
$tbl .= '<h3 style="text-align: center;font-size:14px;margin: 0px">ელექტრონული საფულის მფლობელის თანხმობა</h3>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">მე  '.$first_name.' '.$last_name.'   პირადი ნომერი: '.$personal_number.' დაბადებული  '.$d.' '.$Client->months[intval($m)].' '.$y.' წელი  წინამდებარე დოკუმენტზე ხელის მოწერით ვადასტურებ რომ  გავეცანი და ვეთანხმები შპს "ოლ ფეი ვეი"ის ელექტრონულ საფულეში რეგისტრაციისა და სარგებლობის, კომფიდენციალურობის და უსაფრთხოების პირობებს, რომელიც განთავსებულია   პროვაიდერის ვებ გვერდზე: <a target="_blank" href="http://leaderpay.ge/rules.php">http://leaderpay.ge/rules.php</a> </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">შესაბამისად იდენთიფიცირებისა და  საგადახდო მომსახურების გაწევის მიზნით  ვაძლევ უფლებას      ელექტრონული საფულის სისტემის  ლიდერფეი(leaderpay)–ს მფლობელ  საგადახდო მომსახურების პროვაიდერს შპს „ოლ ფეი ვეი“–ს, მიიღოს ან მოიპოვოს, დაამუშაოს,  შეინახოს  და საჭიროების შემთხვევაში გადასცეს მასთან სახელშეკრულებო ურთიერთობაში მყოფ მესამე პირებსა და მასთან აფილირებულ პირებს   ჩემი პერსონალური მაიდენთიფიცირებელი მონაცემები.  ასევე ჩემს შესახებ პერსონალური ინფორმაცია  გამოითხოვოს  პროვაიდერთან სახელშეკრულებო ურთიერთობაში მყოფ  მესამე პირებსა და მასთან აფილირებულ პირებისგან.  </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">თანხმობას ვაცხადებ, რომ შპს „ ოლ ფეი ვეი“-მ კანონმდებლობით დადგენილი წესით, ჩემი იდენტიფიცირებისა და საგადახდო მომსახურების განხორციელების  მიზნით და ამ მიზნის განსახორციელებლად საჭირო მოცულობით, სსიპ სახელმწიფო სერვისების განვითარების სააგენტოს, შსს-ს, შემოსავლების სამსახურის, ბანკების, მიკროსაფინანსო ორგანიზაციების, სადაზღვევო კომპანიების, მობილური ოპერატორების ასევე კომუნალური მომსახურების მომწოდებელი კომპანიების  მონაცემთა ელექტრონული ბაზიდან მიიღოს, პროვაიდერისათვის  აუცილებელი, ჩემი პერსონალური მონაცემები.  </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">თანხმობას ვაცხადებ, რომ შპს „ ოლ ფეი ვეი“-მ კანონმდებლობით დადგენილი წესით, ჩემი იდენტიფიცირებისა და საგადახდო მომსახურების განხორციელების  მიზნით და ამ მიზნის განსახორციელებლად საჭირო მოცულობით, სსიპ სახელმწიფო სერვისების განვითარების სააგენტოს, შსს-ს, შემოსავლების სამსახურის, ბანკების, მიკროსაფინანსო ორგანიზაციების, სადაზღვევო კომპანიების, მობილური ოპერატორების ასევე კომუნალური მომსახურების მომწოდებელი კომპანიების  მონაცემთა ელექტრონული ბაზიდან მიიღოს, პროვაიდერისათვის  აუცილებელი, ჩემი პერსონალური მონაცემები.  </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">მე ვადასტურებ რომ პროვაიდერის ან პროვაიდერის აგენტის ან მასთან სახელშეკრულებო ურთიერთობაში მყოფ მესამე პირის თანამშრომლის  მიერ დეტალურად განმემარტა  ჩემი პერსონალური მონაცემების მოპოვების, შენახვის, გამოყენების მიზნების, ვადის, მოცულობის თაობაზე და ვაცხადებ  თანხმობას  გამოყენებულ იქნას ჩემი პერსონალური მონაცემები ( სახელი, გვარი, პირადი(მაიდენთიფიცირებელი დოკუმენტის) ნომერი, დაბადების თარიღი, დაბადების ადგილი, ტელეფონის ნომერი, ელექტრონული ფოსტის მისამართი) საგადახდო მომსახურების განხორციელების გაუმჯობესების მიზნით.  </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">ვეთანხმები მივიღო  შპს „ ოლ ფეი ვეი“-სა და მისი პარტნიორი კომპანიებისგან SMS და ელექტრონული წერილები ჩემს მიერ მითითებულ მობილურ ნომერზე ან/და ელექტრონულ ფოსტაზე,  შპს „ ოლ ფეი ვეი“-ს მომსახურების პირობების შესაბამისად.  </p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">მე ვადასტურებ რომ ჩემს მიერ მითითებული ყველა მონაცემი  ელექტრონულ საფულის ლიდერფეი(leaderpay) სისტემაში  რეგისტრაციის დროს და წინამდებარე  დოკუმენტში მითითებული მონაცემები არის  ზუსტი და  იდენტური.</p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">მე ვადასტურებ რომ, არ ვარ პოლიტიკურად აქტიური და არ ვახორციელებ ელექტრონულ საფულე ლიდერფეი(leaderpay)  სისტემაში  კანონით აკრძალულ ქმედებეს.</p>';
$tbl .= '<p style="text-indent: 20px;margin: 0px;">გთხოვთ, ელექტრონული საფულის სისტემის  ლიდერფეი(leaderpay) –ს მფლობელ საგადახდო მომსახურების პროვაიდერმა  შპს „ოლ ფეი ვეი“–მ, მიიღოთ ჩემი პერსონალური მაიდენთიფიცირებელი მონაცემები, რის საფუძველზეც ლიდერფეი(leaderpay) -ს  სისტემაში არსებულ ჩემს ელექტრონული საფულის ანგარიშზე '.$personal_number.' მომანიჭოთ იდენთიფიცირების სტატუსი.  </p>';
$tbl .= '<br clear="all">';
// $tbl .= '<h3 style="text-align: center;font-size:14px;margin: 0px">Consent</h3>';
// $tbl .= '<p style="text-indent: 20px;margin: 0px;">I '.$first_name1.' '.$last_name1.' personal number '.$personal_number.', date of bith '.$d.' '.$Client->monthsEng[intval($m)].' '.$y.' year, by signing this document I confirm that I am aware and agree to the electronic wallet registration and using terms, confidentiality and information safety policy terms and conditions of LLC  "All Pay Way", which are given at the provider web page <a target="_blank" href="http://leaderpay.ge/rules.php">http://leaderpay.ge/rules.php</a></p>';
// $tbl .= '<p style="text-indent: 20px;margin: 0px;">For the purpose of payment service, I authorize the provider LLC "All Pay Way" owner of electronic wallet system leaderpay to collect my personal information, process it, save it and send to the contractual relationship third parties or withdraw information from the contractual or/and affiliated relationship third parties.</p>';
// $tbl .= '<p style="text-indent: 20px;margin: 0px;">-I agree to the provider by the legislation, to collect my personal necessary information multiple times, with required volume, for the purpose of payment services, from the LEPL State Service Development Agency electronics database, MIA, the Revenue Service, Georgian Insurance companies, Micro Finance Organizations, Banks, Utility companies and Telecommunication providers.</p>';
// $tbl .= '<p style="text-indent: 20px;margin: 0px;">-I confirm that employee of the provider LLC "All Pay Way" or of the agent of the provider or the third person of provider (acting according the agreement between provider and third party) explained me verbally, the details, purpose of using, collecting, processing, saving my information, for what period of time and I authorize the provider to use my personal information (name, surname, personal/passport number, place of birth, date of birth, citizenship, phone number, e_mail) for the purpose of improvement payment service.</p>';
// $tbl .= "<p style='text-indent: 20px;margin: 0px;'>-I agree to receive SMS and e-mails from LLC 'All Pay Way' Ltd and its partner companies on the mobile number and / or e-mail address indicated by me in accordance with the terms of provider's services.</p>";
// $tbl .= "<p style='text-indent: 20px;margin: 0px;'>-I confirm that all the dates indicated by me during registration in the electronic wallet leaderpay (leaderpay) system and the dates indicated in this document is accurate and identical.</p>";
// $tbl .= "<p style='text-indent: 20px;margin: 0px;'>-I confirm that I am not politically active and do not pursue an action prohibited by the law in the leaderpay system.</p>";
// $tbl .= '<p style="text-indent: 20px;margin: 0px;">-I address to LLC "All Pay Way" to the owner of the electronic wallet system leaderpay to receive my personal identification details, according which provider can make identification status on my electronic wallet account number '.$personal_number.' in the leaderpay system.</p>';
// $tbl .= '<br clear="all">';

$tbl .= '<table align="center" width="100%" cellspacing="20px" cellpadding="0">';
$tbl .= '<tr>';
$tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">';
$tbl .= '<img src="https://uploads.allpayway.ge/files/documents/' . $user_document["document_front"] . '" style="width: 100%;max-width: 300px;max-height: 300px;border-radius: 10px;">';
$tbl .= '</td>';

if ($user_document["document_back"] != '') {

    $tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">';
    $tbl .= '<img src="https://uploads.allpayway.ge/files/documents/' . $user_document["document_back"] . '" style="width: 100%;max-width: 300px;max-height: 300px;border-radius: 10px;">';
    $tbl .= '</td>';

}
$tbl .= '</tr>';
$tbl .= '</table>';

$tbl .= '<div style="font-size:1px; color: #333; text-align:center;"> </div>';
$tbl .= '<div style="font-size:1px; color: #333; text-align:center;"> </div>';

$tbl .= '<br clear="all">';

$tbl .= '<table align="center" width="100%" cellspacing="20px" cellpadding="0">';
$tbl .= '<tr>';
$tbl .= '<td style="width:33.33333%;border-bottom:1px solid #000;height: 2px;"></td>';
$tbl .= '<td style="width:33.33333%;border-bottom:1px solid #000;height: 2px;"></td>';
$tbl .= '<td style="width:33.33333%;border-bottom:1px solid #000;height: 2px;"></td>';
$tbl .= '<td style="width:33.33333%;border-bottom:1px solid #000;height: 2px;"></td>';
$tbl .= '</tr>';
$tbl .= '<tr>';
$tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">(სახელი/name, გვარი/surname)</td>';
$tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">(ხელმწოწერა/signature)</td>';
$tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">(თარიღი/date)</td>';
$tbl .= '<td style="width:33.33333%;text-align:center;font-size:12px;vertical-align: top;height: 20px;">(მაიდენტიფიცირებელის ხელმწოწერა/The identifier signature)</td>';

$tbl .= '</tr>';
$tbl .= '</table>';
$tbl .= '<div style="display: block;text-align: left;font-weight: bold;color: #a8a8a8;">შპს ოლ ფეი ვეი  ს/კ 400147211   0177 საქართველო, თბილისი, ადამ მიცკევიჩის ქ 25ბ, 1 სადარბაზო, ოთახი 17</div>';
$tbl .= '<div style="display: block;text-align: left;font-weight: bold;color: #a8a8a8;">ტელ:+995322422711  www.leaderpay.ge    info@allpayway.org </div>';

$pdf->WriteHTML($tbl);
@unlink("../files/" . $filename . "");
$pdf->Output("../files/" . $filename . "");
echo $filename;
