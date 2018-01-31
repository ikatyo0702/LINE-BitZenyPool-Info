<?php

/*外部から参照*/
require "function.php";

/*---ここからLINEAPI(関数は別ファイルに書いてる)---*/
$accessToken = "(Token)";

/*---ここから定義---*/
$json_string = file_get_contents('php://input');
$json_array = json_decode($json_string,true);
$event = $json_array["events"]["0"];
$message_type = $event["message"]["type"];
$event_type = $event["type"];
$replyToken = $event["replyToken"];
$text = $event["message"]["text"];
$user_id = $event["source"]["userId"];
$contacts = $json_array["contacts"]["0"];
$name = GetName($user_id, $accessToken);
$TopPic = TopPic($user_id, $accessToken);
$StatusMessage = StatusMessage($user_id, $accessToken);
$type = $event["source"]["type"];
$server_url = "(FileURL)";
/*---ここまで---*/

//Group参加時処理。
if($event_type === "join") {
    $ID = $event["source"]["groupId"];
    $file = ($ID.".txt");
    touch("Group/".$file);
    $message = "Hey!!招待ありがとうございます!\n#helpでこのBotの使い方が見れます。";
    Reply($replyToken, $message, $accessToken);
}

if ($message_type === "text") {
    $text = $event["message"]["text"];
    switch ($text) {
        case "#help":
        	$message1 = "#menu\nメニューを表示します\n\n#bye\nグループから退会します(グループ専用コマンド)";
        	$message2 = "#LAPool\nLA BitZeny Poolのプール情報を表示します\n\n#bunnycoin\nうさぎコイン発掘所のプール情報を表示します";
        	$message3 = "#bitzenypool\n寛永通宝のプール情報を表示します";
        	$message4 = "#MisoSoupool\nみそスープールのプール情報を表示します";
        	$message5 = "開発者への問い合わせはTwitterにお願いします。\nhttps://twitter.com/ikatyo0702";
            ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;

        case "#bye":
            if ($type === "group"){
                $ID = $event["source"]["groupId"];
                $file = ($ID.".txt");
                unlink("Group/".$file);
                $message = "バイバイ(´；ω；`)ｳｯ…\nまた招待してね|ω・*)";
                Reply($replyToken, $message, $accessToken);
                Leave($ID, $accessToken);
            }else{
                $message = "グループ専用コマンドです!!";
                Reply($replyToken, $message, $accessToken);
            }
        break;

        case "#menu":
	        $temp_msg = [
	        	"type" => "template",
	            "altText" => "Pool選択",
	            	"template" => [
	               		"type" => "carousel",
	               		"columns" => [
	                       	[
	                           	"thumbnailImageUrl" => $server_url."/image/menu.png",
	                           	"title" => "Pool選択メニュー Page1",
	                           	"text" => "情報を見たいPoolを選択して下さい",
	                       		"actions" => [
	                           	    [
	                               	    'type' => 'message',
	                                   	'label' => 'LA Pool',
	                                   	'text' => '#LAPool'
	                               	],
	                               	[
	                                   	'type' => 'message',
	                                   	'label' => 'うさぎコイン発掘所',
	                                   	'text' => '#bunnycoin'
	                               	],
	                               	[
	                                   	'type' => 'message',
	                                   	'label' => '寛永通宝',
	                                   	'text' => '#bitzenypool'
	                               	]
	                           	]//action exit
	                       	],
	                       	[
	                           	"thumbnailImageUrl" => $server_url."/image/menu.png",
	                           	"title" => "Pool選択メニュー Page2",
	                           	"text" => "情報を見たいPoolを選択して下さい",
	                       		"actions" => [
	                               	[
	                                   	'type' => 'message',
	                                   	'label' => 'みそスープール',
	                                   	'text' => '#MisoSoupool'
	                               	],
	                               	[
	                                   	'type' => 'message',
	                                   	'label' => '=====',
	                                   	'text' => '====='
	                               	],
	                               	[
	                                   	'type' => 'message',
	                                   	'label' => 'ヘルプ',
	                                   	'text' => '#help'
	                               	]
	                           	]//action exit
	                       	]
	               		]//columns exit
	            	]
	        ];
	        ReplyConfirm($replyToken,$accessToken,$temp_msg);
        break;

        case "#LAPool":
	        $url = "https://lapool.me/bitzeny/index.php?page=api&action=public";
			$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/lapool.php\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;

        case "#bunnycoin":
        	$url = "http://bunnymining.work/bitzeny/index.php?page=api&action=public";
        	$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/bunnycoin.php\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;

        case "#bitzenypool":
        	$url = "https://portal.bitzenypool.work/index.php?page=api&action=public";
        	$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/bitzenypool.php\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;

        case "#MisoSoupool":
        	$url = "https://soup.misosi.ru/index.php?page=api&action=public";
        	$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/soupmisosi.php\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;

        case "#TEST":
        	$url = "https://soup.misosi.ru/index.php?page=api&action=public";
        	$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/soupmisosi.php\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        	$message = "[Test]\n[Poolハッシュレート]**".$hashrate."**";
        	PostDiscord($message);
        break;

        /*追加用テンプレ
        case "":
        	$url = "";
        	$path = file_get_contents($url);
			$data = json_decode($path, true);
			if($data["hashrate"] != false){
				$hashrate = $data["hashrate"]." Khash";
			}else{
				$hashrate = "取得不可";
			}
        	$message1 = "[Pool名]\n".$data["pool_name"]."\n\nWeb版はこちら\nhttps://bitzenypoolinfo.ikatyo.net/(入れ替え)\n\n[データ取得時刻]\n".date("Y/m/d H:i:s");
        	$message2 = "[Poolハッシュレート]\n".$hashrate;
        	$message3 = "[Poolラストブロック]\n".$data["last_block"];
        	$message4 = "[ネットワークハッシュレート]\n".$data["network_hashrate"];
        	$message5 = "[Poolワーカー数]\n".$data["workers"];
        	ReplyFive($replyToken, $message1, $message2, $message3, $message4, $message5, $accessToken);
        break;
        */

        default:
        exit;
    }
}

