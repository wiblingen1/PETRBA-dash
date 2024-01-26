<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
      <link rel="stylesheet" type="text/css" href="/live/live-caller.css" />
    </head>
    <body>
      <script type="text/javascript">
        $(function() {
          setInterval(function(){
            $('#liveDetails').load('/live/live_caller_backend.php');
          }, 1500);
        });
      </script>
      <div id="liveDetails">
        <?php include 'live_caller_backend.php'; ?>
      </div>
    </body>
</html>
