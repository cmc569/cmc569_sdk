<?php
// version 1.16

date_default_timezone_set("Asia/Taipei") ;

require_once __DIR__.'/MessengerBotRequest.php' ;
require_once __DIR__.'/includes/config.php' ;

$bot = new MessengerBotRequest($config['app_id'], $config['secret'], $config['accessToken']) ;

// $userId = '1801052816669282' ;
$userId = '2071599282874662' ;
$one_time_notif_token = '2213987941472402188';

$response = array() ;
$response['key'] = $key ;
// $response['userId'] = $userId ;
$response['one_time_notif_token'] = $one_time_notif_token ;
// $response['tag'] = 'CONFIRMED_EVENT_UPDATE' ;

// typingOn
/*
$response['actionType'] = 'typingOn' ;
*/
##

// markSeen
/*
$response['actionType'] = 'markSeen' ;
*/
##

// text
/*
$response['actionType'] = 'text' ;  //Subscription Messaging
$response['text']['text'] = '你好' ;
$response['text']['persona_id'] = '1422122801271310' ;
*/
##

// quickReply
/*
$response['actionType'] = 'quickReply' ;
$response['quickReply']['text'] = '請指定快速回覆選擇' ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

// quickReply + image, audio, video
/*
$response['actionType'] = 'quickReply' ;
// $response['quickReply']['template']['image']['imageUrl'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
// $response['quickReply']['template']['audio']['audioUrl'] = 'https://linebotclient.azurewebsites.net/images/audio_1801052816669282_15b9103c642a8f.mp3' ;
$response['quickReply']['template']['video']['videoUrl'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

// quickReply + generic
/*
$response['actionType'] = 'quickReply' ;
$response['quickReply']['template']['genericMenu']['image_aspect_ratio'] = 's' ;
$response['quickReply']['template']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',       //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',//optional
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => true),      //optional
    'buttons' => array(                         //optional、max: 3
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

//qucikReply + button
/*
$response['actionType'] = 'quickReply' ;
$response['quickReply']['template']['buttonMenu']['text'] = '顯示的文字' ;
$response['quickReply']['template']['buttonMenu']['buttons'][] = array(
        'type'  => 'url',
        'title' => '網頁',
        'url' => 'https://www.twhg.com.tw',
        'webview_height_ratio' => 'compact',        //optional(compact, tall, full)
        'messenger_extensions' => false,        //optional (use messenger_extensions)
) ;
$response['quickReply']['template']['buttonMenu']['buttons'][] = array(       //qty: 1~3
        'type'  => 'postback',
        'title' => '歡迎11',
        'postback' => 'cat=welcome1',
) ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

// quickReply + list
/*
$response['actionType'] = 'quickReply' ;
$response['quickReply']['template']['listMenu']['top_element_style'] = 'large' ;      //optional(compact, large)、Messenger 網頁用戶端目前只能轉譯 compact。
$response['quickReply']['template']['listMenu']['buttons'] = array(                   //qty: 1
    'title'     => 'view more',
    'type'  => 'postback',
    'postback'    => 'cat=test&item=qoo',
) ;
$response['quickReply']['template']['listMenu']['elements'][] = array(                //qty: 2~4
    'title'     => '主標題1',
    'subtitle'  => '副標題1',                                  //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',

    'buttons' => array(                                                                 //optional
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['quickReply']['template']['listMenu']['elements'][] = array(
    'title'     => '主標題2',
    'subtitle'  => '副標題2',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'buttons' => array(
        array('type'  => 'url', 'title' => '歡迎2', 'url' => 'https://www.accuhit.net'),
    )
) ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

//quickReply + media image, video buttons
/*
$response['actionType'] = 'quickReply' ;
$response['quickReply']['template']['media']['image'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
$response['quickReply']['template']['media']['image'] = '400082100927835' ;
$response['quickReply']['template']['media']['video'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;
$response['quickReply']['template']['media']['video'] = '1008861772781218' ;
$response['quickReply']['template']['media']['buttons'] = array(
    array(
        'type'  => 'url',
        'title' => '點我開始傳保單',
        'url'   => 'https://www.accuhit.net',
        'webview_height_ratio' => 'tall',
        'messenger_extensions' => false,        //optional (use messenger_extensions)
    ),
) ;
$response['quickReply']['persona_id'] = '1422122801271310' ;
$response['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/
##

// buttonMenu
/*
$response['actionType'] = 'buttonMenu' ;
$response['buttonMenu']['persona_id'] = '1422122801271310' ;
$response['buttonMenu']['text'] = '顯示的文字' ;
$response['buttonMenu']['buttons'][] = array(
        'type'  => 'url',
        'title' => '網頁',
        'url' => 'https://www.twhg.com.tw',
        'webview_height_ratio' => 'compact',        //optional(compact, tall, full)
        'messenger_extensions' => false,        //optional (use messenger_extensions)
) ;
$response['buttonMenu']['buttons'][] = array(       //qty: 1~3
        'type'  => 'postback',
        'title' => '歡迎11',
        'postback' => 'cat=welcome1',
) ;
$response['buttonMenu']['buttons'][] = array(       //qty: 1~3
        'type'  => 'phone_number',
        'title' => '打電話',
        'postback' => '+886922123456',
) ;
*/
##

// genericMenu
/*
$response['actionType'] = 'genericMenu' ;
$response['genericMenu']['persona_id'] = '1422122801271310' ;
$response['genericMenu']['image_aspect_ratio'] = 's' ;
$response['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',       //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',//optional
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),      //optional
    'buttons' => array(                         //optional、max: 3
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(  //optional
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
*/
##

// listMenu
/*
$response['actionType'] = 'listMenu' ;
$response['actionType']['persona_id'] = '1422122801271310' ;
$response['listMenu']['top_element_style'] = 'large' ;      //optional(compact, large)、Messenger 網頁用戶端目前只能轉譯 compact。
$response['listMenu']['buttons'] = array(                   //qty: 1
    'title'     => 'view more',
    'type'  => 'postback',
    'postback'    => 'cat=test&item=qoo',
) ;
$response['listMenu']['elements'][] = array(                //qty: 2~4
    'title'     => '主標題1',
    'subtitle'  => '副標題1',                                  //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',

    'buttons' => array(                                                                 //optional
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['listMenu']['elements'][] = array(
    'title'     => '主標題2',
    'subtitle'  => '副標題2',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'buttons' => array(
        array('type'  => 'url', 'title' => '歡迎2', 'url' => 'https://www.accuhit.net'),
    )
) ;
*/
##

// media
/*
$response['actionType'] = 'media' ;
$response['media']['persona_id'] = '1422122801271310' ;
$response['media']['image'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
$response['media']['image'] = '400082100927835' ;
$response['media']['video'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;
$response['media']['video'] = '2525290887555159' ;
$response['media']['buttons'] = array(
    array(
        'type'  => 'url',
        'title' => '點我開始傳保單',
        'url'   => 'https://www.accuhit.net',
        'webview_height_ratio' => 'tall',
        'messenger_extensions' => false,        //optional (use messenger_extensions)
    ),
) ;
*/
##

// image
/*
$response['actionType'] = 'image' ;
$response['image']['persona_id'] = '1422122801271310' ;
$response['image']['imageUrl'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
// $response['image']['imageUrl'] = '400082100927835' ;
*/
##

// audio
/*
$response['actionType'] = 'audio' ;
$response['audio']['persona_id'] = '1422122801271310' ;
$response['audio']['audioUrl'] = 'https://linebotclient.azurewebsites.net/images/audio_1801052816669282_15b9103c642a8f.mp3' ;
// $response['audio']['audioUrl'] = '736671896744823' ;
*/
##

// video
/*
$response['actionType'] = 'video' ;
$response['video']['persona_id'] = '1422122801271310' ;
$response['video']['videoUrl'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;
*/
##

// get user profile
/*
$response['actionType'] = 'profile' ;
$response['profile']['userId'] = $userId ;
*/
##

// clear menu
/*
$response['actionType'] = 'deleteMenu' ;
$response['deleteMenu']['psid'] = '2071599282874662' ;       //指定特定使用者 psid (optional)
*/
##

// set up menu
/*
$response['actionType'] = 'setMenu' ;
$response['setMenu']['input'] = 'Y' ;       //Y/N Y=允許輸入、N=禁止輸入、預設允許輸入
$response['setMenu']['locale'] = 'zh_TW' ;      //指定選單語系 (optional、不指定的預設值為default)
$response['setMenu']['psid'] = '2071599282874662' ;     //指定特定使用者 psid (optional)

$response['setMenu']['menuItem'][] = array('type' => 'postback', 'title' => '聯絡客服', 'postback' => 'cat=service') ;
$response['setMenu']['menuItem'][] = array('type' => 'web_url', 'title' => '公司官網', 'url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall') ;
*/
##

// 貼文回覆至粉絲團
/*
$response['actionType'] = 'feed' ;
$response['feed']['plateform'] = 'P' ;
$response['feed']['comment_id'] = '786147458509821_788718281586072' ;
$response['feed']['message'] = '@['.$userId.'] 機器人回覆你' ;
$response['feed']['image'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
// $response['feed']['image'] = '400082100927835' ;
*/

// 貼文回覆至 Messenger
/*
$response['actionType'] = 'feed' ;
$response['feed']['persona_id'] = '1422122801271310' ;
$response['feed']['plateform'] = 'M' ;      //P/M P=粉絲團、M=messenger
$response['feed']['comment_id'] = '786147458509821_788718281586072' ;
*/

// text
/*
$response['feed']['actionType'] = 'text' ;  //Subscription Messaging
$response['feed']['text'] = '你好' ;
*/

// image
/*
$response['feed']['actionType'] = 'image' ;
$response['feed']['image']['imageUrl'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
*/

// audio
/*
$response['feed']['actionType'] = 'audio' ;
$response['feed']['audio']['audioUrl'] = 'https://linebotclient.azurewebsites.net/images/audio_1801052816669282_15b9103c642a8f.mp3' ;
*/

// video
/*
$response['feed']['actionType'] = 'video' ;
$response['feed']['video']['videoUrl'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;
*/

// button
/*
$response['feed']['actionType'] = 'buttonMenu' ;
$response['feed']['buttonMenu']['text'] = '顯示的文字' ;
$response['feed']['buttonMenu']['buttons'][] = array(
        'type'  => 'url',
        'title' => '網頁',
        'url' => 'https://www.twhg.com.tw',
        'webview_height_ratio' => 'compact',        //optional(compact, tall, full)
        'messenger_extensions' => false,        //optional (use messenger_extensions)
) ;
$response['feed']['buttonMenu']['buttons'][] = array(       //qty: 1~3
        'type'  => 'postback',
        'title' => '歡迎11',
        'postback' => 'cat=welcome1',
) ;
*/

// generic
/*
$response['feed']['actionType'] = 'genericMenu' ;
$response['feed']['genericMenu']['image_aspect_ratio'] = 's' ;
$response['feed']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',       //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',//optional
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),      //optional
    'buttons' => array(                         //optional、max: 3
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['feed']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(  //optional
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['feed']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
*/

// quickReply + text
/*
$response['feed']['actionType'] = 'quickReply' ;
$response['feed']['quickReply']['text'] = '請指定快速回覆選擇' ;
$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://accubot.azurewebsites.net/images/eip_announce.jpg',        //optional
) ;
$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'user_phone_number',
) ;
$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'user_email',
) ;
*/

// quickReply + image, audio, video
/*
$response['feed']['actionType'] = 'quickReply' ;
$response['feed']['quickReply']['template']['image']['imageUrl'] = 'https://linebotclient.azurewebsites.net/images/ticket1.jpg' ;
// $response['feed']['quickReply']['template']['audio']['audioUrl'] = 'https://linebotclient.azurewebsites.net/images/audio_1801052816669282_15b9103c642a8f.mp3' ;
// $response['feed']['quickReply']['template']['video']['videoUrl'] = 'https://linebotclient.azurewebsites.net/images/video_1801052816669282_15b91040406657.mp4' ;

$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',        //optional
) ;
*/

// quickReply + button
/*
$response['feed']['actionType'] = 'quickReply' ;
$response['feed']['quickReply']['template']['buttonMenu']['text'] = '顯示的文字' ;
$response['feed']['quickReply']['template']['buttonMenu']['buttons'][] = array(
        'type'  => 'url',
        'title' => '網頁',
        'url' => 'https://www.twhg.com.tw',
        'webview_height_ratio' => 'compact',        //optional(compact, tall, full)
        'messenger_extensions' => false,        //optional (use messenger_extensions)
) ;
$response['feed']['quickReply']['template']['buttonMenu']['buttons'][] = array(       //qty: 1~3
        'type'  => 'postback',
        'title' => '歡迎11',
        'postback' => 'cat=welcome1',
) ;
$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',        //optional
) ;
*/

// quickReply + generic
/*
$response['feed']['actionType'] = 'genericMenu' ;
$response['feed']['quickReply']['template']['genericMenu']['image_aspect_ratio'] = 's' ;
$response['feed']['quickReply']['template']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',       //optional
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',//optional
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),      //optional
    'buttons' => array(                         //optional、max: 3
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['feed']['quickReply']['template']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(  //optional
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['feed']['quickReply']['template']['genericMenu']['elements'][] = array(
    'title'     => '主標題',
    'subtitle'  => '副標題',
    'image_url'    => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',
    'default_action' => array('url' => 'https://www.accuhit.net', 'webview_height_ratio' => 'tall', 'messenger_extensions' => false),       //optional
    'buttons' => array(
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
        array('type'  => 'postback', 'title' => '歡迎1', 'postback' => 'cat=welcome1'),
    )
) ;
$response['feed']['quickReply']['actions'][] = array(
        'type'  => 'text',
        'title' => '歡迎2',
        'postback' => 'cat=welcome2',
        'image_url' => 'https://linebotclient.azurewebsites.net/images/ticket1.jpg',        //optional
) ;
*/

##

print_r($bot->send($response)) ;

?>