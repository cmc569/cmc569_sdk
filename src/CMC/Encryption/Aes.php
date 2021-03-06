<?php
namespace CMC\Encryption;

//AES 編碼(AES-256-CBC)
Class AES {
	private $cipherMethod ;
	private $key ;
	private $iv ;
	
	public function __construct($key='accuhitwithwonderaccubot') {
		$this->cipherMethod = 'AES-256-CBC' ;
		$this->key = $key ;
	}
	
	public function encode($rawString) {
		$this->iv = empty($iv) ? $this->getIV(openssl_cipher_iv_length($this->cipherMethod)) : $iv ;
		$encryptedString = openssl_encrypt($rawString, $this->cipherMethod, $this->key, 0, $this->iv) ;
		
		return $this->iv.$encryptedString ;
	}
	
	public function decode($encryptedString) {
        $iv = substr($encryptedString, 0, 16) ;
        $encryptedString = substr($encryptedString, 16) ;
		$decryptedString = openssl_decrypt($encryptedString, $this->cipherMethod, $this->key, 0, $iv) ;
		
		return $decryptedString ;
	}
	
	public function bencode($rawString) {
		$this->iv = empty($iv) ? $this->getIV(openssl_cipher_iv_length($this->cipherMethod)) : $iv ;
		$encryptedString = openssl_encrypt($rawString, $this->cipherMethod, $this->key, 0, $this->iv) ;
		
		return base64_encode($this->iv.$encryptedString) ;
	}
	
	public function bdecode($encryptedString) {
        $encryptedString = base64_decode($encryptedString) ;
        $iv = substr($encryptedString, 0, 16) ;
        $encryptedString = substr($encryptedString, 16) ;
		$decryptedString = openssl_decrypt($encryptedString, $this->cipherMethod, $this->key, 0, $iv) ;
		
		return $decryptedString ;
	}
	
	private function getIV($maxLength=16) {
		$chTable = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
		$iv = '' ;
		
		while (strlen($iv) < 16) {
			$iv .= substr($chTable, rand(0, strlen($chTable)), 1) ;
			if (strlen($iv) >= 16) break ;
		}
		
		return $iv ;
	}
}
##
?>