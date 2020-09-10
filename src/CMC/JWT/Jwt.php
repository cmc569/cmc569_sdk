<?php
//version 1.0
namespace CMC\JWT;

class Jwt {
    private $key;
    private $header;
    private $payload;
    private $signature;
    
    public function __construct($key)
    {
        $this->key = $key;
        $this->header = $this->base64url_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    }

    private function base64url_encode($data)
    {                                                                                                             
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');                                                                                                              
    }
                                                                                                                                                                             
    private function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));                                                                          
    }

    public function jwt_encode($body)
    {
        $this->payload = $this->base64url_encode(json_encode($body));
        $this->signature = hash_hmac('SHA256', $this->header.'.'.$this->payload, $this->key, true);
        return $this->header.'.'.$this->payload.'.'.$this->base64url_encode($this->signature);
    }
    
    public function jwt_decode($encode)
    {
        list($header, $payload, $signature) = explode('.', $encode);
        if ($this->jwt_check($header, $payload, $signature)) {
            return [
                'header'    => json_decode($this->base64url_decode($header), true),
                'payload'   => json_decode($this->base64url_decode($payload), true),
                'signature' => $signature,
            ];
        }
        else return false;
    }
    
    public function jwt_check($header, $payload, $signature) {
        $check_signature = $this->base64url_encode(hash_hmac('SHA256', $header.'.'.$payload, $this->key, true));
        return ($signature == $check_signature) ? true : false;
    }
}

?>