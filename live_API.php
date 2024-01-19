<?php
while ($x <= $limit_second) {
    // sleep(1);
    $retrieve_api = curl("https://api.rekeningku.com/v2/price"); // perlu di update
    $result = json_decode($retrieve_api, true);

    $h = 0;
    $l = 0;
    $Market_High = '';
    $Market_Low = '';
    foreach ($result as $tickers => $t) {
        $Nama = $t['n'];
        // $Id_Market = $t['id'];  // Id dari Rekeningku.com
        $Code_Coin = $t['cd'];
        $Close_Price = $t['c'];
        // $Last_Transaction = $t['tt'];
        $High = $t['h'];
        $Low = $t['l'];
        //$Open = $t['o'];
        //$Volume = $t['v'];
        //$Change_Percentage = $t['cp'];
        //$Market_Cap = $t['mk'];
        // $st = $t['st']; // Security Key ???

        if ($Close_Price == $High) {
            $h++;
            $Market_High .= "\n[$h] $Nama - $Code_Coin";
        }
        if ($Close_Price == $Low) {
            $l++;
            $Market_Low .= "\n[$l] $Nama - $Code_Coin";
        }
    }
    send_to_user("pull", "======== ($x) ========\n〽️ List Market High :\n $Market_High\n\n〽️ List Market Low :\n $Market_Low");
    $x++;
};
