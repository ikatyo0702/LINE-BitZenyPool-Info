<?php
function Reply($replyToken, $message, $accessToken){
    $Post_Data = [
        "replyToken" => $replyToken,
        "messages" => [
            [
                "type" => "text",
                "text" => $message
            ]
        ]
    ];
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Post_Data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

function ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken){
    $Post_Data = [
        "replyToken" => $replyToken,
        "messages" => [
            [
                "type" => "text",
                "text" => $message1
            ],
            [
                "type" => "text",
                "text" => $message2
            ],
            [
                "type" => "text",
                "text" => $message3
            ],
            [
                "type" => "text",
                "text" => $message4
            ],
            [
                "type" => "text",
                "text" => $message5
            ],
        ]
    ];
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Post_Data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

function ReplyConfirm($replyToken,$accessToken,$temp_msg){
// 返送情報の作成と送信
$Post_Data = [
    'replyToken' => $replyToken,
    'messages' => [$temp_msg]
];
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Post_Data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

function ReplyImage($replyToken, $accessToken, $ImagePath, $Preview){
    $Post_Data = [
        "replyToken" => $replyToken,
        "messages" => [
            [
                "type" => "image",
                "originalContentUrl" => $ImagePath,
                "previewImageUrl" => $Preview
            ]
        ]
    ];
    $ch = curl_init("https://api.line.me/v2/bot/message/reply");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Post_Data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charser=UTF-8',
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    curl_close($ch);
}

function GetName($user_id, $accessToken){
    $url = "https://api.line.me/v2/bot/profile/".$user_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    $json_array = json_decode($result, true);
    $name = $json_array["displayName"];
    return $name;
    curl_close($ch);
}

function Leave($group_id, $accessToken){
    $url = "https://api.line.me/v2/bot/group/".$group_id."/leave";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
}

function Push($accessToken){
    $url = "https://api.line.me/v2/bot/group/".$group_id."/leave";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
}

function TopPic($user_id, $accessToken){
    $url = "https://api.line.me/v2/bot/profile/".$user_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    $json_array = json_decode($result, true);
    $TopPic = $json_array["pictureUrl"];
    return $TopPic;
    curl_close($ch);
}

function StatusMessage($user_id, $accessToken){
    $url = "https://api.line.me/v2/bot/profile/".$user_id;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $accessToken
    ));
    $result = curl_exec($ch);
    $json_array = json_decode($result, true);
    $StatusMessage = $json_array["statusMessage"];
    return $StatusMessage;
    curl_close($ch);
}
