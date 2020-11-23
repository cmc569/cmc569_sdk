<?php
//version 1.00
namespace CMC\LineSDK;

class LineNotify {
    private $access_token ;
    private $log_path = __DIR__.'/log/notify' ;
    
    /************** 初始設定 ********************/
    //初始建立
    public function __construct($access_token='', $path='') {
        $this->access_token = $access_token ;
        
        if (preg_match("/^\//", $path)) $this->log_path = $path ;
        if (!is_dir($this->log_path)) mkdir($this->log_path, 0777, true) ;
    }
    ##
    
    //設定 access token
    public function set_token(string $access_token) {
        $this->access_token = $access_token ;
        return true ;
    }
    ##
    
    //建立通知
    public function send(string $message) {
        return file_get_contents("https://notify-api.line.me/api/notify", false, stream_context_create([
            "http" => [
                "method" => "POST",
                "header" => implode("\r\n", [
                    "Content-Type: application/x-www-form-urlencoded",
                    "Authorization: Bearer "."{$this->access_token}",
                ]),
                "content" => http_build_query([
                    "message" => $message,
                ]),
            ],
        ]));
    }
    ##
}
?>