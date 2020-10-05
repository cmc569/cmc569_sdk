<?php
//version 1.15
namespace CMC\FacebookSDK;

class MessengerBotRequest {
    private $app_id ;
    private $app_secret ;
    private $page_access_token ;
    private $graph_version = 'v8.0' ;
    private $log_path = __DIR__.'/log' ;
    
    /************** 初始設定 ********************/
    //初始建立
    public function __construct($app_id='', $app_secret='', $page_access_token='', $path='') {
        $this->app_id = $app_id ;
        $this->app_secret = $app_secret ;
        $this->page_access_token = $page_access_token ;
        
        if (preg_match("/^\//", $path)) $this->log_path = $path ;
        if (!is_dir($this->log_path)) mkdir($this->log_path, 0777, true) ;
    }
    ##
    
    //設定 app id
    public function set_app_id($id) {
        if (empty($id)) return false ;
        else {
            $this->app_id = $id ;
            return true ;
        }
    }
    ##
    
    //設定 app secret
    public function set_app_secret($secret) {
        if (empty($secret)) return false ;
        else {
            $this->app_secret = $secret ;
            return true ;
        }
    }
    ##
    
    //設定 page access token
    public function set_access_token($token) {
        if (empty($token)) return false ;
        else {
            $this->page_access_token = $token ;
            return true ;
        }
    }
    ##
    
    //設定 log 路徑資訊
    public function set_log_path($path='') {
        if ($path) {
            $this->log_path = $path ;
            if (is_dir($this->log_path)) return true ;
            else return mkdir($this->log_path, 0777, true) ;
        }
        else return false ;
    }
    ##
    
    /************* Request ****************/
    //建立動作請求
    public function send($data=array()) {
        if (empty($data)) $this->stop_action(400, '無動作資訊') ; 
        if (empty($data['messages'])) $data['messages'][] = $data ;
        unset($result) ;
        $res = array() ;
        foreach ($data['messages'] as $k => $v) {
            $webhook_type = $v['actionType'] ;
            $message_type = (empty($v['tag'])) ? 'RESPONSE' : $v['tag'] ;
            
            if (!empty($v['one_time_notif_token'])) {
                $recipient_type = 'one_time_notif_token';
                $psid = $v['one_time_notif_token'];
            } else {
                $recipient_type = 'id';
                $psid = $v['userId'] ;
            }
            
            $persona_id = '' ;
            
            switch($webhook_type) {
                case 'text' :
                        $msg = $v[$webhook_type]['text'] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->textConstruct($msg) ;
                        
                        break ;

                case 'image' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->imageConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'video' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->videoConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'audio' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->audioConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'buttonMenu' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->buttonConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'genericMenu' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->genericConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'listMenu' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->listConstruct($arr) ;
                        unset($arr) ;
                        
                        break ;
                        
                case 'media' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->sendMedia($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'quickReply' :
                        $arr = $v[$webhook_type] ;
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->quickReply($arr) ;
                        unset($arr) ;
                        
                        break ;

                case 'profile' :
                        $_token = $v[$webhook_type]['userId'] ;
                        $res = $this->GetProfile($_token) ;
                        unset($_token) ;
                        
                        return $res ;

                        break ;
                        
                case 'markSeen' :
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->mark_seen($psid, $persona_id) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : json_encode($res) ;
                        
                        return ;
                        
                        break ;
                              
                case 'typingOn' :
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->typing_on($psid, $persona_id) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : json_encode($res) ;
                        
                        return ;
                        
                        break ;
                        
                case 'typingOff' :
                        $persona_id = (empty($v[$webhook_type]['persona_id'])) ? '' : $v[$webhook_type]['persona_id'] ;
                        $res = $this->typing_off($psid, $persona_id) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : $res ;
                        
                        return ;
                        
                        break ;
                        
                case 'deleteMenu' :
                        $arr = $v[$webhook_type] ;
                        $res = $this->delete_menu($arr) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : $res ;
                        
                        return ;
                        
                        break ;
                        
                case 'setMenu' :
                        $arr = $v[$webhook_type] ;
                        $res = $this->startup_menu($arr) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : $res ;
                        
                        return ;
                        
                        break ;
                        
                case 'feed' :
                        $arr = $v[$webhook_type] ;
                        $res = $this->comment_reply($arr) ;
                        $result = (empty($res)) ? json_encode(array('status' => 400, 'result' => array('message' => 'unrecognized data'))) : $res ;
                        
                        if (is_array($result)) return json_encode($result) ;
                        else return $result;
                        
                        break ;
                        
                default :
                        $msg = '無法確認的操作('.date("Y-m-d H:i:s").')' ;
                        $this->stop_action(400, $msg) ;

                        break ;
            }
            
            
            if (empty($res)) $this->stop_action(400, '無法確認回應內容') ; 
            else return $this->push($psid, $res, $message_type, $recipient_type, $persona_id) ;
        }
    }
    ##
    

    //建構 text
    private function textConstruct($txt) {
        $txt_type = 'utf-8' ;
        
        if (empty($txt)) return false ;
        else {
            $template = array() ;
            $template = array('text' => $txt) ;

            return $template ;
        }
    }
    ##
    
    //建構 image
    private function imageConstruct($arr) {
        if (empty($arr['imageUrl'])) return false ;
        else {
            if (preg_match("/^http/i", $arr['imageUrl'])) {
                $template = array(
                    'attachment' => array(
                        'type'      => 'image',
                        'payload'   => array(
                            'url'           => $arr['imageUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;
            }
            else {
                $template = array(
                    'attachment' => array(
                        'type'      => 'image',
                        'payload'   => array(
                            'attachment_id' => $arr['imageUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;
            }
        
            return $template ;
        }
    }
    ##
    
    //建構 video
    private function videoConstruct($arr) {
        if (empty($arr['videoUrl'])) return false ;
        else {
            $asset = (preg_match("/^http/i", $arr['videoUrl'])) ? array('url' => $arr['videoUrl']) : array('attachment_id' => $arr['videoUrl']) ;

            if (preg_match("/^http/i", $arr['videoUrl'])) {
                $template = array(
                    'attachment' => array(
                        'type'      => 'video',
                        'payload'   => array(
                            'url'           => $arr['videoUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;
            }
            else {
                $template = array(
                    'attachment' => array(
                        'type'      => 'video',
                        'payload'   => array(
                            'attachment_id' => $arr['videoUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;
            }
            
            return $template ;
        }
    }
    ##
    
    //建構 audio
    private function audioConstruct($arr) {
        if (empty($arr['audioUrl'])) return false ;
        else {
            if (preg_match("/^http/i", $arr['audioUrl'])) {
                $template = array(
                    'attachment' => array(
                        'type'      => 'audio',
                        'payload'   => array(
                            'url'           => $arr['audioUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;
            }
            else {
                $template = array(
                    'attachment' => array(
                        'type'      => 'audio',
                        'payload'   => array(
                            'attachment_id' => $arr['audioUrl']
                            // 'is_reusable'   => true,
                        ),
                    ),
                ) ;

            }
            
            return $template ;
        }
    }
    ##

    //建構 button
    private function buttonConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            //產出 action
            $acts = array() ;
            
            $act_max = 3 ;
            $i = 0 ;
            foreach ($arr['buttons'] as $k => $v) {
                $acts[] = $this->actionsConstruct($v) ;
                
                if ((++ $i) >= $act_max) break ;
            }
            ##
            
            $template = array(
                'attachment' => array(
                    'type'      => 'template',
                    'payload'   => array(
                        'template_type' => 'button',
                        'text'          => $arr['text'],
                        'buttons'       => $acts,
                    ),
                ),
            ) ;
            
            return $template ;
        }
    }
    ##

    //建構 generic (elements 1 ~ 10)
    private function genericConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            //產出 elements
            $elements = array() ;
            
            $elements_max = 10 ;
            $i = 0 ;
            foreach ($arr['elements'] as $k => $v) {
                $elements[] = $this->elementsConstruct($v) ;
                
                if ((++ $i) >= $elements_max) break ;
            }
            ##
            
            $template = array(
                'attachment' => array(
                    'type'      => 'template',
                    'payload'   => array(
                        'template_type' => 'generic',
                        'elements'      => $elements,
                    ),
                ),
            ) ;
            
            return $template ;
        }
    }
    ##

    //建構 list (elements 2 ~ 4)
    private function listConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            //產出 elements
            $elements = array() ;
            
            $elements_max = 10 ;
            $i = 0 ;
            foreach ($arr['elements'] as $k => $v) {
                $elements[] = $this->elementsConstruct($v) ;
                
                if ((++ $i) >= $elements_max) break ;
            }
            ##

            //產出下方 BUTTON
            $buttons = array() ;
            $buttons[] = $this->actionsConstruct($arr['buttons']) ;
            ##
            
            $arr['top_element_style'] = (preg_match("/^large$/i", $arr['top_element_style'])) ? 'compact' : 'large' ;
            $template = array(
                'attachment' => array(
                    'type'      => 'template',
                    'payload'   => array(
                        'template_type'     => 'list',
                        'top_element_style' => $arr['top_element_style'],
                        'elements'          => $elements,
                        'buttons'           => $buttons,
                    ),
                ),
            ) ;
            
            return $template ;
        }
    }
    ##

    //Quick Reply
    private function quickReply($arr=array()) {
        if (empty($arr)) return false ;
        else {
            if (empty($arr['actions'])) return false ;
            
            $quick_replies = array() ;
            foreach ($arr['actions'] as $k => $v) {
                $quick_replies[] = $this->quickReplyConstruct($v) ;
            }
            
            if (!empty($arr['text'])) {
                $template = array(
                    'text'          => $arr['text'],
                    'quick_replies' => $quick_replies,
                ) ;
            }
            else if (!empty($arr['template'])) {
                $attach = array() ;
                
                if (!empty($arr['template']['buttonMenu'])) {
                    $attach = $this->buttonConstruct($arr['template']['buttonMenu']) ;
                }
                else if (!empty($arr['template']['genericMenu'])) {
                    $attach = $this->genericConstruct($arr['template']['genericMenu']) ;
                }
                else if (!empty($arr['template']['listMenu'])) {
                    $attach = $this->listConstruct($arr['template']['listMenu']) ;
                }
                else if (!empty($arr['template']['media'])) {
                    $attach = $this->sendMedia($arr['template']['media']) ;
                }
                else if (!empty($arr['template']['video'])) {
                    $attach = $this->videoConstruct($arr['template']['video']) ;
                }
                else if (!empty($arr['template']['audio'])) {
                    $attach = $this->audioConstruct($arr['template']['audio']) ;
                }
                else if (!empty($arr['template']['image'])) {
                    $attach = $this->imageConstruct($arr['template']['image']) ;
                }
                
                $template = array(
                    'attachment'    => $attach['attachment'],
                    'quick_replies' => $quick_replies,
                ) ;
            }
            
            return $template ;
        }
    }
    ##

    //send media
    private function sendMedia($arr) {
        if (empty($arr)) return false ;

        //建立選單
        $elements = array() ;
        $elements[] = $this->mediaConstruct($arr) ;

        $template = array(
            'attachment' => array(
                'type'      => 'template',
                'payload'   => array(
                    'template_type'     => 'media',
                    'elements'          => $elements,
                ),
            ),
        ) ;
        
        return $template ;
        ##
    }
    ##

    //建構 elements
    private function elementsConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            //產出 action
            $acts = array() ;
            
            $act_max = 3 ;
            $i = 0 ;
            foreach ($arr['buttons'] as $k => $v) {
                $acts[] = $this->actionsConstruct($v) ;
                
                if ((++ $i) >= $act_max) break ;
            }
            ##
            
            //default_action
            $default_acts = $this->default_actionConstruct($arr['default_action']) ;
            ##
            
            $template = array(
                'title'             => $arr['title'],
                'image_url'         => $arr['image_url'],
                'subtitle'          => $arr['subtitle'],
                'buttons'           => $acts,
            ) ;
            
            if (!empty($default_acts)) $template['default_action'] = $default_acts ;
            
            return $template ;
        }
    }
    ##

    //建構 actions
    private function actionsConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            $acts = array() ;
            
            if ($arr['type'] == 'postback') {
                $acts = array(
                    'type'      => 'postback',
                    'title'     => $arr['title'],
                    'payload'   => $arr['postback'],
                ) ;
            }
            else if ($arr['type'] == 'url') {
                $acts = array(
                    'type'                  => 'web_url',
                    'title'                 => $arr['title'],
                    'url'                   => $arr['url'],
                    'webview_height_ratio'  => $arr['webview_height_ratio'],
                ) ;
            }
            
            return $acts ;
        }
    }
    ##

    //建構預設動作行為
    private function default_actionConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {  
            if (empty($arr)) $default_acts = array() ;
            else {
                $default_acts = array(
                    'type'                  => 'web_url',
                    'url'                   => $arr['url'],
                    'webview_height_ratio'  => $arr['webview_height_ratio'],
                ) ;
            }
            
            return $default_acts ;
        }
    }
    ##

    //建構quick reply actions
    private function quickReplyConstruct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            $acts = array() ;
            
            if ($arr['type'] == 'text') {
                $acts = array(
                    'content_type'  => 'text',
                    'title'         => $arr['title'],
                    'payload'       => $arr['postback'],
                ) ;
                
                if (!empty($arr['image_url'])) $acts['image_url'] = $arr['image_url'] ;
            }
            else if ($arr['type'] == 'user_phone_number') {
                $acts = array(
                    'content_type'  => 'user_phone_number',
                ) ;
                if (!empty($arr['image_url'])) $acts['image_url'] = $arr['image_url'] ;
            }
            else if ($arr['type'] == 'user_email') {
                $acts = array(
                    'content_type'  => 'user_email',
                ) ;
                if (!empty($arr['image_url'])) $acts['image_url'] = $arr['image_url'] ;
            }
            
            return $acts ;
        }
    }
    ##

    //建構 media
    private function mediaConstruct($arr=array()) {
        //建立選單 payload 內容
        $elements = array() ;
        if (!empty($arr['image'])) {
            $elements['media_type'] = 'image' ;
            
            if (preg_match("/^\d+$/iu", $arr['image'])) $elements['attachment_id'] = $arr['image'] ;
            else $elements['url'] = $arr['image'] ;
        }
        else if (!empty($arr['video'])) {
            $elements['media_type'] = 'video' ;
            
            if (preg_match("/^\d+$/iu", $arr['video'])) $elements['attachment_id'] = $arr['video'] ;
            else $elements['url'] = $arr['video'] ;
        }
        ##
        
        //建立按鈕
        $btn = array_pop($arr['buttons']) ;
        
        $buttons = array() ;
        if (!empty($btn)) {
            $buttons[] = $this->actionsConstruct($btn) ;
        }
        
        if (!empty($buttons)) $elements['buttons'] = $buttons ;
        ##
        
        return $elements ;
    }
    ##

    //建立選單項目
    private function menu_construct($arr=array()) {
        if (empty($arr)) return false ;
        else {
            $max_button = 20;
            
            $locale = empty($arr['locale']) ? 'default' : $arr['locale'];
            
            $elements = array() ;
            $elements['locale'] = $locale ;
            $elements['composer_input_disabled'] = (preg_match("/^N$/i", $arr['input'])) ? true : false ;
            
            $elem = array() ;
            foreach ($arr['menuItem'] as $k => $v) {
                if (strtolower($v['type']) == 'postback') {
                    $elem[] = array(
                        'type'      => 'postback',
                        'title'     => $v['title'],
                        'payload'   => $v['postback'],
                    ) ;
                }
                // else if (strtolower($v['type']) == 'url') {
                else if (in_array(strtolower($v['type']), ['url', 'web_url'])) {
                    if (empty($v['webview_height_ratio'])) $v['webview_height_ratio'] = 'full' ;
                    
                    $elem[] = array(
                        'type'                  => 'web_url',
                        'title'                 => $v['title'],
                        'url'                   => $v['url'],
                        'webview_height_ratio'  => $v['webview_height_ratio'],
                    ) ;
                }
                
                if ($k > $max_button) break;
            }
            $elements['call_to_actions'] = $elem ;
            
            return $elements ;
        }
    }
    ##
    
    //透過messenger回覆comment
    private function messenger_reply($arr=array(), $type='TEXT') {
        if (empty($arr)) return false ;
        else {
            $comment_id = $arr['comment_id'] ;
            $persona_id = empty($arr['persona_id']) ? '' : $arr['persona_id'] ;
            $type = $arr['actionType'];
            
            $post_data = array() ;
            if ($type == 'text') {
                $post_data = $this->textConstruct($arr[$type]) ;
            }
            else if ($type == 'image') {
                $post_data = $this->imageConstruct($arr[$type]) ;
            }
            else if ($type == 'audio') {
                $post_data = $this->audioConstruct($arr[$type]) ;
            }
            else if ($type == 'video') {
                $post_data = $this->videoConstruct($arr[$type]) ;
            }
            else if ($type == 'buttonMenu') {
                $post_data = $this->buttonConstruct($arr[$type]) ;
            }
            else if ($type == 'genericMenu') {
                $post_data = $this->genericConstruct($arr[$type]) ;
            }
            else if ($type == 'quickReply') {
                $post_data = $this->quickReply($arr[$type]) ;
            }
            
            if (empty($post_data)) return false ;
            else return $this->push($comment_id, $post_data, 'RESPONSE', 'comment_id', $persona_id);
        }
    }
    ##
    
    //透過page回覆comment
    private function page_reply($arr=array()) {
        if (empty($arr)) return false ;
        else {
            $comment_id = $arr['comment_id'] ;
            
            $replies = [];
            $replies['access_token'] = $this->page_access_token;
            
            if ($arr['like'] == 'Y') {
                $this->page_comment_like($comment_id, 'like', $replies);
            }
            
            if (!empty($arr['message'])) {
                $replies['message'] = $arr['message'];
            }
                
            if (!empty($arr['image'])) {
                if (preg_match("/^\d+$/", $arr['image'])) $replies['attachment_id'] = $arr['image'];
                else if (preg_match("/^http/", $arr['image'])) $replies['attachment_url'] = $arr['image'];
            }
            
            if (!empty($arr['message']) || !empty($arr['image'])) {
                $this->page_comment_like($comment_id, 'comment', $replies);
            }
            
            return true;
        }

    }
    ##
    
    //
    private function page_comment_like($comment_id, $action, $replies) {
        //請求 log
        $reply_log = $this->log_path.'/reply' ;
        if (!is_dir($reply_log)) $tf = mkdir($reply_log, 0777, true) ;
        $reply_log .= '/reply_'.date("Ymd").'.log' ;
        ##
        
        $url = 'https://graph.facebook.com/'.$this->graph_version.'/'.$comment_id.'/';
        
        if ($action == 'like') {
            $url .= 'likes' ;
        } else {
            $url .= 'comments' ;    
        }
        
        $postdata = http_build_query($replies);

        $opts = array('http' =>
            array(
                'method'  => 'POST',
                'content' => $postdata
            )
        ) ;
        
        $context = stream_context_create($opts) ;
        $result = @file_get_contents($url, false, $context) ;
        $arr = json_decode($result, true) ;
        
        $process_log = 'End-Point:'."\n".$url."\n" ;
        $process_log .= 'Request:'."\n".json_encode($replies, JSON_UNESCAPED_UNICODE)."\n" ;
        $process_log .= 'Response:'."\n".print_r($result, true)."\n" ;
        
        file_put_contents($reply_log, date("Y-m-d H:i:s")."\n".$process_log."\n", FILE_APPEND) ;
        
        return (empty($arr['id'])) ? false : $result ;
    }
    ##
    
    //Get User Profile
    private function GetProfile($token) {
        $url = 'https://graph.facebook.com/'.$token.'?fields=first_name,last_name,profile_pic&access_token='.$this->page_access_token ;
        $json = @file_get_contents($url) ;
        $user = array() ;
        $user = json_decode($json, true) ;
        
        return array(
            'psid' => $user['id'],
            'name' => $user['name'],
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'picture' => $user['profile_pic'],
            'locale' => $user['locale'],
            'timezone' => $user['timezone'],
            'gender' => $user['gender'],
        ) ;
    }
    ##
    
    //delete menu
    private function delete_menu($arr) {
        $data = array('fields' => array('persistent_menu')) ;
        return $this->menu_curl($arr['psid'], $data, 'DELETE') ;
    }
    ##
    
    //setup menu
    private function startup_menu($arr=array()) {
        $elements = array() ;
        $elements[] = $this->menu_construct($arr) ;
        
        $data = array('persistent_menu' => $elements) ;
        if (!empty($arr['psid'])) $data = array_merge($data, ['psid' => $arr['psid']]);
        
        return $this->menu_curl($arr['psid'], $data) ;
    }
    ##
    
    //留言回覆
    private function comment_reply($arr=array()) {
        if (empty($arr)) return false ;
        else {
            $arr['plateform'] = strtoupper($arr['plateform']) ;
            if ($arr['plateform'] == 'M') {
                return $this->messenger_reply($arr) ;
            }
            else if ($arr['plateform'] == 'P') {
                return $this->page_reply($arr) ;
            }
            else return false ;
        }
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
    
    
    /**************** 發送 ******************/
    //PUSH 方式發送
    public function push($userId, $post_data, $message_type='RESPONSE', $recipient_type='id', $persona_id='') {
        if ($recipient_type == 'comment_id') $recipient = ['comment_id' => $userId];
        else if ($recipient_type == 'one_time_notif_token') $recipient = ['one_time_notif_token' => $userId];
        else $recipient = ['id' => $userId];
        
        $data = array(
            'recipient'         => $recipient,
            'messaging_type'    => $message_type,
            'message'           => $post_data,
        ) ;
        
        if (!empty($message_type) && $message_type != 'RESPONSE') {
            $data['messaging_type'] = 'MESSAGE_TAG';
            $data['tag'] = $message_type;
        }
        
        if (!empty($persona_id)) $data['persona_id'] = $persona_id ;
        
        $res = $this->curl($data) ;
        
        return $res ;
    }
    ##
    
    //輸出入顯示動作
    public function mark_seen($psid, $persona_id='') {      //將最後一則訊息標示為已讀
        $data = array(
            'recipient' => array('id' => $psid),
            'sender_action' => 'mark_seen',
        ) ;
        
        if (!empty($persona_id)) $data['persona_id'] = $persona_id ;
        
        return $this->curl($data) ;
    }
    
    public function typing_on($psid, $persona_id='') {      //開啟輸入指示器
        $data = array(
            'recipient' => array('id' => $psid),
            'sender_action' => 'typing_on',
        ) ;
        
        if (!empty($persona_id)) $data['persona_id'] = $persona_id ;
        
        return $this->curl($data) ;
    }
    
    public function typing_off($psid, $persona_id='') {     //關閉輸入指示器
        $data = array(
            'recipient' => array('id' => $psid),
            'sender_action' => 'typing_off'
        ) ;
        
        if (!empty($persona_id)) $data['$persona_id'] = $persona_id ;
        
        return $this->curl($data) ;
    }
    ##
    
    //curl 發送
    private function curl($post_data=array()) {
        //請求 log
        $reply_log = $this->log_path.'/reply' ;
        if (!is_dir($reply_log)) $tf = mkdir($reply_log, 0777, true) ;
        $reply_log .= '/reply_'.date("Ymd").'.log' ;
        ##
        
        if (empty($this->page_access_token)) $this->stop_action(400, '未指定 channel access token') ;
        
        $header = array(
            'Content-Type: application/json; charset=utf-8'
        ) ;
        
        // $url = 'https://graph.facebook.com/v3.3/me/messages?access_token='.$this->page_access_token ;
        $url = 'https://graph.facebook.com/'.$this->graph_version.'/me/messages?access_token='.$this->page_access_token ;    //不支援list template
        
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
        $process_log .= 'Response(Header):'."\n".$result."\n" ;
        $process_log .= 'Response(Body):'."\n".json_encode($returnCode, JSON_UNESCAPED_UNICODE)."\n" ;
        
        file_put_contents($reply_log, date("Y-m-d H:i:s")."\n".$process_log."\n", FILE_APPEND) ;

        return $result ;
    }
    ##
    
    //menu curl
    private function menu_curl($psid, $data, $type='POST') {
        //請求 log
        $reply_log = $this->log_path.'/reply' ;
        if (!is_dir($reply_log)) $tf = mkdir($reply_log, 0777, true) ;
        $reply_log .= '/reply_'.date("Ymd").'.log' ;
        ##
        
        $type = strtoupper($type) ;
        
        if (empty($psid)) {
            $url = 'https://graph.facebook.com/'.$this->graph_version.'/me/messenger_profile' ;
            $data['access_token'] = $this->page_access_token ;
        } else {
            if ($type == 'POST') $url = 'https://graph.facebook.com/'.$this->graph_version.'/me/custom_user_settings?access_token='.$this->page_access_token ;
            else $url = 'https://graph.facebook.com/'.$this->graph_version.'/me/custom_user_settings?psid='.$psid.'&params=[%22persistent_menu%22]&access_token='.$this->page_access_token ;
        }
        
        $headers = [
            'Content-Type: application/json',
        ] ;
        
        $process = curl_init($url) ;
        curl_setopt($process, CURLOPT_HTTPHEADER, $headers) ;
        curl_setopt($process, CURLOPT_HEADER, false) ;
        curl_setopt($process, CURLOPT_TIMEOUT, 30) ;
        curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($process, CURLOPT_POST, 1) ;
        curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($data)) ;

        if ($type == 'DELETE') {
            curl_setopt($process, CURLOPT_CUSTOMREQUEST, "DELETE") ;
        }

        curl_setopt($process, CURLOPT_RETURNTRANSFER, true) ;
        $result = curl_exec($process) ;
        curl_close($process) ;
        
        $process_log = 'End-Point:'."\n".$url."\n" ;
        $process_log .= 'Request:'."\n".json_encode($data, JSON_UNESCAPED_UNICODE)."\n" ;
        $process_log .= 'Response:'."\n".json_encode($result, JSON_UNESCAPED_UNICODE)."\n" ;
        
        file_put_contents($reply_log, date("Y-m-d H:i:s")."\n".$process_log."\n", FILE_APPEND) ;
        
        return $return ;
    }
    ##
}
?>