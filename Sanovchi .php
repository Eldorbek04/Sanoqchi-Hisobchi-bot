<?php
ob_start();
define('API_KEY', '8159110288:XXXXX');   //<----------Bot API TOKEN joyi---------->//
$admin = "XXXXX";   //<----------Admin ID raqami---------->//
$mybot = "XXXXX";  //<---------Bot useri @ qo'ymasdan!--------->//
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$text = $message->text;
$mid = $message->message_id;
$chat_id = $message->chat->id;
$user_id = $message->from->id;
$ufname = $update->message->from->first_name;
$type = $message->chat->type;
$title = $message->chat->title;
$repid = $message->reply_to_message->from->id;
$repmid = $message->reply_to_message->message_id;
$repufname = $message->reply_to_message->from->first_name;
$left = $message->left_chat_member;
$new = $message->new_chat_member;
$leftid = $message->left_chat_member->id;
$newid = $message->new_chat_member->id;
$newufname = $message->new_chat_member->first_name;
$soat = date('H:i:s', strtotime('5 hour'));
$sana = date('d-m-Y',strtotime('5 hour'));
mkdir("UzStarTM");
mkdir("RayimjonovEldorbek");
mkdir("RayimjonovEldorbek/$chat_id");
$UzStarTM = file_get_contents("RayimjonovEldorbek/$chat_id/$user_id.txt");
$step = file_get_contents("UzStarTM/$chat_id.step");
$guruhlar = file_get_contents("UzStarTM/Guruh.lar");
$userlar = file_get_contents("UzStarTM/User.lar");
if(isset($message)){
  if($type == "group" or $type == "supergroup"){
    if(stripos($guruhlar,"$chat_id")!==false){
    }else{
    file_put_contents("UzStarTM/Guruh.lar","$guruhlar\n$chat_id");
    }
  }else{
   $userlar = file_get_contents("UzStarTM/User.lar");
   if(stripos($userlar,"$chat_id")!==false){
    }else{
    file_put_contents("UzStarTM/User.lar","$userlar\n$chat_id");
   }}}
if($text == "/start" or $text == "/start@$mybot"){
bot('sendMessage',[
'chat_id'=>$chat_id,
'text'=> "🤖 Botga xush kelibsiz, <a href='tg://user?id=$user_id'>$ufname</a> !

🌐 Men guruhga kim qancha odam qo'shganligini aytib beruvchi robotman. Meni admin qilib tayinlashga unutmang!

✅ <b>Robot qat'iy ravishda guruhlarda ishlaydi!</b>",
'parse_mode' => 'html',
'disable_web_page_preview'=>true,
  'reply_markup'=>json_encode([   
   'inline_keyboard'=>[
       [['text'=>'Slayd va Mustaqil ishlar 📃','url'=>'t.me/talabalar_forumi'],],
       [['text'=>'Dasturchi 👨‍💻','url'=>'t.me/rayimjonov_eldorbek'],],
]   
]),
]);
}
if($left){
  bot('deletemessage',[
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
  unlink("RayimjonovEldorbek/$chat_id/$leftid.txt");
}
if($new){
  bot('deletemessage',[
    'chat_id'=>$chat_id,
    'message_id'=>$mid
  ]);
  bot('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>"<b>👋Salom</b> <a href='tg://user?id=$newid'>$newufname</a> Gruppamizga xush kelibsiz! Bizning guruximizga odam qo'shib TEKIN Slayd va Mustaqil ish yozdirishingiz mumkin. Bir dona Slayd va Mustaqil ish ucun 15ta odam qo'shishingiz kerak. Guruxga odam qoshganingizdan so'ng shu  /mymembers so'zni yuboring🎉",
    'parse_mode'=>'html'
   ]);
  $add = $UzStarTM + 1;
  file_put_contents("RayimjonovEldorbek/$chat_id/$user_id.txt","$add");
}
if($text == "/mymembers" or $text == "/mymembers@$mybot"){
if($UzStarTM==true){
  bot('sendmessage',[    
    'chat_id'=>$chat_id, 
    'reply_to_message_id'=>$mid,  
    'parse_mode'=>'html',   
    'text'=>"<a href='tg://user?id=$user_id'>$ufname</a> 
🔹Siz $UzStarTM ta odam qo'shgansiz!",
  ]);   
}else{
bot("sendMessage",[
"chat_id"=>$chat_id,
 'reply_to_message_id'=>$mid,  
    'parse_mode'=>'html',   
"text"=>"<a href='tg://user?id=$user_id'>$ufname</a> 
❌Siz hali odam qo'shmadingiz!",
]);
}}
if($text == '/code' and $chat_id == $admin){
bot('sendDocument',[
'chat_id'=>$chat_id,
'reply_to_message_id'=>$mid,
'document'=>new CURLFile(__FILE__),
'caption'=>"@$mybot <b>code</b>", 
'parse_mode'=>"html",
]);
} 
if($text=="/stat"){
$gr = substr_count($guruhlar,"\n"); 
$us = substr_count($userlar,"\n"); 
$all = $gr + $us;
bot('sendmessage',[
'chat_id'=>$chat_id,
'reply_to_message_id'=>$mid,
'text'=>"<b>📊Bot foydalanuvchilari:
👤 Foydalanuvchilar: $us ta
👥 Guruhlar: $gr ta
🔃Hammasi: $all ta
📅 $sana $soat
❇️</b> @hisobchi_formbot",
'parse_mode'=>"html"
]);
} 
?>