<?php
namespace tanchengjin\captcha;

class Captcha
{
    private $image=null;

    private $vCode='';

    private $vCodeNum=4;

    private $text='abcdefghjklmnopqrstuvwxyz0123456789';

    private $height=30;
    private $width=100;

    public function __construct($w=100,$h=30,$num=4)
    {
        $this->width=$w;
        $this->height=$h;
        $this->vCodeNum=$num;
    }

    private function call(){
        $this->createImage($this->width,$this->height);
        $this->writeText();
        $this->setDisturb();
        $this->output();
    }

    private function startSession()
    {
        if(!isset($_SESSION)){
            session_start();
        }
    }
    private function writeSession($key,$value)
    {
        $this->startSession();

        $_SESSION[$key]=strtoupper($value);
    }
    public function verify($code){
        $this->startSession();

        return strtoupper($code) == $_SESSION['code']?true:false;
    }
    private function createImage($w,$h)
    {
        $this->image=imagecreatetruecolor($w,$h);
        $color=imagecolorallocate($this->image,255,255,255);
        imagefill($this->image,0,0,$color);
    }

    private function createVerificationCode(){
        for ($i=0;$i<$this->vCodeNum;$i++){
            if(empty($this->vCode)){
                $this->vCode=$this->text{rand(0,strlen($this->text)-1)};
            }else{
                $this->vCode.=$this->text{rand(0,strlen($this->text)-1)};
            }
        }
        $this->writeSession('code',$this->vCode);
    }

    private function writeText()
    {
        $this->createVerificationCode();
        for ($i=0;$i<strlen($this->vCode);$i++){
            $fontColor=imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            $fontSize=rand(5,8);
            $x=floor($this->width/$this->vCodeNum)*$i+5;
            $y=rand(0,$this->height-imagefontheight($fontSize));
            imagechar($this->image,$fontSize,$x,$y,$this->vCode{$i},$fontColor);
        }
    }

    private function setDisturb()
    {
        #set pixel
        for ($i=0;$i<=floor($this->width*$this->height)/15;$i++){
            $color=imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($this->image,rand(0,$this->width),rand(0,$this->height),$color);
        }

        #sex arc
        for ($i=0;$i<2;$i++){
            $color=imagecolorallocate($this->image,rand(0,255),rand(0,255),rand(0,255));
            imagearc($this->image,rand(0,$this->width),rand(0,$this->height),rand(floor($this->width/2),$this->width),rand(floor($this->height/2),$this->height),20,360,$color);
        }


    }
    private function output()
    {
        if(imagetypes() & IMG_PNG){
            header('Content-type: image/png');
            imagepng($this->image);
        }elseif(imagetypes() & IMG_JPEG){
            header('Content-type: image/jpeg');
            imagepng($this->image);
        }elseif(imagetypes() & IMG_JPG){
            header('Content-type: image/jpg');
            imagepng($this->image);
        }elseif(imagetypes() & IMG_GIF){
            header('Content-type: image/gif');
            imagepng($this->image);
        }else{
            exit(404);
        }
    }
    public function __toString()
    {
        $this->call();
        return '';
    }

    public function __destruct()
    {
        if(isset($this->image)){
            imagedestroy($this->image);
        }

    }

    /**
     * @param $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function display()
    {
        $this->call();
    }
}