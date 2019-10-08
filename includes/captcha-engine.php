<?php
ini_set('display_errors', 'On');
/**
 * captcha-engine.php
 *
 * Captcha Generation and verification engine
 *
 * @package    Captcha
 * @author     Avinash Dalvi(aviboy2006)
 * @copyright  2019 aviboy2006   
 */
class captchaClass
{
    public function create($textColor, $backgroundColor, $imgWidth, $imgHeight, $noiceLines = 0, $noiceDots = 0, $noiceColor = '#162453')
    { 
        $text      = $this->getRandom();
        $font      = './font/monofont.ttf'; 
        $textColor = $this->hexToRGB($textColor);
        $fontSize  = $imgHeight * 0.75;
        
        $customImage = imagecreatetruecolor($imgWidth, $imgHeight);
        $textColor = imagecolorallocate($customImage, $textColor['r'], $textColor['g'], $textColor['b']);
        
        $backgroundColor = $this->hexToRGB($backgroundColor);
        $backgroundColor = imagecolorallocate($customImage, $backgroundColor['r'], $backgroundColor['g'], $backgroundColor['b']);
         
        if ($noiceLines > 0) {
            $noiceColor = $this->hexToRGB($noiceColor);
            $noiceColor = imagecolorallocate($customImage, $noiceColor['r'], $noiceColor['g'], $noiceColor['b']);
            for ($i = 0; $i < $noiceLines; $i++) {
                imageline($customImage, mt_rand(0, $imgWidth), mt_rand(0, $imgHeight), mt_rand(0, $imgWidth), mt_rand(0, $imgHeight), $noiceColor);
            }
        }
        
        if ($noiceDots > 0) { 
            for ($i = 0; $i < $noiceDots; $i++) {
                imagefilledellipse($customImage, mt_rand(0, $imgWidth), mt_rand(0, $imgHeight), 3, 3, $textColor);
            }
        }
        
        imagefill($customImage, 0, 0, $backgroundColor);
        list($x, $y) = $this->makeImageCenter($customImage, $text, $font, $fontSize);
        imagettftext($customImage, $fontSize, 0, $x, $y, $textColor, $font, $text);
        
        imagejpeg($customImage, NULL, 90); 
        header('Content-Type: image/jpeg'); 
        imagedestroy($customImage); 
        if (isset($_SESSION)) {
            $_SESSION['captcha_code'] = $text; 
        }
    } 

    protected function hexToRGB($colour)
    {
        if ($colour[0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[1],
                $colour[2] . $colour[3],
                $colour[4] . $colour[5]
            );
        } elseif (strlen($colour) == 3) {
            list($r, $g, $b) = array(
                $colour[0] . $colour[0],
                $colour[1] . $colour[1],
                $colour[2] . $colour[2]
            );
        } else {
            return false;
        }
        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);
        return array(
            'r' => $r,
            'g' => $g,
            'b' => $b
        );
    }
     
    protected function getRandom($chars=6,$letters = '23456789bcdfghjkmnpqrstvwxyz'){
                $str = '';
                for ($i=0; $i<$chars; $i++) { 
                        $str .= substr($letters, mt_rand(0, strlen($letters)-1), 1);
                }
                return $str;
    }
    
    protected function makeImageCenter($image, $text, $font, $size, $angle = 8)
            {   
                $result = array();
                $xi  = imagesx($image);
                $yi  = imagesy($image);
                $box = imagettfbbox($size, $angle, $font, $text);
                $xr  = abs(max($box[2], $box[4])) + 5;
                $yr  = abs(max($box[5], $box[7]));
                $x   = intval(($xi - $xr) / 2);
                $y   = intval(($yi + $yr) / 2);
                $result = array(
                     $x,
                    $y
                );

                return $result;
    }
    
}
?>