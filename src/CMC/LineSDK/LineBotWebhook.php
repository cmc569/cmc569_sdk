<?php
//version 1.11
namespace CMC\LineSDK;

class LineBotWebhook {
    private $channel_id ;
    private $channel_secret ;
    private $channel_access_token ;
    private $log_path = __DIR__.'/log' ;
    private $userId ;
    
    /************** 初始設定 ********************/
    //初始建立
    public function __construct($channel_id='', $channel_secret='', $channel_access_token='', $path='') {
        $this->channel_id = $channel_id ;
        $this->channel_secret = $channel_secret ;
        $this->channel_access_token = $channel_access_token ;
        
        if (preg_match("/^\//", $path)) $this->log_path = $path ;
        if (!is_dir($this->log_path)) mkdir($this->log_path, 0777, true) ;
    }
    ##
    
    //設定 channel id
    public function set_channel_id($id) {
        if (empty($id)) return false ;
        else {
            $this->channel_id = $id ;
            return true ;
        }
    }
    ##
    
    //設定 channel secret
    public function set_channel_secret($secret) {
        if (empty($secret)) return false ;
        else {
            $this->channel_secret = $secret ;
            return true ;
        }
    }
    ##
    
    //設定 channel access token
    public function set_access_token($token) {
        if (empty($token)) return false ;
        else {
            $this->channel_access_token = $token ;
            return true ;
        }
    }
    ##
    
    //設定 log 路徑資訊
    public function set_log_path($path='') {
        if (preg_match("/^\//", $path)) {
            $this->log_path = $path ;
            if (is_dir($this->log_path)) return true ;
            else return mkdir($this->log_path, 0777, true) ;
        }
        else return false ;
    }
    ##
    
    /************* webhook ****************/
    //取得 webhook 資訊
    public function webhook() {
        $body = $this->get_body() ;
        if (empty($body)) $this->stop_action(400, '未接收到資料') ;
        
        $log = $this->log_path ;
        $log .= '/webhook' ;
        if (!is_dir($log)) mkdir($log, 0777, true) ;
        $log .= '/webhook_'.date("Y-m-d").'.log' ;
        file_put_contents($log, date("Y-m-d H:i:s ").$body."\n", FILE_APPEND) ;
        
        if ($this->auth_source($body)) {
            $events = $this->get_events($body) ;
            
            $data = array() ;
            foreach ($events as $event) {
                
                $event_data = array() ;
                $event_data['line_event'] = $body ;
                
                //用戶
                $this->get_user_info($event_data, $event) ;
                ##
                
                //事件類別
                $this->event_message($event_data, $event) ;
                ##
    
                //彙整資料
                $data[] = $event_data ;
                unset($event_data) ;
                ##
            }
            unset($body, $events, $event) ;
            
            return $data ;
        }
        else $this->stop_action(400, '來源驗證失敗') ;
    }
    ##
    
    //取得事件類別
    private function event_message(&$event_data, $event) {
        $data = array() ;
        
        if ($this->isMessage($event)) {         //文字訊息
            $event_data['type'] = 'text' ;
            $event_data['text'] = $event->message->text ;
        }
        else if ($this->isImage($event)) {      //圖片訊息
            $fh = 'uploads/image' ;
            if (!is_dir(__DIR__.'/'.$fh)) mkdir(__DIR__.'/'.$fh, 0777, true) ;
            $fh .= '/image_'.$event->source->userId.'_'.uniqid().'.jpg' ;
            
            $fh_data = $this->getContent($event->message->id) ;
            
            file_put_contents(__DIR__.'/'.$fh, $fh_data) ;
            unset($fh_data) ;
            
            $event_data['type'] = 'image' ;
            $event_data['image'] = $fh ;
        }
        else if ($this->isVideo($event)) {      //影像訊息
            $fh = 'uploads/video' ;
            if (!is_dir(__DIR__.'/'.$fh)) mkdir(__DIR__.'/'.$fh, 0777, true) ;
            $fh .= '/video_'.$event->source->userId.'_'.uniqid().'.mp4' ;
            
            $fh_data = $this->getContent($event->message->id) ;
            
            file_put_contents(__DIR__.'/'.$fh, $fh_data) ;
            unset($fh_data) ;
            
            $event_data['type'] = 'video' ;
            $event_data['video'] = $fh ;
        }
        else if ($this->isAudio($event)) {      //聲音訊息
            $fh = 'uploads/audio' ;
            if (!is_dir(__DIR__.'/'.$fh)) mkdir(__DIR__.'/'.$fh, 0777, true) ;
            $fh .= '/audio_'.$event->source->userId.'_'.uniqid().'.m4a' ;
            
            $fh_data = $this->getContent($event->message->id) ;
            
            file_put_contents(__DIR__.'/'.$fh, $fh_data) ;
            unset($fh_data) ;
            
            $event_data['type'] = 'audio' ;
            $event_data['audio'] = $fh ;
        }
        else if ($this->isFile($event)) {       //檔案訊息
            $tmp = explode('.', $event->message->fileName) ;
            $idx = count($tmp)-1 ;
            
            $ext = ($idx >= 0) ? $tmp[$idx] : 'tmp' ;
            
            $fh = 'uploads/file' ;
            if (!is_dir(__DIR__.'/'.$fh)) mkdir(__DIR__.'/'.$fh, 0777, true) ;
            $fh .= '/file_'.$event->source->userId.'_'.uniqid().'.'.$ext ;
            
            $fh_data = $this->getContent($event->message->id) ;
            
            file_put_contents(__DIR__.'/'.$fh, $fh_data) ;
            unset($fh_data, $tmp, $idx, $ext) ;
            
            $event_data['type'] = 'file' ;
            $event_data['file'] = $fh ;
        }
        else if ($this->isLocation($event)) {   //座標訊息
            $event_data['type'] = 'location' ;
            $event_data['location'] = array(
                'address'   =>  $event->message->address,
                'title'     =>  $event->message->title,
                'latitude'  =>  $event->message->latitude,
                'longitude' =>  $event->message->longitude
            ) ;
        }
        else if ($this->isSticker($event)) {    //貼圖訊息    
            $event_data['type'] = 'sticker' ;
            $event_data['sticker'] = array(
                'packageId' =>  $event->message->packageId,
                'stickerId' =>  $event->message->stickerId
            ) ;
        }
        else if ($this->isFollow($event)) {     //加入好友訊息
            $event_data['type'] = 'follow' ;
        }
        else if ($this->isUnFollow($event)) {   //退出好友訊息
            $event_data['type'] = 'unfollow' ;
        }
        else if ($this->isJoin($event)) {     //Bot 加入好友訊息
            $event_data['type'] = 'join' ;
        }
        else if ($this->isLeave($event)) {   //Bot 退出好友訊息
            $event_data['type'] = 'leave' ;
        }
        else if ($this->isMemberJoined($event)) {     //群組加入其他好友訊息
            $event_data['type'] = 'memberJoined' ;
            $event_data['joined_members'] = $this->get_joined_members($event);
        }
        else if ($this->isMemberLeft($event)) {   //群組退出其他好友訊息
            $event_data['type'] = 'memberLeft' ;
            $event_data['left_members'] = $this->get_left_members($event);
        }
        else if ($this->isPostback($event)) {   //Postback 訊息
            $event_data['type'] = 'postback' ;
            
            $pbData = array() ;
            $arr = explode('&', $event->postback->data) ;
            foreach ($arr as $k => $v) {
                list($keys, $val) = explode('=', $v) ;
                $pbData[$keys] = $val ;
                unset($keys, $val) ;
            }
            unset($arr, $k, $v) ;

            $pbParams = array() ;
            $arr = $event->postback->params ;
            if (is_array($arr)) {
                foreach ($arr as $k => $v) {
                    if ($k == 'datetime') $v = preg_replace("/T/", ' ', $v) ;
                    $pbParams[$k] = $v ;
                }
            }
            unset($arr, $k, $v) ;

            $event_data['postback'] = array('data' => $event->postback->data, 'params' => $event->postback->params, 'postback' => $pbData, 'postbackParam' => $pbParams) ;
            unset($pbData, $pbParams) ;
        }
        else if ($this->isBeacon($event)) {     //Beacon 訊息
            $event_data['type'] = 'beacon' ;

            $event_data['beacon'] = array(
                'hwid'          =>  $event->beacon->hwid,
                'actionType'    =>  $event->beacon->type
            ) ;
        }
        else if ($this->isVideoPlayComplete($event)) {     //video 已觀看完畢訊息
            $event_data['type'] = 'videoPlayComplete' ;

            $event_data['videoPlayComplete'] = array(
                'trackingId'    =>  $event->videoPlayComplete->trackingId
            ) ;
        }
        else {      //未知訊息
            $event_data['type'] = $event->type ;
        }
    }
    ##
    
    //取得加入會員 user id
    private function get_joined_members($event) {
        $members = [];
        if (isset($event->joined)) {
            $joined_members = $event->joined->members;
            foreach ($joined_members as $member) {
                if ($member->type == 'user') $members[] = $member->userId;
            }
        }
        return $members;
    }
    ##
    
    //取得離開會員 user id
    private function get_left_members($event) {
        $members = [];
        if (isset($event->left)) {
            $joined_members = $event->left->members;
            foreach ($joined_members as $member) {
                if ($member->type == 'user') $members[] = $member->userId;
            }
        }
        return $members;
    }
    ##
    
    //取得文件內容
    private function getContent($message_id) {
        if (empty($this->channel_access_token)) $this->stop_action(400, '未指定 channel access token') ;
        
        // $url = 'https://api.line.me/v2/bot/message/'.$message_id.'/content' ;
        $url = 'https://api-data.line.me/v2/bot/message/'.$message_id.'/content' ;
        
        $opts = array(
            "http" => array(
                "method" => "GET",
                "header" => "Authorization: Bearer ".$this->channel_access_token."\r\n"
            )
        ) ;

        $context = stream_context_create($opts) ;
        return file_get_contents($url, false, $context) ;
    }
    ##
    
    //文字訊息
    private function isMessage($event) {
        if ($this->isEvent($event, 'text')) return true ;
        else return false ;
    }
    ##
    
    //圖片訊息
    private function isImage($event) {
        if ($this->isEvent($event, 'image')) return true ;
        else return false ;
    }
    ##
    
    //影片訊息
    private function isVideo($event) {
        if ($this->isEvent($event, 'video')) return true ;
        else return false ;
    }
    ##
    
    //聲音訊息
    private function isAudio($event) {
        if ($this->isEvent($event, 'audio')) return true ;
        else return false ;
    }
    ##
    
    //檔案訊息
    private function isFile($event) {
        if ($this->isEvent($event, 'file')) return true ;
        else return false ;
    }
    ##
    
    //座標訊息
    private function isLocation($event) {
        if ($this->isEvent($event, 'location')) return true ;
        else return false ;
    }
    ##
    
    //貼圖訊息
    private function isSticker($event) {
        if ($this->isEvent($event, 'sticker')) return true ;
        else return false ;
    }
    ##
    
    //訊息型態是否正確
    private function isEvent($event, $type) {
        if (($event->type == 'message') && ($event->message->type == strtolower($type))) return true ;
        else return false ;
    }
    ##
    
    //加入好友狀態
    private function isFollow($event) {
        if ($event->type == 'follow') return true ;
        else return false ;
    }
    ##
    
    //離開好友狀態
    private function isUnFollow($event) {
        if ($event->type == 'unfollow') return true ;
        else return false ;
    }
    ##
    
    //Postback 狀態
    private function isPostback($event) {
        if ($event->type == 'postback') return true ;
        else return false ;
    }
    ##
    
    //Beacon 狀態
    private function isBeacon($event) {
        if ($event->type == 'beacon') return true ;
        else return false ;
    }
    ##
    
    //加入群組或聊天室狀態
    private function isJoin($event) {
        if ($event->type == 'join') return true ;
        else return false ;
    }
    ##
    
    //離開群組或聊天室狀態
    private function isLeave($event) {
        if ($event->type == 'leave') return true ;
        else return false ;
    }
    ##
    
    //有人加入群組或聊天室狀態
    private function isMemberJoined($event) {
        if ($event->type == 'memberJoined') return true ;
        else return false ;
    }
    ##
    
    //有人離開群組或聊天室狀態
    private function isMemberLeft($event) {
        if ($event->type == 'memberLeft') return true ;
        else return false ;
    }
    ##
    
    //影片已撥放
    private function isVideoPlayComplete($event) {
        if ($event->type == 'videoPlayComplete') return true ;
        else return false ;
    }
    ##
    
    //取得使用者資訊
    private function get_user_info(&$event_data, $event) {
        if (isset($event->source->userId)) $event_data['userId'] = $event->source->userId ;
        if (isset($event->source->groupId)) $event_data['groupId'] = $event->source->groupId ;
        if (isset($event->source->roomId)) $event_data['roomId'] = $event->source->roomId ;
        if (isset($event->source->type)) $event_data['sourceType'] = $event->source->type ;
        
        if (isset($event->replyToken)) $event_data['reply_token'] = $event->replyToken ;
        if (isset($event->timestamp)) $event_data['timestamp'] = $event->timestamp ;
        
        $this->userId = (preg_match("/^U[0-9a-f]{32}$/i", $event_data['userId'])) ? $event_data['userId'] : '' ;
        
        return true ;
    }
    ##
    
    //取得事件
    private function get_events($json) {
        $events = json_decode($json) ;
        return $events->events ;
    }
    ##
    
    //取得原始資訊
    private function get_body() {
        return file_get_contents('php://input') ;
    }
    ##
    
    //取得來源憑證
    private function auth_source($body) {
        $signature = $_SERVER['HTTP_X_LINE_SIGNATURE'] ;
        
        if (empty($signature)) return false ;
        else {
            if ($this->signature_check($body, $signature)) return true ;
            else false ;
        }
    }
    ##
    
    //檢查憑證是否正確
    private function signature_check($body, $signature) {
        if (empty($this->channel_secret)) $this->stop_action(400, '未指定 channel secret') ;
        return hash_equals(base64_encode(hash_hmac('sha256', $body, $this->channel_secret, true)), $signature) ;
    }
    ##

    /*************** 例外終止 *****************/
    //終止動作
    public function stop_action($status, $message) {
        $log = $this->log_path.'/error' ;
        if (!is_dir($log)) mkdir($log, 0777, true) ;
        $log .= '/error_'.date("Y-m-d").'.log' ;
        
        $json = json_encode(array('stauts' => $status, 'message' => $message, 'channel_id' => $this->channel_id, 'userId' => $this->userId, 'datetime' => date("Y-m-d H:i:s").'.'.microtime()), JSON_UNESCAPED_UNICODE) ;
        file_put_contents($log, date("Y-m-d H:i:s ").$json."\n", FILE_APPEND) ;
        exit($json) ;
    }
    ##
    
}
?>