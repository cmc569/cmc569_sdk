<?php
//version 1.04
namespace CMC\FacebookSDK;

class MessengerBotWebhook {
    private $log_path = __DIR__ . '/log';
    private $webhook_log;
    private $image_path;
    private $audio_path;
    private $video_path;
    private $file_path;
    private $reply_log;
    private $push_log;
    private $error_log;
    private $post_log;
    private $request_log;
    private $response_log;

    //初始建立
    public function __construct($path = '') {
        if (preg_match("/^\//", $path))
            $this->log_path = $path;
        if (!is_dir($this->log_path))
            mkdir($this->log_path, 0777, true);
    }

    ##

    //webhook 接收
    public function webhook() {
        if ($_REQUEST['hub_mode'] == 'subscribe') {
            if ($_REQUEST['hub_verify_token'] == 'playplay') {
                exit($_REQUEST['hub_challenge']);
            }
        } else {
            //紀錄原始訊息
            $webhook_log = __DIR__ . '/log/webhook';
            if (!is_dir($webhook_log))
                mkdir($webhook_log, 0777, true);
            $this->webhook_log = $webhook_log . '/webhook_' . date("Ymd") . '.log';

            $receive = json_decode(file_get_contents("php://input"), true);
            file_put_contents($this->webhook_log, date("Y-m-d H:i:s") . ' ' . json_encode($receive) . "\n", FILE_APPEND);
            ##
            
            return $this->events($receive);
        }
    }

    ##

    //主程式內容
    private function events($receive) {
        //取得 page id
        $page_id = $receive['entry'][0]['id'];
        ##
        
        //建立各檔案類型存放路徑
        $this->set_log($page_id);
        ##

        $message = $receive['entry'][0]['messaging'];
        $changes = $receive['entry'][0]['changes'];
        $standby = $receive['entry'][0]['standby'];
        
        if (!empty($message)) {         //messenger
            return $this->messenger($message, $page_id);
        } else if (!empty($changes)) {    //粉資專頁貼文
            return $this->page($changes, $page_id);
        }
    }

    ##

    //建立各檔案類型存放路徑
    private function set_log($page_id) {
        $app_upload_path = __DIR__ . '/uploads/' . $page_id;
        if (!is_dir($app_upload_path))
            mkdir($app_upload_path, 0777, true);

        $this->image_path = $app_upload_path . '/image';
        if (!is_dir($this->image_path))
            mkdir($this->image_path, 0777, true);

        $this->audio_path = $app_upload_path . '/audio';
        if (!is_dir($this->audio_path))
            mkdir($this->audio_path, 0777, true);

        $this->video_path = $app_upload_path . '/video';
        if (!is_dir($this->video_path))
            mkdir($this->video_path, 0777, true);

        $this->file_path = $app_upload_path . '/file';
        if (!is_dir($this->file_path))
            mkdir($this->file_path, 0777, true);
        ##
        
        //設定 log 資訊
        $dir_log = $this->log_path . '/' . $page_id;
        if (!is_dir($dir_log))
            mkdir($dir_log, 0777);

        $this->reply_log = $dir_log . '/reply';
        if (!is_dir($this->reply_log))
            mkdir($this->reply_log, 0777);
        $this->reply_log .= '/reply_' . date("Ymd") . '.log';

        $this->push_log = $dir_log . '/push';
        if (!is_dir($this->push_log))
            mkdir($this->push_log, 0777);
        $this->push_log .= '/push_' . date("Ymd") . '.log';

        $this->error_log = $dir_log . '/error';
        if (!is_dir($this->error_log))
            mkdir($this->error_log, 0777);
        $this->error_log .= '/error_' . date("Ymd") . '.log';

        $this->post_log = $dir_log . '/post';
        if (!is_dir($this->post_log))
            mkdir($this->post_log, 0777);
        $this->post_log .= '/post_' . date("Ymd") . '.log';

        $this->request_log = $dir_log . '/request';
        if (!is_dir($this->request_log))
            mkdir($this->request_log, 0777);
        $this->request_log .= '/request_' . date("Ymd") . '.log';

        $this->response_log = $dir_log . '/response';
        if (!is_dir($this->response_log))
            mkdir($this->response_log, 0777);
        $this->response_log .= '/response_' . date("Ymd") . '.log';
        ##

        return true;
    }

    ##

    //messenger 呼叫
    private function messenger($message, $page_id) {
        if (empty($message))
            return false;

        //分析取得資訊
        $request = array();
        foreach ($message as $k => $v) {
            $data = array();
            $data['messenger'] = json_encode($v);
            $data['page_id'] = $page_id;

            //發送方(取得 psid)
            $psid = $v['sender']['id'];
            $data['psid'] = $psid;
            ##
            
            //接收方
            $recipient = $v['recipient']['id'];
            $data['recipient'] = $recipient;
            $data['page'] = $recipient;
            ##
            
            // 透過機器人發送的訊息
            if (isset($v['delivery'])) {        //訊息已送達
                $data['delivery'] = array(
                    'mids'      => $v['delivery']['mids'],
                    'watermark' => $v['delivery']['watermark'],
                );
                $data['type'] = 'delivery';
                continue;
            } else if (isset($v['read'])) {     //訊息已被讀取
                $data['read'] = array(
                    'watermark' => $v['read']['watermark'],
                );
                $data['type'] = 'read';
                continue;
            } else if (isset($v['message']['is_echo'])) {      //訊息已發出 
                $data['is_echo'] = array(
                    'app_id'    => $v['message']['is_echo']['app_id'],
                    'metadata'  => $v['message']['is_echo']['metadata'] ?? '',
                    'mid'       => $v['message']['is_echo']['mid'],
                );
                $data['type'] = 'is_echo';
                continue;
            } else if (isset($v['policy_enforcement'])) {          //違反facebook政策通知
                $data['policy_enforcement'] = array(
                    'action'    => $v['policy_enforcement']['action'],
                    'reason'    => $v['policy_enforcement']['reason'],
                );
                $data['type'] = 'policy_enforcement';
            } else if (isset($v['reaction'])) {            //互動反應
                $data['reaction'] = array(
                    'reaction'  => $v['reaction']['reaction'],
                    'emoji'     => $v['reaction']['emoji'],
                    'action'    => $v['reaction']['action'],
                    'mid'       => $v['reaction']['mid'],
                );
                $data['type'] = 'reaction';
            } else if (isset($v['optin'])) {            //外掛或一次性訊息的token通知
                $data['optin'] = array();
                if (!empty($v['optin']['ref'])) $data['optin']['ref'] = $v['optin']['ref'];
                if (!empty($v['optin']['user_ref'])) $data['optin']['user_ref'] = $v['optin']['user_ref'];
                if (!empty($v['optin']['type'])) $data['optin']['type'] = $v['optin']['type'];
                if (!empty($v['optin']['payload'])) $data['optin']['payload'] = $v['optin']['payload'];
                if (!empty($v['optin']['one_time_notif_token'])) $data['optin']['one_time_notif_token'] = $v['optin']['one_time_notif_token'];
                $data['type'] = 'optin';
            } else if (isset($v['pass_thread_control'])) {            //pass_thread_control
                $data['pass_thread_control'] = array(
                    'new_owner_app_id'  => $v['pass_thread_control']['new_owner_app_id'] ?? '',
                    'metadata'          => $v['pass_thread_control']['metadata'] ?? '',
                );
                $data['type'] = 'pass_thread_control';
            } else if (isset($v['take_thread_control'])) {            //take_thread_control
                $data['take_thread_control'] = array(
                    'previous_owner_app_id' => $v['take_thread_control']['previous_owner_app_id'] ?? '',
                    'metadata'              => $v['take_thread_control']['metadata'] ?? '',
                );
                $data['type'] = 'take_thread_control';
            } else if (isset($v['request_thread_control'])) {            //request_thread_control
                $data['request_thread_control'] = array(
                    'request_thread_control'    => $v['request_thread_control']['request_thread_control'] ?? '',
                    'metadata'                  => $v['request_thread_control']['metadata'] ?? '',
                );
                $data['type'] = 'request_thread_control';
            } else if ($v['postback']['payload'] == 'GET_START') {      //start up
                if (isset($v['postback']['referral']['ref'])) {
                    $data['referral'] = $v['postback']['referral']['ref'];
                    $data['type'] = 'referral';
                } else {
                    $data['GET_START'] = 'GET_START';
                    $data['type'] = 'GET_START';
                }
            } else if (!empty($v['message']['quick_reply']['payload'])) {      //快速功能回覆
                if (preg_match("/\=/", $v['message']['quick_reply']['payload'])) {
                    $tmpArr = explode('&', $v['message']['quick_reply']['payload']);
                    foreach ($tmpArr as $ka => $va) {
                        list($key, $val) = explode('=', $va);
                        $payload[$key] = $val;
                        unset($key, $val);
                    }

                    $data['postback'] = $payload;
                    $data['type'] = 'postback';

                    unset($tmpArr, $payload);
                } else {
                    $data['text'] = $v['message']['quick_reply']['payload'];
                    $data['type'] = 'text';
                }
            } else if (!empty($v['postback']['payload'])) {      //postback 功能回覆
                if (preg_match("/\=/u", $v['postback']['payload'])) {
                    $tmpArr = explode('&', $v['postback']['payload']);
                    foreach ($tmpArr as $ka => $va) {
                        list($key, $val) = explode('=', $va);
                        $payload[$key] = $val;
                        unset($key, $val);
                    }
                    unset($tmpArr);

                    $data['postback'] = $payload;
                    $data['type'] = 'postback';

                    unset($payload);
                } else {
                    $data['text'] = $v['postback']['payload'];
                    $data['type'] = 'text';
                }
            } else if ($v['message']['attachments'][0]['type'] == 'location') {   //座標資訊
                $lat = $v['message']['attachments'][0]['payload']['coordinates']['lat'];
                $lng = $v['message']['attachments'][0]['payload']['coordinates']['long'];

                $data['location'] = array('lat' => $lat, 'lng' => $lng);
                $data['type'] = 'location';

                unset($lat, $lng);
            } else if ($v['message']['attachments'][0]['type'] == 'image') {   //圖片
                $file_url = $v['message']['attachments'][0]['payload']['url'];

                $data['attachment'] = array('type' => 'image', 'url' => $file_url);
                $data['type'] = 'attachment';

                unset($file_url, $ext, $file_pathname, $files);
            } else if ($v['message']['attachments'][0]['type'] == 'audio') {   //聲音
                $file_url = $v['message']['attachments'][0]['payload']['url'];

                $data['attachment'] = array('type' => 'audio', 'url' => $file_url);
                $data['type'] = 'attachment';

                unset($file_url, $ext, $file_pathname, $files);
            } else if ($v['message']['attachments'][0]['type'] == 'video') {   //影像
                $file_url = $v['message']['attachments'][0]['payload']['url'];

                $data['attachment'] = array('type' => 'video', 'url' => $file_url);
                $data['type'] = 'attachment';

                unset($file_url, $ext, $file_pathname, $files);
            } else if ($v['message']['attachments'][0]['type'] == 'file') {   //檔案
                $file_url = $v['message']['attachments'][0]['payload']['url'];

                $data['attachment'] = array('type' => 'file', 'url' => $file_url);
                $data['type'] = 'attachment';

                unset($file_url, $ext, $file_pathname, $files);
            } else if (isset($v['referral'])) {   //referral
                $data['referral'] = $v['referral']['ref'];
                $data['type'] = 'referral';
            } else if ($v['message_request']) {
                $data['message_request'] = $v['message_request'];
                $data['type'] = 'message_request';
                $data['prior_message'] = $v['prior_message'];
            } else {  //文字回覆
                $text = $v['message']['text'];
                $data['text'] = $text;
                $data['type'] = 'text';

                unset($text);
            }
            ##
            
            //發送 Request
            file_put_contents($this->post_log, date("Y-m-d H:i:s") . ' ' . json_encode($data) . "\n\n", FILE_APPEND);

            $request[] = $data;
            ##

            unset($psid, $recipient, $data);
        }
        ##

        return $request;
    }

    ##

    //粉絲專頁呼叫
    private function page($changes, $page_id) {
        if (empty($changes))
            return false;

        //粉資專頁貼文
        $request = array();
        foreach ($changes as $k => $v) {
            $data = array();
            $data['changes'] = json_encode($v);
            $data['page_id'] = $page_id;

            $psid = (isset($v['value']['from']['id'])) ? $v['value']['from']['id'] : '';
            $data['psid'] = $psid;

            if (($v['field'] == 'feed') && !empty($v['value']['post_id'])) {
                $data['type'] = $v['field'];
                $reaction_type = '';
                $reaction_type = (empty($v['value']['reaction_type'])) ? $receive['entry'][1]['changes'][0]['value']['reaction_type'] : $v['value']['reaction_type'];
                $data['data'] = array(
                    'post_id' => $v['value']['post_id'],
                    'comment_id' => $v['value']['comment_id'],
                    'parent_id' => $v['value']['parent_id'],
                    'message' => $v['value']['message'],
                    'link' => $v['value']['post']['permalink_url'],
                    'verb' => $v['value']['verb'],
                    'item' => $v['value']['item'],
                    'reaction_type' => $reaction_type,
                );
                unset($reaction_type);

                unset($post_id, $comment_id, $parent_id);
            }

            //紀錄 request / response data
            file_put_contents($this->request_log, date("Y-m-d H:i:s") . ' ' . json_encode($data) . "\n\n", FILE_APPEND);
            ##

            $request[] = $data;
        }

        return $request;
    }

    ## 
}

##
?>
