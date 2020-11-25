<?php
//version 1.18

date_default_timezone_set("Asia/Taipei") ;

require_once __DIR__.'/LineBotRequest.php' ;
require_once __DIR__.'/includes/config.php' ;
require_once __DIR__.'/includes/function.php' ;

$userId = 'U62e7e4ca0ad872f7d38c603757f8fb7f' ;
$replyToken = '';

$bot = new LineBotRequest($config['id'], $config['secret'], $config['accessToken']) ;

$response = array() ;
$response['reply_token'] = $replyToken ;
$response['userId'] = $userId ;
// $response['userId'] = [$userId, $userId] ;
// $response['userId'] = 'broadcast' ;

/* get group summary
$target_token = 'Cb536914f4ce86a2ce1d98379ed89f1a6' ;
$response['messages'][0]['actionType'] = 'groupSummary' ;
$response['messages'][0]['groupSummary'] = $target_token ;
*/

/* profile 
$target_token = 'U62e7e4ca0ad872f7d38c603757f8fb7f' ;
$response['messages'][0]['actionType'] = 'profile' ;
$response['messages'][0]['profile'] = $target_token ;
*/

/* group profile */
// $target_token = 'Uab68d4fe3199f69c54ab80098351ed5f' ;
// $groupId = 'C14aa7da4676bd5fb7fab05bb1e3e048b' ;
// $response['messages'][0]['actionType'] = 'memberProfile' ;
// $response['messages'][0]['memberProfile']['userId'] = $target_token ;
// $response['messages'][0]['memberProfile']['groupId'] = $groupId ;

/* room profile */
// $target_token = 'Uab68d4fe3199f69c54ab80098351ed5f' ;
// $roomId = 'C14aa7da4676bd5fb7fab05bb1e3e048b' ;
// $response['messages'][0]['actionType'] = 'roomProfile' ;
// $response['messages'][0]['roomProfile']['userId'] = $target_token ;
// $response['messages'][0]['roomProfile']['roomId'] = $roomId ;


/* group summary */ 
// $target_token = 'U62e7e4ca0ad872f7d38c603757f8fb7f' ;
// $response['messages'][0]['actionType'] = 'groupSummary' ;
// $response['messages'][0]['groupId'] = $target_token ;



// ===================================================== //
/* quickReply 
$response['messages'][1]['actionType'] = 'quickReply' ;
$response['messages'][1]['sender']['name'] = '愛酷' ;
$response['messages'][1]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;


//text
$response['messages'][1]['quickReply']['text'] = '測試快速回覆選擇' ;
##

//sticker
$response['messages'][1]['quickReply']['sticker']['packageId'] = 1 ;
$response['messages'][1]['quickReply']['sticker']['stickerId'] = 1 ;
##

//image
$response['messages'][1]['quickReply']['image']['imageUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
$response['messages'][1]['quickReply']['image']['previewUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
##

//video
$response['messages'][1]['quickReply']['video']['videoUrl'] = 'https://linebotclient.accunix.net/images/video_1801052816669282_15b91040406657.mp4' ;
$response['messages'][1]['quickReply']['video']['previewUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
$response['messages'][1]['quickReply']['video']['trackingId'] = '123456' ;
##

//audio
$response['messages'][1]['quickReply']['audio']['audioUrl'] = 'https://linebotclient.accunix.net/images/audio_1801052816669282_15b9103c642a8f.mp3' ;
$response['messages'][1]['quickReply']['audio']['duration'] = 60000 ;
##

//location
$response['messages'][1]['quickReply']['location']['title'] = '喜朋' ;
$response['messages'][1]['quickReply']['location']['address'] = '民生東路' ;
$response['messages'][1]['quickReply']['location']['latitude'] = 25.058025 ;
$response['messages'][1]['quickReply']['location']['longitude'] = 121.527957 ;
##

//confirm
$response['messages'][1]['quickReply']['confirm']['altText'] = '測試 confirm' ;
$response['messages'][1]['quickReply']['confirm']['label'] = '顯示的文字' ;
$response['messages'][1]['quickReply']['confirm']['actions'][] = array(
    'datetimepicker'    => array(
        'label'     => '選項顯示的文字',
        'data'      => 'cat=null',
        'mode'      => 'datetime',
        'initial'   => '2018-04-06T12:00',
        'min'       => '2018-04-03T00:00',
        'max'       => '2018-04-10T24:00'
    )
) ;
$response['messages'][1]['quickReply']['confirm']['actions'][] = array(
    'uri'    => array(
        'label'     => '台灣房屋',
        'uri'       => 'http://www.twhg.com.tw',
        'altUri'    => 'http://www.twhg.com.tw',
    )
) ;
##
*/
//imagemap
/*
$response['messages'][1]['quickReply']['imagemap']['imapUrl'] = 'https://drq-wh-test.azurewebsites.net/imagemaps/symptom_scale';
$response['messages'][1]['quickReply']['imagemap']['imapTitle'] = '嚴重程度';
$response['messages'][1]['quickReply']['imagemap']['imapWidth'] = 1040;
$response['messages'][1]['quickReply']['imagemap']['imapHeight'] = 115;
$response['messages'][1]['quickReply']['imagemap']['imapZone'][] = array(
    'areaTitle' => '輕度',
    'area' => array(
        'x' => 0,
        'y' => 0,
        'w' => 208,
        'h' => 155
    )
);
$response['messages'][1]['quickReply']['imagemap']['imapZone'][] = array(
    'areaTitle' => '中度',
    'area' => array(
        'x' => 208,
        'y' => 0,
        'w' => 208,
        'h' => 155
    )
);
$response['messages'][1]['quickReply']['imagemap']['imapZone'][] = array(
    'areaTitle' => '中重度',
    'area' => array(
        'x' => 416,
        'y' => 0,
        'w' => 208,
        'h' => 155
    )
);
$response['messages'][1]['quickReply']['imagemap']['imapZone'][] = array(
    'areaTitle' => '重度',
    'area' => array(
        'x' => 624,
        'y' => 0,
        'w' => 208,
        'h' => 155
    )
);
$response['messages'][1]['quickReply']['imagemap']['imapZone'][] = array(
    'areaTitle' => '極重度',
    'area' => array(
        'x' => 832,
        'y' => 0,
        'w' => 208,
        'h' => 155
    )
);
$response['messages'][1]['quickReply']['quickReply']['sender']['name'] = '愛酷' ;
$response['messages'][1]['quickReply']['quickReply']['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
*/
##
/*
//button
$response['messages'][1]['quickReply']['button']['altText'] = '測試 button' ;
$response['messages'][1]['quickReply']['button']['title'] = '顯示的標題' ;
$response['messages'][1]['quickReply']['button']['label'] = '顯示的文字' ;
$response['messages'][1]['quickReply']['button']['imageUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
$response['messages'][1]['quickReply']['button']['actions'][] = array(
    'uri'    => array(
        'label'     => '台屋',
        'uri'       => 'http://www.twhg.com.tw'
    )
) ;
$response['messages'][1]['quickReply']['button']['actions'][] = array(
    'datetimepicker'    => array(
        'label'     => '選項顯示的文字',
        'data'      => 'cat=null',
        'mode'      => 'datetime',
        'initial'   => '2018-04-06T12:00',
        'min'       => '2018-04-03T00:00',
        'max'       => '2018-04-10T24:00'
    )
) ;
$response['messages'][1]['quickReply']['button']['actions'][] = array(
    'uri'    => array(
        'label'     => '台屋',
        'uri'       => 'http://www.twhg.com.tw'
    )
) ;
##

//carousel
$response['messages'][1]['quickReply']['carousel']['altText'] = '測試 carousel' ;
$response['messages'][1]['quickReply']['carousel']['imageRatio'] = 'rectangle' ;
$response['messages'][1]['quickReply']['carousel']['columns'][] = array(
    'text'              => '顯示的文字',
    'title'             => '顯示的標題文字文',
    'imageUrl'          => 'https://linebotclient.accunix.net/images/ticket1.jpg',
    'actions'   => array(
        array(
            'postback'    => array(
                'label' => '好的',
                'data'  => 'cat=hp&item=overwrite&group_id='.$groupId,
            )
        ),
        array(
            'datetimepicker'    => array(
                'label'     => '選項2顯示的文字',
                'data'      => 'cat=null',
                'mode'      => 'datetime',
                'initial'   => '2018-04-06T12:00',
                'min'       => '2018-04-03T00:00',
                'max'       => '2018-04-10T24:00'
            )
        )
    )
) ;

$response['messages'][1]['quickReply']['carousel']['columns'][] = array(
    'text'      => '顯示的文字',
    'title'     => '顯示的標題文字',
    'imageUrl'  => 'https://linebotclient.accunix.net/images/ticket1.jpg',
    'actions'   => array(
        array(
            'datetimepicker'    => array(
                'label'     => '選項3顯示的文字',
                'data'      => 'cat=null',
                'mode'      => 'datetime',
                'initial'   => '2018-04-06T12:00',
                'min'       => '2018-04-03T00:00',
                'max'       => '2018-04-10T24:00'
            )
        ),
        array(
            'datetimepicker'    => array(
                'label'     => '選項4顯示的文字',
                'data'      => 'cat=null',
                'mode'      => 'datetime',
                'initial'   => '2018-04-06T12:00',
                'min'       => '2018-04-03T00:00',
                'max'       => '2018-04-10T24:00'
            )
        )
    )
) ;
##

//imagecarousel
$response['messages'][1]['quickReply']['imagecarousel']['altText'] = '測試 imagecarousel' ;
$response['messages'][1]['quickReply']['imagecarousel']['columns'][0]['imageUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
$response['messages'][1]['quickReply']['imagecarousel']['columns'][0]['action'] = array(
    'datetimepicker'    => array(
        'label'     => '選項1顯示的文字',
        'data'      => 'cat=null',
        'mode'      => 'datetime',
        'initial'   => '2018-04-06T12:00',
        'min'       => '2018-04-03T00:00',
        'max'       => '2018-04-10T24:00'
    )
) ;
$response['messages'][1]['quickReply']['imagecarousel']['columns'][1]['imageUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;
$response['messages'][1]['quickReply']['imagecarousel']['columns'][1]['action'] = array(
    'uri'    => array(
        'label'     => 'twhg',
        'uri'      => 'https://www.twhg.com.tw'
    )
) ;
##

//flex JSON
$response['messages'][0]['quickReply']['flexJson']['altText'] = '測試 flexJson' ;
$response['messages'][0]['quickReply']['flexJson']['contents'] = '{
  "type": "bubble",
  "hero": {
    "type": "image",
    "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_3_movie.png",
    "size": "full",
    "aspectRatio": "20:13",
    "aspectMode": "cover",
    "action": {
      "type": "uri",
      "uri": "http://linecorp.com/"
    }
  },
  "body": {
    "type": "box",
    "layout": "vertical",
    "spacing": "md",
    "contents": [
      {
        "type": "text",
        "text": "BROWNS ADVENTURE\nIN MOVIE",
        "wrap": true,
        "weight": "bold",
        "gravity": "center",
        "size": "xl"
      },
      {
        "type": "box",
        "layout": "baseline",
        "margin": "md",
        "contents": [
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          },
          {
            "type": "icon",
            "size": "sm",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
          },
          {
            "type": "text",
            "text": "4.0",
            "size": "sm",
            "color": "#999999",
            "margin": "md",
            "flex": 0
          }
        ]
      },
      {
        "type": "box",
        "layout": "vertical",
        "margin": "lg",
        "spacing": "sm",
        "contents": [
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Date",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "Monday 25, 9:00PM",
                "wrap": true,
                "size": "sm",
                "color": "#666666",
                "flex": 4
              }
            ]
          },
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Place",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "7 Floor, No.3",
                "wrap": true,
                "color": "#666666",
                "size": "sm",
                "flex": 4
              }
            ]
          },
          {
            "type": "box",
            "layout": "baseline",
            "spacing": "sm",
            "contents": [
              {
                "type": "text",
                "text": "Seats",
                "color": "#aaaaaa",
                "size": "sm",
                "flex": 1
              },
              {
                "type": "text",
                "text": "C Row, 18 Seat",
                "wrap": true,
                "color": "#666666",
                "size": "sm",
                "flex": 4
              }
            ]
          }
        ]
      },
      {
        "type": "box",
        "layout": "vertical",
        "margin": "xxl",
        "contents": [
          {
            "type": "spacer"
          },
          {
            "type": "image",
            "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/linecorp_code_withborder.png",
            "aspectMode": "cover",
            "size": "xl"
          },
          {
            "type": "text",
            "text": "You can enter the theater by using this code instead of a ticket",
            "color": "#aaaaaa",
            "wrap": true,
            "margin": "xxl",
            "size": "xs"
          }
        ]
      }
    ]
  }
}' ;
##
*/
// ****************************************************** //
//快速回覆部分
/*
$response['messages'][1]['quickReply']['items'][] = array(
    'image'     => '',
    'action'    => array(
        'type'  => 'camera',
        'label' => '開啟相機',
    )
) ;
$response['messages'][1]['quickReply']['items'][] = array(
    'image'     => '',
    'action'    => array(
        'type'  => 'cameraRoll',
        'label' => '選擇照片',
    )
) ;
$response['messages'][1]['quickReply']['items'][] = array(
    'image'     => '',
    'action'    => array(
        'type'  => 'location',
        'label' => '定位',
    )
) ;
*/
// ****************************************************** //
// ===================================================== //


/* text */
// $response['messages'][0]['actionType'] = 'text' ;
// $response['messages'][0]['text'] = '你好' ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* sticker */
// $response['messages'][0]['actionType'] = 'sticker' ;
// $response['messages'][0]['sticker']['packageId'] = 1 ;
// $response['messages'][0]['sticker']['stickerId'] = 1 ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* image */
// $response['messages'][0]['actionType'] = 'image' ;
// $response['messages'][0]['image']['imageUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
// $response['messages'][0]['image']['previewUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* video */
$response['messages'][0]['actionType'] = 'video' ;
$response['messages'][0]['video']['videoUrl'] = 'https://linebotclient.accunix.net/images/video_1801052816669282_15b91040406657.mp4' ;
$response['messages'][0]['video']['previewUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
$response['messages'][0]['video']['trackingId'] = '123456' ;
$response['messages'][0]['sender']['name'] = '愛酷' ;
$response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* audio */
// $response['messages'][0]['actionType'] = 'audio' ;
// $response['messages'][0]['audio']['audioUrl'] = 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/audio_1801052816669282_15b9103c642a8f.mp3' ;
// $response['messages'][0]['audio']['duration'] = 60000 ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* location */
// $response['messages'][0]['actionType'] = 'location' ;
// $response['messages'][0]['location']['title'] = '喜朋' ;
// $response['messages'][0]['location']['address'] = '民生東路' ;
// $response['messages'][0]['location']['latitude'] = 25.058025 ;
// $response['messages'][0]['location']['longitude'] = 121.527957 ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* imagemap */
// $response['messages'][0]['actionType'] = 'imagemap' ;
// $response['messages'][0]['imagemap']['imapUrl'] = 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/imagemaps' ;
// $response['messages'][0]['imagemap']['imapTitle'] = '選單' ;
// $response['messages'][0]['imagemap']['imapWidth'] = 1040 ;
// $response['messages'][0]['imagemap']['imapHeight'] = 1040 ;

// $response['messages'][0]['imagemap']['video']['videoUrl'] = 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/video_1801052816669282_15b91040406657.mp4' ;
// $response['messages'][0]['imagemap']['video']['previewUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
// $response['messages'][0]['imagemap']['video']['x'] = 30 ;
// $response['messages'][0]['imagemap']['video']['y'] = 30 ;
// $response['messages'][0]['imagemap']['video']['w'] = 500 ;
// $response['messages'][0]['imagemap']['video']['h'] = 500 ;

// $response['messages'][0]['imagemap']['video']['extUrl'] = 'https://www.accuhit.net' ;
// $response['messages'][0]['imagemap']['video']['extLabel'] = 'Accuhit' ;

// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => 'http://www.twhg.com.tw',
    // 'areaTitle' => 'sales01_獎金',
    // 'area'      => array(
            // 'x' => 0,
            // 'y' => 0,
            // 'w' => 346,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => '',
    // 'areaTitle' => 'sales01_MARTECH',
    // 'area'      => array(
            // 'x' => 347,
            // 'y' => 0,
            // 'w' => 348,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => '',
    // 'areaTitle' => 'sales01_部落格',
    // 'area'      => array(
            // 'x' => 695,
            // 'y' => 0,
            // 'w' => 346,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => '',
    // 'areaTitle' => 'sales01_簽到',
    // 'area'      => array(
            // 'x' => 0,
            // 'y' => 521,
            // 'w' => 346,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => '',
    // 'areaTitle' => 'sales01_ACCUNIX',
    // 'area'      => array(
            // 'x' => 347,
            // 'y' => 521,
            // 'w' => 348,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['imagemap']['imapZone'][] = array(
    // 'areaUrl'   => '',
    // 'areaTitle' => 'sales01_專案列表',
    // 'area'      => array(
            // 'x' => 695,
            // 'y' => 521,
            // 'w' => 346,
            // 'h' => 520
    // )
// ) ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;


/* confirm */
// $response['messages'][0]['actionType'] = 'confirm' ;
// $response['messages'][0]['confirm']['altText'] = '測試 confirm' ;
// $response['messages'][0]['confirm']['label'] = '顯示的文字' ;
// $response['messages'][0]['confirm']['actions'][] = array(
    // 'datetimepicker'    => array(
        // 'label'     => '選項顯示的文字',
        // 'data'      => 'cat=null',
        // 'mode'      => 'datetime',
        // 'initial'   => '2018-04-06T12:00',
        // 'min'       => '2018-04-03T00:00',
        // 'max'       => '2018-04-10T24:00'
    // )
// ) ;
// $response['messages'][0]['confirm']['actions'][] = array(
    // 'uri'    => array(
        // 'label'     => '台灣房屋',
        // 'uri'       => 'http://www.twhg.com.tw',
        // 'altUri'    => 'http://www.twhg.com.tw',
    // )
// ) ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* button */
// $response['messages'][0]['actionType'] = 'button' ;
// $response['messages'][0]['button']['altText'] = '測試 button' ;
// $response['messages'][0]['button']['title'] = '顯示的標題' ;
// $response['messages'][0]['button']['label'] = '顯示的文字' ;
// $response['messages'][0]['button']['imageUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
//// $response['messages'][0]['button']['imageUrl'] = 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/11.jpg' ;
//// $response['messages'][0]['button']['imageRatio'] = 'rectangle' ;
// $response['messages'][0]['button']['imageRatio'] = 'square' ;
// $response['messages'][0]['button']['imageSize'] = 'cover' ;
//// $response['messages'][0]['button']['imageSize'] = 'contain' ;
// $response['messages'][0]['button']['imageBackground'] = '#0000AA' ;
//// $response['messages'][0]['button']['imageBackground'] = '#C0C0C0' ;
// $response['messages'][0]['button']['defaultAct'] = array(
    // 'uri'   => array(
        // 'label' =>  '愛酷',
        // 'uri'   => 'https://www.accuhit.net',
    // )
// ) ;
// $response['messages'][0]['button']['actions'][] = array(
    // 'datetimepicker'    => array(
        // 'label'     => '選項顯示的文字',
        // 'data'      => 'cat=null',
        // 'mode'      => 'datetime',
        // 'initial'   => '2018-04-06T12:00',
        // 'min'       => '2018-04-03T00:00',
        // 'max'       => '2018-04-10T24:00'
    // )
// ) ;
// $response['messages'][0]['button']['actions'][] = array(
    // 'uri'    => array(
        // 'label'     => '台屋',
        // 'uri'       => 'http://www.twhg.com.tw'
    // )
// ) ;
// $response['messages'][0]['button']['actions'][] = array(
    // 'datetimepicker'    => array(
        // 'label'     => '選項顯示的文字',
        // 'data'      => 'cat=null',
        // 'mode'      => 'datetime',
        // 'initial'   => '2018-04-06T12:00',
        // 'min'       => '2018-04-03T00:00',
        // 'max'       => '2018-04-10T24:00'
    // )
// ) ;
// $response['messages'][0]['button']['actions'][] = array(
    // 'uri'    => array(
        // 'label'     => '台屋',
        // 'uri'       => 'http://www.twhg.com.tw'
    // )
// ) ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* carousel */
// $response['messages'][0]['actionType'] = 'carousel' ;
// $response['messages'][0]['carousel']['altText'] = '測試 carousel' ;
// $response['messages'][0]['carousel']['imageRatio'] = 'rectangle' ;
//// $response['messages'][0]['carousel']['imageRatio'] = 'square' ;
//// $response['messages'][0]['carousel']['imageSize'] = 'cover' ;
// $response['messages'][0]['carousel']['imageSize'] = 'contain' ;
// $response['messages'][0]['carousel']['columns'][] = array(
    // 'text'              => '顯示的文字',
    // 'title'             => '顯示的標題文字文',
    //// 'imageUrl'          => 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg',
    // 'imageUrl'          => 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/11.jpg',
    // 'imageBackground'   => '#0000AA',
    // 'defaultAct'        => array(
        // 'uri'   => array(
            // 'label' =>  '愛酷',
            // 'uri'   => 'https://www.accuhit.net',
        // )
    // ),
    // 'actions'   => array(
        // array(
            // 'datetimepicker'    => array(
                // 'label'     => '選項1顯示的文字',
                // 'data'      => 'cat=null',
                // 'mode'      => 'datetime',
                // 'initial'   => '2018-04-06T12:00',
                // 'min'       => '2018-04-03T00:00',
                // 'max'       => '2018-04-10T24:00'
            // )
        // ),
        // array(
            // 'datetimepicker'    => array(
                // 'label'     => '選項2顯示的文字',
                // 'data'      => 'cat=null',
                // 'mode'      => 'datetime',
                // 'initial'   => '2018-04-06T12:00',
                // 'min'       => '2018-04-03T00:00',
                // 'max'       => '2018-04-10T24:00'
            // )
        // )
    // )
// ) ;
// $response['messages'][0]['carousel']['columns'][] = array(
    // 'text'      => '顯示的文字',
    // 'title'     => '顯示的標題文字',
    // 'imageUrl'  => 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg',
    //// 'imageUrl'          => 'https://bot168-bot168-test.azurewebsites.net/line/1624179288/11.jpg',
    // 'actions'   => array(
        // array(
            // 'datetimepicker'    => array(
                // 'label'     => '選項3顯示的文字',
                // 'data'      => 'cat=null',
                // 'mode'      => 'datetime',
                // 'initial'   => '2018-04-06T12:00',
                // 'min'       => '2018-04-03T00:00',
                // 'max'       => '2018-04-10T24:00'
            // )
        // ),
        // array(
            // 'datetimepicker'    => array(
                // 'label'     => '選項4顯示的文字',
                // 'data'      => 'cat=null',
                // 'mode'      => 'datetime',
                // 'initial'   => '2018-04-06T12:00',
                // 'min'       => '2018-04-03T00:00',
                // 'max'       => '2018-04-10T24:00'
            // )
        // )
    // )
// ) ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

/* imagecarousel */
// $response['messages'][1]['actionType'] = 'imagecarousel' ;
// $response['messages'][1]['imagecarousel']['altText'] = '測試 imagecarousel' ;
// $response['messages'][1]['imagecarousel']['columns'][0]['imageUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
// $response['messages'][1]['imagecarousel']['columns'][0]['action'] = array(
    // 'datetimepicker'    => array(
        // 'label'     => '選項1顯示的文字',
        // 'data'      => 'cat=null',
        // 'mode'      => 'datetime',
        // 'initial'   => '2018-04-06T12:00',
        // 'min'       => '2018-04-03T00:00',
        // 'max'       => '2018-04-10T24:00'
    // )
// ) ;
// $response['messages'][1]['imagecarousel']['columns'][1]['imageUrl'] = 'https://accubotplus168.azurewebsites.net/aqbot/images/eip_announce.jpg' ;
// $response['messages'][1]['imagecarousel']['columns'][1]['action'] = array(
    // 'uri'    => array(
        // 'label'     => 'twhg',
        // 'uri'      => 'https://www.twhg.com.tw'
    // )
// ) ;


/* flex */
//Template OK
// $response['messages'][0]['actionType'] = 'flex' ;
// $response['messages'][0]['flex']['altText'] = '請至手機上操作觀看' ;
// $response['messages'][0]['flex']['contents'][] = array(
    // 'type' => 'bubble',
    // 'hero' => array(
        // "type" => "image",
        // "size" => "full",
        // "aspectRatio" => "1024:690",
        // "aspectMode" => "cover",
        // "url" => "https://bot168-bot168-test.azurewebsites.net/line/1605023390/MOOMIN/images/welcome.jpg"
    // ),
    // 'body' => array(
        // 'type' => 'box',
        // 'layout'  => 'v',
        // 'spacing' => 'sm',
        // 'contents' => array(
            // array(
                // "type" => "text",
                // "text" => "測試",
                // "wrap" => true,
                // "weight" => "bold",
                // "size" => "xl"
            // ),
            // array(
                // "type" => "box",
                // "layout" => "h",
                // "contents" => array(
                    // array(
                        // "type" => "text",
                        // "text" => "111111111111111111111111123456",
                        // "wrap" => true,
                        // "color" => "#666666",
                        // "size" => "sm",
                    // ),
                    // array(
                        // "type" => "text",
                        // "text" => "AAAAASSSSSSSSSSSSSSSSSSSSSSSSSSSSSS",
                        // "wrap" => true,
                        // "color" => "#666666",
                        // "size" => "sm",
                    // ),
                // ),
            // ),
        // ),
    // ),
// ) ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;


//Template 1
// $response['messages'][0]['flex']['contents'][0]['direction'] = 'l' ;   //ltr or rtl default: ltr  optional

// $response['messages'][0]['flex']['contents'][0]['header']['type'] = 'box' ;
// $response['messages'][0]['flex']['contents'][0]['header']['layout'] = 'h' ;
// $response['messages'][0]['flex']['contents'][0]['header']['contents'][0]['type'] = 'text' ;
// $response['messages'][0]['flex']['contents'][0]['header']['contents'][0]['text'] = '主標題' ;

// $response['messages'][0]['flex']['contents'][0]['hero']['type'] = 'image' ;
// $response['messages'][0]['flex']['contents'][0]['hero']['url'] = 'https://admin.accuhit.net/img/accunix-menu-01.png' ;

// $response['messages'][0]['flex']['contents'][0]['footer']['type'] = 'box' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['layout'] = 'v' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['contents'][0]['type'] = 'button' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['contents'][0]['action']['uri']['label'] = '請點我1' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['contents'][0]['action']['uri']['uri'] = 'https://www.accuhit.net' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['contents'][1]['action']['uri']['label'] = '請點我2' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['contents'][1]['action']['uri']['uri'] = 'http://www.first1.com.tw' ;
// $response['messages'][0]['flex']['contents'][0]['footer']['bgColor'] = '#C0C0C0' ;

/*
//Template 1
$response['messages'][0]['flex']['contents'][] = array(
    'direction' => 'l',   //ltr or rtl default: ltr  optional
    'header' => array(
        'type'      => 'box',
        'layout'    => 'h',
        // 'spacing'   => 'md',
        'contents'  => array(
            array('type'  => 'text', 'text'  => '主標題'),
            array('type'  => 'text', 'text'  => '子標題'),
        ),
        'bgColor'   => '#CCEEFF',
    ),
    'hero'      => array(
        'type'      => 'image',
        'url'       => 'https://admin.accuhit.net/img/accunix-menu-01.png',
    ),
    'body'      => array(
        'type'      => 'box',
        'layout'    => 'b',
        'contents'  => array(
            array('type' => 'icon', 'url' => 'https://admin.accuhit.net/img/loader.gif', 'size' => 'xs'),
            array('type'  => 'text', 'text'  => 'it'."\n".'em1 item2gfdhfghgfhdfhgfhd', 'wrap' => 'y', 'txtSize' => '', 'weight' => '', 'txtColor' => '#C0C0C0'),
            array(
                'type'  => 'text',
                'text'  => 'body2',
                'action' => array(
                    'uri' => array('label' => '請點我', 'uri' => 'https://www.accuhit.net')
                ),
                'align' => 'l',
                'weight' => 'y',
                'txtColor' => '#0000cc',
            ),
        ),
    ),
    'footer'    => array(
        'type' => 'box',
        'layout' => 'v',
        'contents'  => array(
            array(
                'type' => 'button',
                'action' => array(
                    'uri' => array('label' => '請點我', 'uri' => 'https://www.accuhit.net')
                )
            ),
            array(
                'type' => 'button',
                'action' => array(
                    'uri' => array('label' => '請點我', 'uri' => 'http://www.first1.com.tw')
                )
            ),
        ),
        'bgColor' => '#C0C0C0',
    ),
) ;*/
/*
//Template 2
$response['messages'][0]['flex']['contents'][] = array(
    'direction' => 'l',   //ltr or rtl default: ltr  optional
    'hero'      => array(
        'type'      => 'image',
        'url'       => 'https://admin.accuhit.net/img/accunix-menu-01.png'
    ),
    'body'      => array(
        'type'      => 'box',
        'layout'    => 'h',
        // 'spacing'   => 'md',
        'contents'  => array(
            // array('type'  => 'text', 'text'  => 'this is body'),
            array(
                'type' => 'button',
                // 'style' => 'secondary',
                'btnTextColor' => 'w',
                'btnColor' => '#CD853F',
                'action' => array(
                    'uri' => array('label' => '點我(A)', 'uri' => 'https://www.accuhit.net')
                ),
            ),
            array(
                'type' => 'button',
                // 'style' => 'secondary',
                'btnTextColor' => 'w',
                'btnColor' => '#000080',
                'action' => array(
                    'uri' => array('label' => '點我(B)', 'uri' => 'https://www.first1.com.tw')
                ),
            ),
        )
    ),
    'footer'    => array(
        'type' => 'box',
        'layout' => 'v',
        // 'spacing'   => 'md',
        'contents' => array(
            array('type' => 'text', 'text' => 'this is footer'),

        ),
        'bgColor' => '#C0C0C0'
    ),
) ;

//Template 3
$response['messages'][0]['flex']['contents'][] = array(
    'direction' => 'l',   //ltr or rtl default: ltr  optional
    'header' => array(
        'type'      => 'box',
        'layout'    => 'h',
        // 'spacing'   => 'md',
        'contents'  => array(
            array('type'  => 'text', 'text'  => '主標題'),
            array('type'  => 'text', 'text'  => '子標題'),
        ),
        'bgColor'   => '#CCEEFF',
    ),
    'hero'      => array(
        'type'      => 'image',
        'url'       => 'https://admin.accuhit.net/img/accunix-menu-01.png',
    ),
    'body'      => array(
        'type'      => 'box',
        'layout'    => 'b',
        'contents'  => array(
            array('type' => 'icon', 'url' => 'https://admin.accuhit.net/img/loader.gif', 'size' => 'xs'),
            // array('type'  => 'text', 'text'  => 'it'."\n".'em1 item2', 'wrap' => 'Y', 'size' => 'md'),
            // array('type'  => 'text', 'text'  => 'this is body2', 'wrap' => 'Y'),
            array('type'  => 'text', 'text'  => 'it'."\n".'em1 item2', 'wrap' => 'Y', 'size' => 'xs'),
            array('type'  => 'text', 'text'  => 'this is body2'),
        ),
    ),
    'footer'    => array(
        'type' => 'box',
        'layout' => 'v',
        'contents'  => array(
            // array('type'  => 'text', 'text'  => 'this is body'),
            array(
                'type' => 'button',
                'btnTextColor' => 'w',
                'action' => array(
                    'uri' => array('label' => '請點我', 'uri' => 'https://www.accuhit.net')
                )
            ),
            array(
                'type' => 'button',
                'btnTextColor' => 'b',
                'action' => array(
                    'uri' => array('label' => '請點我', 'uri' => 'https://www.first1.com.tw')
                )
            ),
        ),
        'bgColor' => '#C0C0C0',
    ),
) ;
*/

/* flex JSON */
// $response['messages'][0]['actionType'] = 'flexJson' ;
// $response['messages'][0]['flexJson']['altText'] = '請至手機上操作觀看' ;
// $response['messages'][0]['flexJson']['contents'] = '{
  // "type": "bubble",
  // "hero": {
    // "type": "image",
    // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_3_movie.png",
    // "size": "full",
    // "aspectRatio": "20:13",
    // "aspectMode": "cover",
    // "action": {
      // "type": "uri",
      // "uri": "http://linecorp.com/"
    // }
  // },
  // "body": {
    // "type": "box",
    // "layout": "vertical",
    // "spacing": "md",
    // "contents": [
      // {
        // "type": "text",
        // "text": "BROWNS ADVENTURE\nIN MOVIE",
        // "wrap": true,
        // "weight": "bold",
        // "gravity": "center",
        // "size": "xl"
      // },
      // {
        // "type": "box",
        // "layout": "baseline",
        // "margin": "md",
        // "contents": [
          // {
            // "type": "icon",
            // "size": "sm",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          // },
          // {
            // "type": "icon",
            // "size": "sm",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          // },
          // {
            // "type": "icon",
            // "size": "sm",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          // },
          // {
            // "type": "icon",
            // "size": "sm",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gold_star_28.png"
          // },
          // {
            // "type": "icon",
            // "size": "sm",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/review_gray_star_28.png"
          // },
          // {
            // "type": "text",
            // "text": "4.0",
            // "size": "sm",
            // "color": "#999999",
            // "margin": "md",
            // "flex": 0
          // }
        // ]
      // },
      // {
        // "type": "box",
        // "layout": "vertical",
        // "margin": "lg",
        // "spacing": "sm",
        // "contents": [
          // {
            // "type": "box",
            // "layout": "baseline",
            // "spacing": "sm",
            // "contents": [
              // {
                // "type": "text",
                // "text": "Date",
                // "color": "#aaaaaa",
                // "size": "sm",
                // "flex": 1
              // },
              // {
                // "type": "text",
                // "text": "Monday 25, 9:00PM",
                // "wrap": true,
                // "size": "sm",
                // "color": "#666666",
                // "flex": 4
              // }
            // ]
          // },
          // {
            // "type": "box",
            // "layout": "baseline",
            // "spacing": "sm",
            // "contents": [
              // {
                // "type": "text",
                // "text": "Place",
                // "color": "#aaaaaa",
                // "size": "sm",
                // "flex": 1
              // },
              // {
                // "type": "text",
                // "text": "7 Floor, No.3",
                // "wrap": true,
                // "color": "#666666",
                // "size": "sm",
                // "flex": 4
              // }
            // ]
          // },
          // {
            // "type": "box",
            // "layout": "baseline",
            // "spacing": "sm",
            // "contents": [
              // {
                // "type": "text",
                // "text": "Seats",
                // "color": "#aaaaaa",
                // "size": "sm",
                // "flex": 1
              // },
              // {
                // "type": "text",
                // "text": "C Row, 18 Seat",
                // "wrap": true,
                // "color": "#666666",
                // "size": "sm",
                // "flex": 4
              // }
            // ]
          // }
        // ]
      // },
      // {
        // "type": "box",
        // "layout": "vertical",
        // "margin": "xxl",
        // "contents": [
          // {
            // "type": "spacer"
          // },
          // {
            // "type": "image",
            // "url": "https://scdn.line-apps.com/n/channel_devcenter/img/fx/linecorp_code_withborder.png",
            // "aspectMode": "cover",
            // "size": "xl"
          // },
          // {
            // "type": "text",
            // "text": "You can enter the theater by using this code instead of a ticket",
            // "color": "#aaaaaa",
            // "wrap": true,
            // "margin": "xxl",
            // "size": "xs"
          // }
        // ]
      // }
    // ]
  // }
// }' ;
// $response['messages'][0]['sender']['name'] = '愛酷' ;
// $response['messages'][0]['sender']['iconUrl'] = 'https://linebotclient.accunix.net/images/ticket1.jpg' ;

// print_r($response) ;
$json_arr = $bot->send($response) ;
print_r($json_arr) ;
##

?>