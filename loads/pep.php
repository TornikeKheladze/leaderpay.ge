<?php
    require_once __DIR__ . '/../vendor/autoload.php';

    require '../classes/config.php';
    require '../classes/db.php';
    require '../classes/Upload.php';

    $db = new db();
    $Upload = new Upload();

    if (!isset($post['personal_number'])) {

        die();

    }

    $personal_number = htmlspecialchars(trim($post['personal_number']), ENT_QUOTES);

    $user = $db->get_date('users', " personal_number = '$personal_number'");

    if (!$user) {

        die();

    }

    $pep_status = $user['pep_status'];
    $pep = $user['pep'];
    $pep_name = $db->get_date('user_pep', " id = '$pep'");
    $pep_name = $pep_name['name'];

    $filename = $personal_number . '_user_pep.pdf';

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->AddPage();

    $tbl = "<style>@page {margin: 0px;}body { margin: 40px;font-family: serif; font-size: 13px; } h3 {margin: 2px 0 2px 0;} .left{width: 60%;float: left;font-size:12px;} .right{width: 40%;float: right;text-align: right;font-size:11px;} .clear { clear:both; }</style>";

    $tbl .= '<p style="margin: 0px;"><b>(PEP)</b> პოლიტიკურად აქტიური პირი გულისხმობს, საქართველოს ან უცხო ქვეყნის მოქალაქე';
    $tbl .= ' ფიზიკურ პირს, რომლესაც უკავია ან ბოლო 1 წლის განმავლობაში ეკავა სახელმწიფო';
    $tbl .= ' (საჯარო) პოლიტიკური თანამდებობა ან/და ეწევა მნიშვნელოვან სახელმწიფოებრივ და';
    $tbl .= ' პოლიტიკურ საქმიანობას. პოლიტიკურად აქტიური პირები არიან: სახელმწიფოს მეთაური,';
    $tbl .= ' მთავრობის ხელმძღვანელი და მთავრობის წევრი, აგრეთვე მათი მოადგილეები, სამთავრობო';
    $tbl .= ' დაწესებულების ხელმძღვანელი, პარლამენტის წევრი, უზენაესი სასამართლოს წევრი,';
    $tbl .= ' საკონსტიტუციო სასამართლოს წევრი, სამხედრო ძალების ხელმძღვანელი პირი,';
    $tbl .= ' ცენტრალური (ეროვნული) ბანკის საბჭოს წევრი, ელჩი, სახელმწიფოს წილობრივი';
    $tbl .= ' მონაწილეობით მოქმედი საწარმოს ხელმძღვანელი პირი, პოლიტიკური პარტიის';
    $tbl .= ' (გაერთიანების) ხელმძღვანელი, პოლიტიკური პარტიის (გაერთიანების) აღმასრულებელი';
    $tbl .= ' ორგანოს წევრი, სხვა მნიშვნელოვანი პოლიტიკური მოღვაწე.</p>';
    $tbl .= '<br>';
    $tbl .= '<br>';
    $tbl .= '<p style="margin: 0px;">პირი პოლიტიკურად აქტიურ პირად ითვლება ზემოაღნიშნული თანამდებობის დატოვებიდან ერთი წლის განმავლობაში</p>';
    $tbl .= '<br>';
    $tbl .= '<br>';
    $tbl .= '<p style="margin: 0px;">ხართ ან იყავით თქვენ ან თქვენი ოჯახის წევრი პოლიტიკურად აქტიური პირი (PEP). ხართ ან ყოფილხართ თუ არა პოლიტიკურად აქტიურ პირთან უშუალო საქმიან ურთიერთობაში, პოლიტიკურად აქტიურ პირთან ერთად ფლობთ ან აკონტროლებთ იურიდიული პირის წილს ან ხმის უფლების მქონე აქციებს ან გაქვთ თუ არა ასეთ პირთან (PEP) სხვაგვარი მჭიდრო კავშირი.</p>';
    $tbl .= '<br>';
    $tbl .= '<br>';

    if ($pep_status == 1) {

        $tbl .= "<p style='margin: 0px;'>კი - $pep_name</p>";

    } else {

        $tbl .= '<p style="margin: 0px;">არა</p>';

    }

    $tbl .= '</table>';

    $mpdf->WriteHTML($tbl);
    $base64 = 'data:application/pdf;base64,' . base64_encode($mpdf->Output('', 'S'));

    // file upload
    $pdf_dir = 'files/user_contracts/';
    $filename = $personal_number . '-document';

    $pdf_params = [
        'file'      => $base64,
        'file_name' => $filename,
        'dir'       => $pdf_dir,
    ];

    $document = $Upload->file($pdf_params);

    $params = [
        'user_id' => $user['id'],
        'author' => 'leaderpay.ge',
        'file' => $document,
        'type' => 2,
        'updated_at' => date('Y-m-d'),
    ];

    $file = $db->get_date('user_files', " user_id = '$user[id]'");

    if ($file) {

        $status = $db->update('user_files', $params, $file['id']);

    } else {

        $status = $db->insert('user_files', $params);

    }

    var_dump($status);
