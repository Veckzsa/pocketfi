<?php
/* @RiyanCoday 24/05/2024 */
/* seed tools */
error_reporting(0);
date_default_timezone_set('Asia/Jakarta');
function subs($token) {
$url = "https://bot.pocketfi.org/confirmSubscription";

$headers = [
    "Accept: */*",
    "Accept-Language: en-US,en;q=0.9",
    "Connection: keep-alive",
    "Origin: https://pocketfi.app",
    "Referer: https://pocketfi.app/",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36 Edg/124.0.0.0",
    'telegramRawData: '.$token.''
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

return curl_exec($ch);

curl_close($ch);
}

echo "============================================================================\n";
echo "1. Subs channel tele\n";
echo "============================================================================\n";
$pilih = readline("Masukan Pilihan : ");

$tokens = file('trd.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

foreach ($tokens as $index => $token) {
    $acc = $index + 1;
    $date = date('d-m-Y H:i:s');
	if ($pilih == 1) {
        $subs = subs($token);
		 echo "Account $acc => $subs" . PHP_EOL;
    }else{
	exit();
	}
    echo "========" . PHP_EOL;
}
?>
