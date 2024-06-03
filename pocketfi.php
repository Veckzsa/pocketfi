<?php
/* @RiyanCoday 23/05/2024 */
/* auto mining */
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
function cdy($url, $telegramRawData) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        "Accept: */*",
        "Connection: keep-alive",
        "Origin: https://pocketfi.app",
        "Referer: https://pocketfi.app/",
        "telegramRawData: " . $telegramRawData
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    if ($url == "https://bot.pocketfi.org/mining/claimMining") {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
    }
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}


while (true) {
	$telegramRawDataList = file('trd.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($telegramRawDataList as $index => $telegramRawData) {
        $telegramRawDataId = $index + 1;
        $checkMining = cdy("https://rubot.pocketfi.org/mining/getUserMining", $telegramRawData);
        $jsCM = json_decode($checkMining, true);
        $date = date('d-m-Y H:i:s');

        if (isset($jsCM['userMining'])) {
            if ($jsCM['userMining']['miningAmount'] > 0) {
                $claim = cdy("https://bot.pocketfi.org/mining/claimMining", $telegramRawData);
                $jsC = json_decode($claim, true);
                if (isset($jsC['userMining']) && $jsC['userMining']['gotAmount'] > 1) {
                    echo "\033[32m[$date] Account $telegramRawDataId: Success Claim " . $jsCM['userMining']['miningAmount'] . ", [Mined: " . $jsC['userMining']['gotAmount'] . "] \033[0m\n";
                } else {
                    echo "\033[33m[$date] Account $telegramRawDataId: Fail Claim " . $jsCM['userMining']['miningAmount'] . " \033[0m\n";
                }
            } else {
                echo "\033[31m[$date] Account $telegramRawDataId: [Speed: " . $jsCM['userMining']['speed'] . ", Mined: " . $jsCM['userMining']['gotAmount'] . "], Please wait...\033[0m\n";
            }
        } else {
            echo "\033[31m[$date] Account $telegramRawDataId: Invalid response, try again...\033[0m\n";
        }
    }
	echo "\033[34m========\033[0m\n";

}
?>
