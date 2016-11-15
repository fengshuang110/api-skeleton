<?php

namespace Application\Libs;

class AES{
     
    private $_secret_key = 'yestem11yestem11yestem11yestem11';
     
    public function setKey($key) {
        $this->_secret_key = $key;
    }
    const CIPHER = MCRYPT_RIJNDAEL_128;
    const MODE = MCRYPT_MODE_ECB;

    function addPkcs7Padding($string, $blocksize = 32) {
        $len = strlen($string); //取得字符串长度
        $pad = $blocksize - ($len % $blocksize); //取得补码的长度
        $string .= str_repeat(chr($pad), $pad); //用ASCII码为补码长度的字符， 补足最后一段
        return $string;
    }

    function stripPkcs7Padding($string){
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if(preg_match("/$slastc{".$slast."}/", $string)){
            $string = substr($string, 0, strlen($string)-$slast);
            return $string;
        } else {
            return false;
        }
    }


    public function encode($data) {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER, self::MODE),MCRYPT_RAND);
        $padding = $this->addPkcs7Padding($data);
        return base64_encode(mcrypt_encrypt(self::CIPHER, $this->_secret_key, $this->addPkcs7Padding($data, 16), self::MODE, $iv));
        return base64_encode(mcrypt_encrypt(self::CIPHER, $this->_secret_key, $data, self::MODE, $iv));
    }
     
    public function decode($data) {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(self::CIPHER,self::MODE),MCRYPT_RAND);
        $encryptedText =base64_decode($data);
        return $this->stripPkcs7Padding(mcrypt_decrypt(self::CIPHER, $this->_secret_key, $encryptedText, self::MODE, $iv));
    }
}
