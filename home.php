<?php
/**
 * home.php
 *
 * Captcha view home page
 *
 * @package    Captcha
 * @author     Avinash Dalvi(aviboy2006)
 * @copyright  2019 aviboy2006  
 */
session_start();
$msg = 0;
if (isset($_POST['Submit'])) {
    // code for check server side validation
    if (empty($_SESSION['captcha_code']) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0) {
        $msg = 1;
    } else { // Captcha verification is Correct. Final Code Execute here!
        $msg = 2;
    }
}
?>
<!DOCTYPE html>
<html>
 <head>
   <title> Custom Captcha Code Test ! </title>
   <!-- Latest compiled and minified CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous"> 
   <script type='text/javascript'>
      function refreshCaptcha(){
        var img = document.images['captchaimg'];
        img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
      }
   </script>
  </head>
  <body>
    
 
     <div class="container">

        <div class="page-header">
           <h1>Custom Captcha <small>Lets Enjoy!</small></h1>
        </div>
        <div class="row">
        <div class="col-sm-4 formdiv">
          <form action="" method="post" name="form1" id="form1" >
             
             <?php
                if ($msg == 1) {
                ?>
             <div class="alert alert-success" role="alert">The Validation code has been matched. </div>
             <?php
                } else if ($msg == 2) {
                ?>
             <div class="alert alert-danger" role="alert">The Validation code does not match!</div>
             <?php
                }
                ?> 
             <div class="form-group">
                <img src="get-captcha.php?rand=<?php
                   echo rand();
                   ?>" id='captchaimg'><br>
             </div>
             <div class="form-group">
                <label for="pwd">You can enter code here:</label>
                <input id="captcha_code" name="captcha_code" type="text" class="form-control">
             </div>
             <div class="form-group">
               <small class="form-text text-muted">
               Not able to read image ? click <a onClick="refreshCaptcha();">here</a> to get new one. </small>
             </div>
             <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
      
  </body>
 </html>
 