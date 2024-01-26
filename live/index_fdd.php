<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta http-equiv="cache-control" content="max-age=0" />
      <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
      <meta http-equiv="expires" content="0" />
      <meta http-equiv="pragma" content="no-cache" />
      <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon" />
      <title><?php echo exec('cat /etc/hostname'); ?> Live Caller Display</title>
      <script type="text/javascript" src="jquery.min.js"></script>
      <script type="text/javascript" src="functions.js"></script>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="w3.css">
      <style>
       body {
         -ms-word-break: break-all;
         word-break: break-all;
         word-break: break-word;
         -webkit-hyphens: auto;
         -moz-hyphens: auto;
         -ms-hyphens: auto;
         hyphens: auto;
       }
      </style>
    </head>

<?php
// Check if the config file exists
if (file_exists('/etc/pistar-css.ini')) {
        $piStarCssFile = '/etc/pistar-css.ini';
        if (fopen($piStarCssFile,'r')) { $piStarCss = parse_ini_file($piStarCssFile, true); }
        $piStarCssPage = $piStarCss['Background']['Page'];
        $piStarCssContent = $piStarCss['Background']['Content'];
}
?>

    <body style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssPage; ?>">
      <script type="text/javascript">
        $(function() {
          setInterval(function(){
            $('#liveDetails').load('/live/live_caller_backend_fdd.php');
          }, 1500);
        });
      </script>
      <div id="liveDetails">
        <?php include 'live_caller_backend_fdd.php'; ?>
      </div>
    </body>
</html>
