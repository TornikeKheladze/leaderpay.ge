<?php

class Limit {

    public $db;

    public function __construct(db $db) {
        $this->db = $db;
    }

    /**
     * user limit
     * @param string  $wallet_number
     * @param string  $amount
     * @return array
     */
    public function Check($wallet_number, $amount, $currency_id = 981) {

        $json = [
            'errorCode' => 1,
            'errorMessage' => 'წარმატებული',
        ];

        $limitAllowMonth = $this->db->getSql("SELECT amount FROM `user_limit_allow` WHERE wallet_number = '$wallet_number' AND currency_id = '$currency_id' AND type = 'month'");
        $limitAllowMonth = @$limitAllowMonth['amount'];
        $limitAllowDay = $this->db->getSql("SELECT amount FROM `user_limit_allow` WHERE wallet_number = '$wallet_number' AND currency_id = '$currency_id' AND type = 'day'");
        $limitAllowDay = @$limitAllowDay['amount'];
        $limitAllowOne = $this->db->getSql("SELECT amount FROM `user_limit_allow` WHERE wallet_number = '$wallet_number' AND currency_id = '$currency_id' AND type = 'one'");
        $limitAllowOne = @$limitAllowOne['amount'];

        $risk = $this->db->getSql("SELECT level_of_risk FROM `users` WHERE personal_number = '$wallet_number'");
        $risk = $risk['level_of_risk'];

        if ($risk > 7) {

            $limitMonth = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'month' AND risk = '3' AND currency_id = '$currency_id'");
            $limitMonth = @$limitMonth['amount'];
            $limitDay = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'day' AND risk = '3' AND currency_id = '$currency_id'");
            $limitDay = @$limitDay['amount'];
            $limitOne = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'one' AND risk = '3' AND currency_id = '$currency_id'");
            $limitOne = @$limitOne['amount'];

        } else {

            $limitMonth = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'month' AND risk = '1' AND currency_id = '$currency_id'");
            $limitMonth = @$limitMonth['amount'];
            $limitDay = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'day' AND risk = '1' AND currency_id = '$currency_id'");
            $limitDay = @$limitDay['amount'];
            $limitOne = $this->db->getSql("SELECT amount FROM `user_limits` WHERE type = 'one' AND risk = '1' AND currency_id = '$currency_id'");
            $limitOne = @$limitOne['amount'];

        }

        $limitMonth = ($limitAllowMonth) ? $limitAllowMonth : $limitMonth;
        $limitDay = ($limitAllowDay) ? $limitAllowDay : $limitDay;
        $limitOne = ($limitAllowOne) ? $limitAllowOne : $limitOne;

        $date = $this->db->get_current_date();
        $currentDate = date('Y-m-d', strtotime($date));
        $currentYear = date('Y', strtotime($date));
        $currentMonth = date('m', strtotime($date));

        $amountMonth = $this->db->getSql("SELECT SUM(debt) AS amount FROM `user_balance_history` WHERE personal_number = '$wallet_number' AND YEAR(date) = '$currentYear' AND MONTH(date) = '$currentMonth' AND currency_id = '$currency_id'");
        $amountMonth = @$amountMonth['amount'];

        $amountDay = $this->db->getSql("SELECT SUM(debt) AS amount FROM `user_balance_history` WHERE personal_number = '$wallet_number' AND DATE(date) = '$currentDate' AND currency_id = '$currency_id'");
        $amountDay = @$amountDay['amount'];

        $month = $amount + $amountMonth;
        $day = $amount + $amountDay;

        // month
        if ($month > $limitMonth) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => "მომხმარებელმა გადააჭარბა თვის ლიმიტს. თვის ლიმიტი შეადგენს $limitMonth ლარს",
            ];
        }

        // day
        if ($day > $limitDay) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => "მომხმარებელმა გადააჭარბა დღის ლიმიტს. დღის ლიმიტი შეადგენს $limitDay ლარს",
            ];
        }

        // one
        if ($amount > $limitOne) {

            $json = [
                'errorCode' => 0,
                'errorMessage' => "ერთჯერადი გადასახდელი თანხა შეადგენს $limitOne ლარს",
            ];
        }

        return $json;

    }
}
