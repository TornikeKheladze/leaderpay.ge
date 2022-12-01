<?php
    require '../classes/config.php';
    require '../classes/db.php';

    $db = new db();

    if (!isset($get['personal_number']) || !isset($get['pep'])) {

        die();

    }

    $personal_number = htmlspecialchars(trim($get['personal_number']), ENT_QUOTES);
    $pep_status = htmlspecialchars(trim($get['pep']), ENT_QUOTES);

    $user = $db->get_date('users', " personal_number = '$personal_number'");

    if (!$user) {

        die();

    }

    $first_name = $user['first_name'];
    $last_name = $user['last_name'];
    $birth_date = $user['birth_date'];

    $tbl = '<div style="margin: 100px auto; max-width: 900px; font-size: 9px; background: url(https://manager.allpayway.ge/assets/img/document-logo.jpg) no-repeat center center;">';
        $tbl .= '<h3 style="text-align: center; font-size: 11px; margin: 0px; color: #333; margin-bottom: 10px;">ხელშეკრულება ელექტრონული საფულის გამოყენების  შესახებ</h3>';
        $tbl .= '<p style="margin: 0px;">აღნიშნული ვებგვერდი <span style="color: #0e0ae1;"> www.leaderpay.ge </span> ასევე <span style="color: #0e0ae1;"> www.leader-pay.com </span> წარმოადგენს შპს „ოლ ფეი ვეი“ სკ 400147211 საკუთრებას.წინამდებარე ვებ გვერდის სარგებლობისას, თქვენ ავტომატურად ეთანხმებით ამ ხელშეკრულების პირობებს და ვალდებული ხართ განუხრელად დაიცვათ ყველა ქვემოთ ხსენებული პირობა.</p>';
        $tbl .= '<p style="margin: 0px;"><b>1. ტერმინთა განმარტება:</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>1.1</b> მომსახურება - საგადახდო ან/და სხვა მომსახურება; <b>1.2</b> ვებ-გვერდი - <span style="color: #0e0ae1;"> www.leaderpay.ge </span>; <b>1.3</b> ანგარიში - ელექტრონული ანგარიში, საგადახდო ინსტრუმენტი ტექნიკური საშუალება რომელიც იძლევა ელექტრონული ფულის გამოყენების საშუალებას; <b>1.4</b> მიმღები - პირი, რომელსაც შპს „ოლ ფეი ვეი“ უწევს საგადახდო მომსახურებას</p>';
        $tbl .= '<p style="margin: 0px;"><b>2. ვებგვერდით და ჩვენი სხვა მომსახურებით სარგებლობისას თქვენ:</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>2.1</b> ადასტურებთ, რომ ხართ სრულწლოვანი 18 წლის ქმედუნარიანი პირი, ან 16 დან 18 წლამდე პირი და გაქვთ ნებართვა შესაბამისი პირებისაგან დადოთ ხელშეკრულება, მიიღოთ სერვისის საშუალებით მომსახურება და განკარგოთ შესაბამისი თანხები; <b>2.2</b> განუხრელად დაიცავათ ხელშეკრულებით გათვალისწინებუი სერვისით სარგებლობის პირობებს; <b>2.3</b> წარმოადგენთ ჩვენს მიერ მოთხოვნილ ინფორმაციას სრულად და ზუსტად, რათა ისარგებლოთ ჩვენი მომსახურებით; <b>2.4</b> მკაცრად დაიცავთ თქვენი პირადი ანგარიშის ან ნებისმიერი რეკვიზიტის უსაფრთხოებას და კონფიდენციალურობას, არ გაუმჟღავნებთ ნებისმიერ მესამე პირს თქვენი გვერდის უსაფრთხოების ანგარიშის რეკვიზიტებს, რათა დაცული იყოს თქვენს პირად ანგარიშზე არსებული აქტივი და ინფორმაცია; <b>2.5</b> ადასტურებთ, რომ გეკუთვნით ან ფლობთ ყველა საჭირო უფლებას, ნებართვას საიმისოდ, რომ გამოიყენოთ და ნება დართოთ ოლ ფეი ვეი-ს,რადგან მან გამოიყენოს ნებისმიერი თქვენს მიერ მისთვის მიწოდებული ინფორმაცია, ამ ხელშეკრულებისა და ინფორმაციის დაცვის პოლიტიკის წესების შესაბამისად (რომელიც შეგიძლიათ იხილოთ ვებგვერდზე); <b>2.6</b> არ განახორციელებთ ისეთ ქმედებებს, რომელიც მიმართულია სხვა მომხმარებლის პირადი და კონფიდენციალური ინფორმაციის, მათ შორის ანგარიშის უსაფრთხოების კოდების გაგებისაკენ და სხვა მომხმარებლის პირადი აქტივის განკარგვისაკენ; <b>2.7</b> არ განახორციელებთ ისეთ ქმედებას, რომელიც საფრთხეს უქმნის ვებგვერდის ან მომსახურების გამართულ ფუნქციონირებას; <b>2.8</b> არ განახორციელებთ კანონით აკრძალულ ისეთი ქმედება(ს), როგორიცაა ფულის გათეთრება, ტერორისტთა/ტერორიზმის დაფინანსება ან ხელშეწყობა, იარაღის შესყიდვა და ა.შ.; <b>2.14</b> არ განახორციელებთ ისეთ ქმედებას, რომელიც აკრძალულია კანონმდებლობით, ამ ხელშეკრულებით მომსახურების მიღებისათვის არსებული წესებით.</p>';
        $tbl .= '<p style="margin: 0px;"><b>3. პასუხისმგებლობა</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>3.1</b> ჩვენ ვიღებთ პასუხიმგებლობას მომხმარებლის მიმართ ნებისმიერი და ყველა ზიანის, ზარალის, სარჩელის, ვალდებულებების და ხარჯებისათვის, რაც გამოწვეულია უშუალოდ ჩვენი მიზეზით. <b>3.2</b> პასუხს არ ვაგებთ ზიანისთვის ან შედეგისათვის, რომელიც გამოწვეულია თქვენი მიზეზით ან ბრალეული ქმედებით, ასევე თქვენს მიერ ანგარიშთან დაკავშირებული ვალდებულებების განზრახ ან დაუდევრობით შეუსრულებლობის შემთხვებში. <b>3.3</b> თქვენ გეკისრებათ პასუხისმგებლობა საგადახდო დავალების შეუსრულებლობისთვის ან არასწორად შესრულებისთვის, რომელიც გამოწვეულია თქვენს მიერ წარმოდგენილ საგადახდო დავალებაში მითითებული არასწორი ინფორმაციით, მოპარული ან დაკარგული ანგარიშით ან მისი უკანონო მითვისებით ან უკანონო გამოყენებით გამოწვეული, საქართველოს ტერიტორიაზე განხორციელებული ოპერაციის (მათ შორის არაავტორიზებული) შედეგებზე „საქართველოს სისტემისა და საგადახდო მომსახურების შესახებ“ საქართველოს კანონის შესაბამისად.</p>';
        $tbl .= '<p style="margin: 0px;"><b>4. ანგარიშის უსაფრთხოება და დაცულობა:</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>4.1</b> თქვენ ვალდებული ხართ ყოველთვის უსაფრთხოდ შეინახოთ თქვენი ელექტრონული ანგარიშის ნებისმერი რეკვიზიტები (ტელეფონის ნომერი, პაროლი, ელ ფოსტის მისამართი და სხვა) და არანაირი ფორმით არ გაუმჟღავნოთ იგი ნებისმიერ მესამე პირს. უსაფრთხოების დაცვის მიზნით რეკომენდირებულია: <b>4.2</b> პერიოდულად შეცვალეთ თქვენი პაროლი. <b>4.3</b> არ ჩაიწეროთ ან სხვაგვარად შეინახოთ თქვენი ანგარიშის რეკვიზიტები, ადვილად ხელმისაწვდომი არ გახდეს მესამე პირისათვის <b>4.4</b> თქვენს მიერ ზემოაღნიშნულ ნებისმიერი უსაფრთხოების ზომების დაუცველობის შემთხვევაში ჩვენ პასუხს არ ვაგებთ. <b>4.5</b> ჩვენ უფლება გვაქვს დავბლოკოთ/შევაჩეროთ თქვენი ანგარიში, თუ ადგილი ექნება თქვენი ანგარიშის გამოყენებას ან/და ხელშეკრულებით გათვალისწინებული პირობების დარღვევას ან კანონმდებლობით გათვალისწინებულ სხვა შემთხვევაში.</p>';
        $tbl .= '<p style="margin: 0px;"><b>5. მომსახურების მიღებისა და ელექტრონული საფულის ანგარიშის გამოყენების პირობები:</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>5.1</b> ჩვენი მომსახურების მიღება შესაძლებელია ვებ გვერდზე მითითებული ინფორმაციის მიხედვით შესაბამისი წესებისა და ქმედებების გათვალისწინებით ჩვენ ვიტოვებთ უფლებას საკუთარი შეხედულებისამებრ არ დავუშვათ ან სხვა სახით შევზღუდოთ ჩვენი მომსახურების მიღება.</p>';
        $tbl .= '<p style="margin: 0px;"><b>7. შეზღუდვები ვებ გვერდის გამოყენებაზე</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>7.1</b> ვებგვერდზე არსებული ინფორმაცია შეიძლება შეიცვალოს ან მოიხსნას წინასწარი შეტყობინების გარეშე. ჩვენ არ ვიძლევით გარანტიას იმაზე, რომ ამ ვებგვერდით მიწოდებული მომსახურებები იმუშავებს შეცდომების ან შეფერხებების გარეშე. ჩვენგან ვერ მიიღებთ იმ მომსახურებას, რომელიც ჩვენი აზრით არღვევს კანონმდებლობას. ამასთანავე, თქვენ გეკრძალებათ ჩვენი სისტემების ან ამ ვებგვერდის ყოველგვარი არაუფლებამოსილი გამოყენება, რაშიც შეუზღუდავად შედის ჩვენს სისტემებში არასანქცირებული შესვლა, პაროლის არასათანადო გამოყენება ან ვებგვერდზე განთავსებული ნებისმიერი ინფორმაციის არასათანადო გამოყენება. თქვენ თანხმობას აცხადებთ იმაზე, რომ ჩვენ უფლება გვაქვს ხელშეკრულების ფარგლებში თქვენს მიერ მიწოდებული და ჩვენს მიერ მოპოვებული ნებისმიერი ინფორმაცია, (სახელი, გვარი, პირადი ნომერი, დაბადების თარიღი, მობილურის ნომერი და სხვა), გავუმჟღავნოთ და გადავცეთ: 1. ჩვენთან აფილირებულ ნებისმიერ პირს და მის უფლებამოსილ წარმომადგენელს 2. ნებისმიერ სხვა პირს ან ორგანიზაციას თქვენი თანხმობით; 3. შესაბამის პირს ან ორგანოს კანონმდებლობით გათვალისწინებულ შემთხვევაში ინფორმაციის გაცემის უფლების ან ვალდებულების არსებობისას. თქვენს მიერ ამ ვებგვერდით სარგებლობა ან ნებისიმიერი ინფორმაციის მიწოდება მიიჩნევა თქვენს მიერ ინფორმაციის ასეთ გადაცემაზე თანხმობად. ჩვენ უფლება გვაქვს დავამუშავოთ თქვენი პერსონალური მონაცემები.</p>';
        $tbl .= '<p style="margin: 0px;"><b>8. ელექტრონული საფულეში რეგისტრაციის წესი</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>8.1</b> რეგისტრირებულ მომხმარებელს გააჩნია შეზღუდვები იქამდე სანამ ის არ გაივლის სისტემაში იდენთიფიცირებას. იდენთიფიცირებისათვის აუცილებელია, მომხმარებელმა მიუთითოს სწორად მისი სახელ- გვარი დაბადების თარიღი, მობილურის ნომერი ან ელ ფოსტა, მისამართი ატვირთოს პირადი მაიდენთიფიცირებელი დოკუმენტი. ან მიაკითხოს იდენთიფიცირებისათვის შპს ოლ ფეი ვეი-ს სერვის ცენტრს ან შპს ოლ ფეი ვეი ს აგენტების საგადახდო არხებს სალაროებს. სადაც წარადგენს პირადობის დამადასტურებელ დოკუმენტს შეავსებს და მოაწერს ხელს იდენთიფიცირების დოკუმენტს. <b>8.2</b> კონკრეტული საგადახდო მომსახურებაზე შეიძლება დაწესებული იყოს განსხვავებული ხარჯვის ლიმიტი, რაზეც გეცნობებათ უშუალოდ გადასახადის განხორციელებისას. თუ თქვენ ხართ არაიდენტიფიცირებული მომხმარებელი თქვენს ელექტრონულ ანგარიშზე დროის ნებისმიერ მომენტში შეუძლებელია ჩარიცხულ ან  შენახულ იქნეს ელექტრონული ფული.</p>';
        $tbl .= '<p style="margin: 0px;"><b>9. ინფორმაციის დაცვის პოლიტიკა</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>9.1</b> წინამდებარე ინფორმაციის დაცვის პოლიტიკა მოიცავს leaderpay  ვებ-გვერდთან (იგულისხმება „ვებ-გვერდი“, რომელიც განთავსებულია შემდეგ ვებმისამართზე: <span style="color: #0e0ae1;"> www.leaderpay.ge </span> ) დაკავშირებული ინფორმაციის დაცვის საკითხებს. ჩვენ მიზნად ვისახავთ თქვენი ინფორმაციის დაცვას ონლაინ სივრცეში. გთხოვთ, გაეცნოთ წინამდებარე ინფორმაციის დაცვის პოლიტიკას, რათა გაიგოთ, თუ რა ინფორმაციას ვაგროვებთ თქვენგან („მომხმარებელი“) და როგორ ვიყენებთ მას. ინფორმაციის დაცვის პოლიტიკასთან დაკავშირებით დამატებითი კითხვები შეგიძლიათ მოგვწეროთ ელექტრონულ ფოსტაზე <span style="color: #0e0ae1;">info@allpayway.org </span>.</p>';
        $tbl .= '<p style="margin: 0px;"><b>10. მომხმარებლის შესახებ ინფორმაცია და მისი გამოყენების პირობები</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>10.1</b> ვერიფიცირებული ინფორმაცია არის გადამოწმებული ინფორმაცია, რომელიც იძლევა პირის იდენტიფიკაციის საშუალებას. კანონით გათვალისწინებულ შემთხვევაში ჩვენ უფლება გვაქვს მოგთხოვოთ ვერიფიკაციის გავლა, რაც გულისხმობს თქვენს  მიერ სავალდებულო პირადი ინფომაციის შევსებას  რომლის გადამოწმებას ვახდენთ სახელმწიფო სერვისების განვითარების სააგენტოში. 10.2 თქვენგან მიღებული პირადი და არაპირადი საიდენტიფიკაციო ინფორმაციის დამუშავება, რაც გულისხმობს ავტომატური, ნახევრად ავტომატური ან არაავტომატური საშუალებების გამოყენებით თქვენგან მიღებულ მონაცემთა მიმართ შესრულებულ ნებისმიერ მოქმედებას,  თანახმად პერსონალურ მონაცემთა დაცვის შესახებ საქართველოს კანონის მე-5 მუხლის „ა“ პუნქტისა. ყოველივე ზემოაღნიშნული გამიზნულია თქვენთვის გასაწევი მომსახურების გასაუმჯობესებლად. <b>10.3</b> ინფორმაციის განახლება და შეცვლა. შესაძლებელია მხოლოდ კომპანიის სერვის ცენტრებში.</p>';
        $tbl .= '<p style="margin: 0px;"><b>11. იურისდიქცია და დავების გადაწყვეტის წესი.</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>11.1</b> წინამდებარე ხელშეკრულებაზე თანხმობად ითვლება, რომ ხელშეკრულება დადებულია ორივე მხარის მიერ. <b>11.2</b> მხარეთა შორის  დავა გადაწყდება მოლაპარაკების გზით.შეუთანხმებლობის  შემთხვევაში დავა განიხილება საქართველოს კანონმდებლობის შესაბამისად თბილისის საქალაქო სასამართლოში.</p>';
        $tbl .= '<p style="margin: 0px;"><b>12. ხელშეკრულების შეწყვეტა ან პირობების შეცვლა.</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>12.1</b> ხელშეკრულებაში დაგეგემილი ცვლილება ძალაში შედის ხელშეკრულებისთვის დადეგნილი ფორმით (ვებგვერდზე) გამოქვეყნების დღიდან <b>12.2</b> ცვლილებას მიეთითება ვებ გვერდზე განთავსების თარიღი.</p>';
        $tbl .= '<p style="margin: 0px;"><b>12.3</b> ხელშეკრულებაში განხორციელებული  ცვლილება ჩაითვლება თქვენთან შეთანხმებულად, თუ ცვლილების ძალაში შესვლამდე არ შეგვატყობინებთ, რომ არ ეთანხმებით დაგეგმილ ცვლილებებს. <b>12.4</b> თქვენ შეგიძლიათ შეწყვიტოთ ხელშეკრულება ნებისმიერ დროს თქვენთვის შეწყვეტა არ წარმოშობს რაიმე დამატებით ფინანსურ ვალდებულებებს ჩვენს წინაშე. <b>12.5</b> ჩვენ უფლება გვაქვს დავხუროთ საფულეში  თქვენი ანგარიში, იმ შემთხვევაში თუ 1 წლის განმავლობაში არ შეხვალთ თქვენს ანგარიშზე ან/და 1 წლის განმავლობაში არ მოხდება თქვენს ანგარიშზე თანხის დარიცხვა. გაუქმების შესახებ შეტყობინება გამოიგზავნება ანგარიშზე მითითებულ საკონტაქტო ტელეფონის ნომერზე ან/და ელ-ფოსტის მისამართზე.</p>';
        $tbl .= '<p style="margin: 0px;"><b>13. კომპანიის შესახებ ინფორმაცია</b></p>';
        $tbl .= '<p style="margin: 0px;"><b>13.1</b> შპს „ ოლ ფეი ვეი“ საიდენტიფიკაციო კოდი: 400147211 სარეგისტრაციო ნომერი: 0028-9004 საქართველოს ეროვნული ბანკის პრეზიდენტის 2012 წლის 12 ოქტომბრის N90/04 ბრძანებით დამტკიცებული „საგადახდო მომსახურების პროვაიდერის საქართველოს ეროვნულ ბანკში რეგისტრაციისა და რეგისტრაციის გაუქმების წესის“ შესაბამისად.</p>';
        $tbl .= '<p style="margin: 0px;"><b>14. დასკვნითი დებულებები  და თანხმობა</b></p>';
        $tbl .= '<hr>';
        
        $tbl .= "<p style='margin: 0px;'>მე $first_name $last_name პირადი ნომერი: $personal_number დაბადებული $birth_date წინამდებარე დოკუმენტზე ხელის მოწერით ვადასტურებ რომ  გავეცანი და ვეთანხმები შპს `ოლ ფეი ვეი` ის ელექტრონულ საფულეში რეგისტრაციისა და სარგებლობის, კონფიდენციალურობის პოლიტიკის  პირობებს, რომელიც განთავსებულია  პროვაიდერის ვებ გვერდზე: <span style='color: #0e0ae1;'> www.leaderpay.ge </span> შესაბამისად იდენთიფიცირებისა და  საგადახდო მომსახურების გაწევის მიზნით  ვაძლევ  შპს „ოლ ფეი ვეი“–ს, მიიღოს ან მოიპოვოს, დაამუშაოს,  შეინახოს  და კანონმდებლობით განსაზღვრული აუცილებლობის შემთხვევაში გადასცეს მასთან სახელშეკრულებო ურთიერთობაში მყოფ მესამე პირსა და მასთან აფილირებულ პირებს  ჩემი პერსონალური მაიდენთიფიცირებელი მონაცემები.  ასევე ჩემს შესახებ პერსონალური ინფორმაცია  გამოითხოვოს  პროვაიდერთან სახელშეკრულებო ურთიერთობაში მყოფ  მესამე პირსა და მასთან აფილირებულ პირებისგან. თანხმობას ვაცხადებ, რომ შპს „ ოლ ფეი ვეი“-მ კანონმდებლობით დადგენილი წესით, ჩემი იდენტიფიცირებისა და საგადახდო მომსახურების განხორციელების  მიზნით და ამ მიზნის განხორციელებისთვის საჭირო მოცულობით, სსიპ სახელმწიფო სერვისების განვითარების სააგენტოს, შსს-ს, შემოსავლების სამსახურის, ბანკების, მიკროსაფინანსო ორგანიზაციების, სადაზღვევო კომპანიების, მობილური ოპერატორების ასევე კომუნალური მომსახურების მომწოდებელი კომპანიების  მონაცემთა ელექტრონული ბაზიდან მიიღოს, პროვაიდერისათვის  აუცილებელი, ჩემი პერსონალური მონაცემები. მე ვადასტურებ რომ პროვაიდერის ან პროვაიდერის აგენტის ან მასთან სახელშეკრულებო ურთიერთობაში მყოფ მესამე პირის თანამშრომლის  მიერ დეტალურად განმემარტა  ჩემი პერსონალური მონაცემების მოპოვების, შენახვის, გამოყენების მიზნების, ვადის, მოცულობის თაობაზე და ვაცხადებ  თანხმობას  გამოყენებულ იქნას ჩემი პერსონალური მონაცემები ( სახელი, გვარი, პირადი(მაიდენთიფიცირებელი დოკუმენტის) ნომერი, დაბადების თარიღი, დაბადების ადგილი, ტელეფონის ნომერი, ელექტრონული ფოსტის მისამართი) საგადახდო მომსახურების განხორციელების გაუმჯობესების მიზნით. ვეთანხმები მივიღო  შპს „ ოლ ფეი ვეი“-სა და მისი პარტნიორი კომპანიებისგან SMS და ელექტრონული წერილები ჩემს მიერ მითითებულ მობილურ ნომერზე ან/და ელექტრონულ ფოსტაზე,  შპს „ ოლ ფეი ვეი“-ს მომსახურების პირობების შესაბამისად.მე ვადასტურებ რომ ჩემს მიერ მითითებული ყველა მონაცემი  ელექტრონულ საფულეში  რეგისტრაციის დროს და წინამდებარე  დოკუმენტში მითითებული საიდენთიფიკაციო(KYC) კითხვარში მითითებული  მონაცემები არის  ზუსტი. ( (PEP) პოლიტიკურად აქტიური პირი გულისხმობს, საქართველოს ან უცხო ქვეყნის მოქალაქეს, ვისაც უკავია ან ბოლო 1 წლის განმავლობაში ეკავა სახელმწიფო (საჯარო) პოლიტიკური თანამდებობა ან/და ეწევა მნიშვნელოვან სახელმწიფოებრივ და პოლიტიკურ საქმიანობას. პოლიტიკურად აქტიური პირები არიან: სახელმწიფოს მეთაური, მთავრობის ხელმძღვანელი და მთავრობის წევრი, აგრეთვე მათი მოადგილეები, სამთავრობო დაწესებულების ხელმძღვანელი, პარლამენტის წევრი, უზენაესი სასამართლოს წევრი, საკონსტიტუციო სასამართლოს წევრი, სამხედრო ძალების ხელმძღვანელი პირი, ცენტრალური (ეროვნული) ბანკის საბჭოს წევრი, ელჩი, სახელმწიფოს წილობრივი მონაწილეობით მოქმედი საწარმოს ხელმძღვანელი პირი, პოლიტიკური პარტიის (გაერთიანების) ხელმძღვანელი, პოლიტიკური პარტიის (გაერთიანების) აღმასრულებელი ორგანოს წევრი, სხვა მნიშვნელოვანი პოლიტიკური მოღვაწე. ხართ ან იყავით თქვენ ან თქვენი ოჯახის წევრი პოლიტიკურად აქტიური პირი (PEP). ხართ ან ყოფილხართ თუ არა პოლიტიკურად აქტიურ პირთან უშუალო საქმიან ურთიერთობაში, პოლიტიკურად აქტიურ პირთან ერთად ფლობთ ან აკონტროლებთ იურიდიული პირის წილს ან ხმის უფლების მქონე აქციებს ან გაქვთ თუ არა ასეთ პირთან (PEP) სხვაგვარი მჭიდრო კავშირი.";

        $tbl .= '<br>';
        $tbl .= '<br>';

        $tbl .= '<div>';
            $tbl .= '<div style="width:10%;font-size: 8px; float: left;">დიახ';
                $tbl .= '<div style="width: 30px; height: 20px; border: 2px solid #457fe9; margin-right: 100px; display: block; text-align: center">';
                        
                        if ($pep_status == 1) {

                            $tbl .= '<img src="../assets/img/check.png">';

                        }

                $tbl .= '</div>';
            $tbl .= '</div>';

            $tbl .= '<div style="width:10%;font-size: 8px; float: left;">არა ';
                $tbl .= '<div style="width: 30px; height: 20px; border: 2px solid #457fe9; margin-right: 100px; display: block; text-align: center;">';
                        
                        if ($pep_status == 0) {

                            $tbl .= '<img src="../assets/img/check.png">';

                        }

                $tbl .= '</div>';
            $tbl .= '</div>';
            $tbl .= '<div style="clear: both"></div>';
        $tbl .= '</div>';

        $tbl .= '<hr style="margin: 0">';

        $tbl .= '<table align="center" width="100%" cellpadding="0">';
            $tbl .= '<tr>';
                $tbl .= '<td style="width:33.33333%;font-size: 8px; padding-bottom: 10px; padding-top: 10px;">16. მხარეები:  შპს „ოლ ფეი ვეი“ ს/კ 400147211 </td>';
                $tbl .= '<td style="width:33.33333%;font-size: 8px;"></td>';
                $tbl .= '<td style="width:33.33333%;font-size: 8px;">საფულის მომხმარებლის სახელი გვარი</td>';
            $tbl .= '</tr>';

            $tbl .= '<tr>';
                $tbl .= '<td style="width:33.33333%;font-size: 8px; padding-bottom: 10px;">დირექტორი; მ. დემეტრაშვილი </td>';
                $tbl .= '<td style="width:33.33333%;font-size: 8px;">მაიდენთიფიცირებელი leaderpay.ge</td>';
                $tbl .= "<td style='width:33.33333%;font-size: 8px;'>$first_name $last_name</td>";
            $tbl .= '</tr>';

        $tbl .= '</table>';

    $tbl .= '</div>';

    echo $tbl;
