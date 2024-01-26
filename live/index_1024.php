<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> -->
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
      <style>
	body { background-color: #808080; color: #ffffff; margin: 0px 0px; }
	table { border-color: #000000; font-weight: bold; }
	.frame1 {background-color: #808080;border: solid 1px #000000;border-top-color: #C1C0C1;border-right-color: #8D8D8D;border-left-color: #3E3E3E;border-bottom-color: #4A4A4A;}
	.frame2 {background-color: #DBDAD4;border: solid 1px #000000;border-top-color: #BEBCBC;border-right-color: #A7A5A1;border-left-color: #A7A5A1;border-bottom-color: #BAB8B7;}
      </style>
    </head>
    <body>
      <script type="text/javascript">
        $(function() {
          setInterval(function(){
            $('#liveDetails').load('/live/live_caller_backend_1024.php');
          }, 1500);
        });
      </script>
      <div id="liveDetails">
        <?php include 'live_caller_backend_1024.php'; ?>
      </div>
    </body>
</html>
