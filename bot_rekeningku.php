<?php
restart:
define('BOT_TOKEN', "2048374543:AAHA3AFgWvJhm0cPeC94KWagpDpXUWalDQU");
//$token = "2048374543:AAHA3AFgWvJhm0cPeC94KWagpDpXUWalDQU";
//$Rekeningku_URL = "http://rekeningku.sinau.site/";
$URL = "https://api.telegram.org/bot" . BOT_TOKEN;

$update = json_decode(file_get_contents("php://input"), TRUE);

require "CURL_API_Rekeningku.php";

function send_to_user($menu, $feedback_response)
{
  global $URL;
  global $chatId;
  file_get_contents($URL . "/sendmessage?chat_id=" . $chatId . "&text=" . urlencode($feedback_response));
}

function Simpl($rp)
{
  $simp = ['', '', 'Ribu', 'Juta', 'Milyar', 'Trilyun', 'Kuadriliun'];
  $input = explode(".", $rp); // into index
  return $input[0] . (count($input) > 1 ? ',' . round($input[1] / 10) : '') . ' ' . $simp[count($input)];
}


if (isset($update)) {
  $chatId = $update["message"]["chat"]["id"];
  $username = $update["message"]["chat"]["username"];
  $message = $update["message"]["text"];

  $retrieve_api = curl("https://api.rekeningku.com/v2/price"); // perlu di update
  $result = json_decode($retrieve_api, true);

  switch ($message) {
    case "/start":
      send_to_user("start", "😺 Halo @$username ! \n👋 Selamat datang di Bot Rekeningku_DW \n[ / ] Pilih Menu Command yang tersedia untuk menjalankan Bot");
      break;
    case "/info":
      $i = 0;
      foreach ($result as $tickers => $t) {
        $i++;
        $Nama = $t['n'];
        // $Id_Market = $t['id'];  // Id dari Rekeningku.com
        $Code_Coin = $t['cd'];
        $Close_Price = number_format($t['c'], 2, ',', '.');
        // $Last_Transaction = $t['tt'];
        $High = number_format($t['h'], 2, ',', '.');
        $Low = number_format($t['l'], 2, ',', '.');
        $Open = number_format($t['o'], 2, ',', '.');
        $Volume = number_format($t['v'], 2, ',', '.');
        $Change_Percentage = $t['cp'];
        $Market_Cap = number_format($t['mk'], 2, ',', '.');
        // $st = $t['st']; // Security Key ???
        $List_Assets = "\n[$i] ======== $Nama ========\nCode_Coin : $Code_Coin\nClose Price = $Close_Price\nHigh : $High\nLow : $Low\nOpen : $Open\nVolume : $Volume\nChange Percentage : $Change_Percentage\nMarket Cap : $Market_Cap\n================================\n";
        send_to_user("info", "\n $List_Assets");
      }
      send_to_user("info", "\n ✅ tampilan info asset selesai...");
      break;
    case "/pull":
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
      send_to_user("pull", "〽️ List Market High :\n $Market_High");
      send_to_user("pull", "〽️ List Market Low :\n $Market_Low");
      send_to_user("info", "\n ✅ tampilan data high and low selesai...");
      break;
    case "/push":
      send_to_user("push", "⚠️ No Action...");
      break;
    case "/s":
      $sisi = 3;
      $hasil1 = (int)$sisi * (int)$sisi * (int)$sisi;
      $sisi = strval($sisi);
      send_to_user("push", "$sisi");
      break;
    case "/range":
      $List_Market = '';
      $i = 0;
      foreach ($result as $tickers => $t) {
        $i++;
        $Nama = $t['n'];
        // $Id_Market = $t['id'];  // Id dari Rekeningku.com
        $Code_Coin = $t['cd'];
        $Close_Price = $t['c'];
        $Last_Transaction = $t['tt'];
        $Indicator = ($Last_Transaction == 1 ? "Buy" : "Sell");
        $High = $t['h'];
        $Low = $t['l'];
        $Open = $t['o'];
        $Volume = $t['v'];
        $Change_Percentage = $t['cp'];
        $Market_Cap = $t['mk'];
        // $st = $t['st']; // Security Key ???

        $Range_Value = Intval($High - $Low);
        $Top_Value = Intval($High - $Close_Price);
        $Lower_Zero = false;
        $Lower_Value = (Intval($Close_Price - $Low) == 0 ? $Lower_Zero = true : Intval($Close_Price - $Low));
        ($Lower_Zero == true ? $Lower_Value =  0.00001 : $Lower_Zero = false);
        $Range_Percentage = ($Range_Value / $Lower_Value) * 100;
        $Top_Percentage = ($Top_Value / $Range_Value) * 100;
        $Lower_Percentage = ($Lower_Zero == true ? ($Lower_Value / $Range_Value) * 100 : ($Lower_Value / $Range_Value) * 100);

        $List_Market = "\n[$i] ======== $Nama ========\nCode_Coin : $Code_Coin\nRange_V : " . number_format($Range_Value, 2, ',', '.') . "\nTop_V : " . number_format($Top_Value, 2, ',', '.') . "\nLower_V : " . number_format($Lower_Value, 2, ',', '.') . "\nRange_P : $Range_Percentage %\nTop_P : $Top_Percentage %\nLower_P : $Lower_Percentage %\nLast_Transaction : $Indicator\n================================\n";
        send_to_user("range", "$List_Market");
      }
      send_to_user("info", "\n ✅ tampilan data range selesai...");
      break;
    case "/about":
      send_to_user("about", "About Bot Rekeningku_DW : \n---------------------------------------------------------------\n💹 Bot sebagai pemenuhan tugas kuliah\n\n </> RifkyA911");
      break;
    case "/live":
      $x = 1;
      $limit_second = 30; // 30 second
      require "live_API.php";
      send_to_user("info", "\n ✅ tampilan live data high and low selesai...");
      break;
    default:
      file_get_contents($URL . "/sendmessage?chat_id=" . $chatId . "&text=Maaf @$username, sepertinya input yang anda masukan salah/tidak sesuai command yang tersedia... 😸");
  }
}
