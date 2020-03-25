<?php

$API_URL = 'https://api.line.me/v2/bot/message/reply';
$ACCESS_TOKEN = 'A0f+HXQ2PRu6GZAc9Nj71r9FynDYpA6BM5anXNbjP8UMn/Jfg51wWb2wiNlneOo+rLqg1f5nZus7c8EZrhgVXdIdFQybGeG8pwhXqB50snd1vIvkgduIv7C6i/3qSAiUsJxVBNJpOnK48CxmiTp+OAdB04t89/1O/w1cDnyilFU='; // Access Token ค่าที่เราสร้างขึ้น
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

if ( sizeof($request_array['events']) > 0 )
{

 foreach ($request_array['events'] as $event)
 {
  $reply_message = '';
  $reply_token = $event['replyToken'];

  if ( $event['type'] == 'message' ) 
  {
   
   if( $event['message']['type'] == 'text' )
   {
		$text = $event['message']['text'];
		
		if(($text == "อยากทราบยอด COVID-19 ครับ")||($text == "COVID19")||($text == "COVID-19")){
			$all = 5555555;
			$dead = 555;
			$heal = 555555;
			$reply_message = '"รายงานสถานการณ์ ยอดผู้ติดเชื้อไวรัสโคโรนา 2019 (COVID-19) ในประเทศไทย"
ผู้ป่วยสะสม	จำนวน '.$all. ' ราย
ผู้เสียชีวิต	จำนวน '.$dead. ' ราย
รักษาหาย	จำนวน '.$heal. ' ราย
ผู้รายงานข้อมูล: นายสุภณัฐ ธนวรพัฒน์'
;
		}
		else if(($text== "ข้อมูลส่วนตัวของผู้พัฒนาระบบ")||($text== "ข้อมูล")||($text== "ข้อมูลส่วนตัว")||($text== "ข้อมูลผู้พัฒนา")){
			$reply_message = 'ชื่อนายสุภณัฐ ธนวรพัฒน์ รหัสนิสิต 59160703 อายุ 22 ปี น้ำหนัก 80kg. สูง 178 cm. ขอเกรดสวยๆนะครับ !!!';
		}
		else
		{
			$reply_message = 'ระบบได้รับข้อความ ('.$text.') ของคุณแล้ว';
    		}
   
   }
   else
    $reply_message = 'ระบบได้รับ '.ucfirst($event['message']['type']).' ของคุณแล้ว';
  
  }
  else
   $reply_message = 'ระบบได้รับ Event '.ucfirst($event['type']).' ของคุณแล้ว';
 
  if( strlen($reply_message) > 0 )
  {
   //$reply_message = iconv("tis-620","utf-8",$reply_message);
   $data = [
    'replyToken' => $reply_token,
    'messages' => [['type' => 'text', 'text' => $reply_message]]
   ];
   $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

   $send_result = send_reply_message($API_URL, $POST_HEADER, $post_body);
   echo "Result: ".$send_result."\r\n";
  }
 }
}

echo "OK";

function send_reply_message($url, $post_header, $post_body)
{
 $ch = curl_init($url);
 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
 $result = curl_exec($ch);
 curl_close($ch);

 return $result;
}

?>
