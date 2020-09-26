<?php
//version 1.00
namespace CMC\FacebookSDK;

class MessengerBotHandover
{
    private $app_id;
    private $app_secret;
    private $page_access_token ;
    private $graph_version = 'v8.0';
    private $log_path = __DIR__.'/log';
    
    /************** 初始設定 ********************/
    //初始建立
    public function __construct($app_id='', $app_secret='', $page_access_token='', $path='')
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
        $this->page_access_token = $page_access_token;
        
        if (preg_match("/^\//", $path)) $this->log_path = $path;
        if (!is_dir($this->log_path)) mkdir($this->log_path, 0777, true);
    }
    ##
    
    //設定 app id
    public function set_app_id($id)
    {
        if (empty($id)) return false;
        else {
            $this->app_id = $id;
            return true;
        }
    }
    ##
    
    //設定 app secret
    public function set_app_secret($secret)
    {
        if (empty($secret)) return false;
        else {
            $this->app_secret = $secret;
            return true;
        }
    }
    ##
    
    //設定 page access token
    public function set_access_token($token)
    {
        if (empty($token)) return false;
        else {
            $this->page_access_token = $token;
            return true;
        }
    }
    ##
    
    //設定 log 路徑資訊
    public function set_log_path($path='')
    {
        if ($path) {
            $this->log_path = $path;
            if (is_dir($this->log_path)) return true;
            else return mkdir($this->log_path, 0777, true);
        }
        else return false;
    }
    ##
    
    //pass_thread_control
    public function pass_thread_control($psid, $app_id, $metadata='')
    {
        $data = [];
        $data = [
            'recipient' => ['id' => $psid],
            'target_app_id' => $app_id,
        ];
        if (!empty($metadata)) $data['metadata'] = $metadata;
        
        return $this->curl('pass_thread_control', $data);
    }
    ##
    
    //take_thread_control
    public function take_thread_control($psid, $metadata='')
    {
        $data = [];
        $data = [
            'recipient' => ['id' => $psid],
        ];
        if (!empty($metadata)) $data['metadata'] = $metadata;
        
        return $this->curl('take_thread_control', $data);
    }
    ##
    
    //request_thread_control
    public function request_thread_control($psid)
    {
        $data = [];
        $data = [
            'recipient' => ['id' => $psid],
        ];
        if (!empty($metadata)) $data['metadata'] = $metadata;
        
        return $this->curl('request_thread_control', $data);
    }
    ##
    
    
    //curl 發送
    private function curl($end_point, $post_data=[]) {
        if (empty($end_point)) {
            $this->stop_action(400, '無法確認操作 End-point') ;
            return;
        }
        
        //請求 log
        $reply_log = $this->log_path.'/reply' ;
        if (!is_dir($reply_log)) $tf = mkdir($reply_log, 0777, true) ;
        $reply_log .= '/reply_'.date("Ymd").'.log' ;
        ##
        
        if (empty($this->page_access_token)) $this->stop_action(400, '未指定 channel access token') ;
        
        $header = array(
            'Content-Type: application/json; charset=utf-8'
        ) ;
        
        $url = 'https://graph.facebook.com/'.$this->graph_version.'/me/'.$end_point.'?access_token='.$this->page_access_token ;
        
        $ch = curl_init($url) ;
        
        curl_setopt($ch, CURLOPT_POST, true) ;
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST') ;
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data)) ;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header) ;
        
        $result = curl_exec($ch) ;
        $returnCode = curl_getinfo($ch) ;
        curl_close($ch);
        
        $process_log = 'End-Point:'."\n".$url."\n" ;
        $process_log .= 'Request:'."\n".json_encode($post_data, JSON_UNESCAPED_UNICODE)."\n" ;
        $process_log .= 'Response:'."\n".json_encode($result, JSON_UNESCAPED_UNICODE)."\n" ;
        
        file_put_contents($reply_log, date("Y-m-d H:i:s")."\n".$process_log."\n", FILE_APPEND) ;

        return $result ;
    }
    ##
    
    //終止動作
    private function stop_action($status, $message) {
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