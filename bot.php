<?php


$config = [
    'simsimi' => [
        // 'endpoint' => 'http://api.simsimi.com/request.p',    // paid key
        'endpoint' => 'http://sandbox.api.simsimi.com/request.p',   // trial key
        'token'    => '9051c54a-ec44-4e5b-ab45-454ccbbae029',
        'locale'   => 'vn'    // View locale support at http://developer.simsimi.com/lclist.
    ]
];

function talkToSimsimi($text) {
    global $config;
    $json = curl($config['simsimi']['endpoint']
            ."?key=".$config['simsimi']['token']
            ."&lc=".$config['simsimi']['locale']
            ."&ft=1.0&text=".urlencode($text));
    $arr = json_decode($json, true);
    if(empty($arr['response'])) {
        // This trial api will have less db. Use paid key for full db. I don't try so I don't know it worth or not?
        $arr['response'] = "[Simsimi not response.]";
    }
    return $arr['response'];
}

if (!empty($_GET)) {
	$text = $_GET["message"];
}else{
	$text = "hello";
}

echo talkToSimsimi($text);

?>