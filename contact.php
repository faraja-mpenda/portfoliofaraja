<?php
function ValidateEmail($email)
{
   $pattern = '/^([0-9a-z]([-.\w]*[0-9a-z])*@(([0-9a-z])+([-\w]*[0-9a-z])*\.)+[a-z]{2,6})$/i';
   return preg_match($pattern, $email);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['formid']) && $_POST['formid'] == 'form1')
{
   $mailto = 'swediroben@gmail.com';
   $mailfrom = isset($_POST['email']) ? $_POST['email'] : $mailto;
   $subject = 'Mon porte folio';
   $message = 'Values submitted from web site form:';
   $success_url = './contact.php';
   $error_url = './contact.php';
   $eol = "\n";
   $error = '';
   $internalfields = array ("submit", "reset", "send", "filesize", "formid", "captcha", "recaptcha_challenge_field", "recaptcha_response_field", "g-recaptcha-response", "h-captcha-response");
   $boundary = md5(uniqid(time()));
   $header  = 'From: '.$mailfrom.$eol;
   $header .= 'Reply-To: '.$mailfrom.$eol;
   $header .= 'MIME-Version: 1.0'.$eol;
   $header .= 'Content-Type: multipart/mixed; boundary="'.$boundary.'"'.$eol;
   $header .= 'X-Mailer: PHP v'.phpversion().$eol;

   try
   {
      if (!ValidateEmail($mailfrom))
      {
         $error .= "The specified email address (" . $mailfrom . ") is invalid!\n<br>";
         throw new Exception($error);
      }
      $message .= $eol;
      $message .= "IP Address : ";
      $message .= $_SERVER['REMOTE_ADDR'];
      $message .= $eol;
      foreach ($_POST as $key => $value)
      {
         if (!in_array(strtolower($key), $internalfields))
         {
            if (is_array($value))
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . implode(",", $value) . $eol;
            }
            else
            {
               $message .= ucwords(str_replace("_", " ", $key)) . " : " . $value . $eol;
            }
         }
      }
      $body  = 'This is a multi-part message in MIME format.'.$eol.$eol;
      $body .= '--'.$boundary.$eol;
      $body .= 'Content-Type: text/plain; charset=ISO-8859-1'.$eol;
      $body .= 'Content-Transfer-Encoding: 8bit'.$eol;
      $body .= $eol.stripslashes($message).$eol;
      if (!empty($_FILES))
      {
         foreach ($_FILES as $key => $value)
         {
             if ($_FILES[$key]['error'] == 0)
             {
                $body .= '--'.$boundary.$eol;
                $body .= 'Content-Type: '.$_FILES[$key]['type'].'; name='.$_FILES[$key]['name'].$eol;
                $body .= 'Content-Transfer-Encoding: base64'.$eol;
                $body .= 'Content-Disposition: attachment; filename='.$_FILES[$key]['name'].$eol;
                $body .= $eol.chunk_split(base64_encode(file_get_contents($_FILES[$key]['tmp_name']))).$eol;
             }
         }
      }
      $body .= '--'.$boundary.'--'.$eol;
      if ($mailto != '')
      {
         mail($mailto, $subject, $body, $header);
      }
      header('Location: '.$success_url);
   }
   catch (Exception $e)
   {
      $errorcode = file_get_contents($error_url);
      $replace = "##error##";
      $errorcode = str_replace($replace, $e->getMessage(), $errorcode);
      echo $errorcode;
   }
   exit;
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Page</title>
<link href="images/LOGO 2.png" rel="icon">
<meta property="og:url" content="faraja_portfolio.com">
<meta property="og:image" content="images/_MG_8717nento.JPG">

<meta name="generator" content="portfolio faraja mpenda developpeur">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="protofolio_04_04.css" rel="stylesheet">
<link href="contact.css" rel="stylesheet"> 

<script src="jquery-1.12.4.min.js"></script>
<script>
$(document).ready(function()
{
   $("#wb_ResponsiveMenu1 ul li a").click(function(event)
   {
      $("#wb_ResponsiveMenu1 input").prop("checked", false);
   });
});
</script>
</head>
<body style="overflow-x:hidden;">
<a href="https://www.wysiwygwebbuilder.com" target="_blank"><img src="images/builtwithwwb17.png" alt="WYSIWYG Web Builder" style="position:absolute;left:441px;top:967px;margin: 0;border-width:0;z-index:250" width="16" height="16"></a>
<div id="wb_Form1">
<form name="contact" method="post" action="<?php echo basename(__FILE__); ?>" enctype="multipart/form-data" id="Form1">
<input type="hidden" name="formid" value="form1">
<label for="" id="Label1">Nom </label>
<input type="text" id="Editbox1" name="Editbox1" value="" spellcheck="false" placeholder="entrer votre nom ">
<label for="" id="Label3">Email</label>
<input type="text" id="Editbox2" name="Editbox2" value="" spellcheck="false" placeholder="entrer votre email">
<label for="" id="Label5">Message</label>
<textarea name="TextArea1" id="TextArea1" rows="4" cols="29" spellcheck="false" placeholder="votre message"></textarea>
<input type="submit" id="Button1" name="Envoyer" value="Submit">
</form>
</div>
<header id="Layer1">
<div id="Layer1_Container">
<div id="wb_ResponsiveMenu1">
<label class="toggle" for="ResponsiveMenu1-submenu" id="ResponsiveMenu1-title"><span id="ResponsiveMenu1-icon"><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span></span></label>
<input type="checkbox" id="ResponsiveMenu1-submenu">
<ul class="ResponsiveMenu1" id="ResponsiveMenu1" role="menu">
<li role="menuitem"><a href="./index.html">Home</a></li>
<li role="menuitem"><a href="./projets.html">PROJETS</a></li>
<li role="menuitem"><a href="./cv.html">CV</a></li>
<li role="menuitem"><a href="./contact.php">CONTACT</a></li>
</ul>
</div>
<div id="wb_Image1">
<img src="images/LOGO 2.png" id="Image1" alt="" width="45" height="34"></div>
<div id="wb_Text2">
<span style="color:#F5F5F5;font-family:Arial;font-size:17px;"><strong>Faraja</strong></span></div>
<div id="wb_Text1">
<span style="background-color:#FFA500;color:#F5F5F5;font-family:Arial;font-size:11px;">swediroben@gmail.com</span></div>
<div id="wb_CssMenu1">
<ul id="CssMenu1" role="menubar" class="nav">
<li role="menuitem" class="nav-item firstmain"><a class="nav-link" href="./index.html" target="_self">HOME</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link" href="./projets.html" target="_self">PROJET</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link" href="./cv.html" target="_self">CV</a>
</li>
<li role="menuitem" class="nav-item"><a class="nav-link" href="./contact.php" target="_self">CONTACT</a>
</li>
</ul>
</div>
</div>
</header>
</body>
</html>