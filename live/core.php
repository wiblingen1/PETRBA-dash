<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/config/config.php'; // MMDVMDash Config
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/tools.php'; // MMDVMDash Tools
include_once $_SERVER['DOCUMENT_ROOT'].'/mmdvmhost/functions.php'; // MMDVMDash Functions

/* ---------- 13MAD86 ---------- */

// Check if the config file exists
if (file_exists('/etc/pistar-css.ini')) {
  $piStarCssFile = '/etc/pistar-css.ini';
  if (fopen($piStarCssFile,'r')) { $piStarCss = parse_ini_file($piStarCssFile, true); }
  $piStarCssContent = $piStarCss['Background']['Content'];
  $piStarCssBanner = $piStarCss['Background']['Banners'];
}

function sentence_cap($impexp, $sentence_split) {
    $textbad=explode($impexp, $sentence_split);
    $newtext = array();
    foreach ($textbad as $sentence) {
        $sentencegood=ucfirst(strtolower($sentence));
        $newtext[] = $sentencegood;
    }
    $textgood = implode($impexp, $newtext);
    return $textgood;
}

function timeago( $date, $now ) {
  $timestamp   = $date;
  $strTime     = array( "sec", "min", "hr", "day", "month", "year" );
  $length      = array( "60","60","24","30","12","10" );
  $currentTime = $now;
  if( $currentTime >= $timestamp ) {
    $diff = $currentTime - $timestamp;
    for( $i = 0; $diff >= $length[$i] && $i < count( $length ) - 1; $i++ ) {
      $diff = $diff / $length[$i];
    }
    $diff = round($diff);
    return sprintf( ngettext( "%d %s", "%d %ss", $diff ), $diff, $strTime[$i] ) . ' ago';
  }
}

function getName($callsign) {
    ini_set('default_socket_timeout', 2);
    $name = array();
    $TMP_CALL_NAME = "/tmp/Callsign_Name.txt";
    $cl_api = "https://callook.info/$callsign/json";
    if (file_exists($TMP_CALL_NAME)) {
        if (strpos($callsign,"-")) {
            $callsign = substr($callsign,0,strpos($callsign,"-"));
        }
        $delimiter =" ";
        $contents = exec("egrep -m1 '".$callsign.$delimiter."' ".$TMP_CALL_NAME, $output);
        if (count($output) !== 0) {
            $name = substr($output[0], strpos($output[0],$delimiter));
            $name = substr($name, strpos($name,$delimiter));
            return $name;
        }
    }
    $fp = fsockopen('ssl://callook.info', '443', $errno, $errstr, 2);
    if ($fp) {
        $options = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: en\r\n" .
                               "User-Agent: W0CHP-PiStar-Dash; Name Lookup Function - <https://w0chp.net/w0chp-pistar-dash/>\r\n"
                )
        );
        $context = stream_context_create($options);
        $api_data = file_get_contents($cl_api, false, $context);
        $result = json_decode($api_data);
        if ($result->status == 'INVALID') {
            $name = "---";
        } else {
            $name_full = $result->name;
            $name_array = explode(' ', $name_full);
            foreach($name_array as $key => $value) {
                $name = implode (" ", $name_array);
            }
            $name = ucwords(strtolower($name));
        }
        $fp = fopen($TMP_CALL_NAME .'.TMP', 'a');
        $TMP_STRING = $callsign .' '  .$name;
        fwrite($fp, $TMP_STRING.PHP_EOL);
        fclose($fp);
        exec('sort ' .$TMP_CALL_NAME.'.TMP' .' ' .$TMP_CALL_NAME .' | uniq  > ' .$TMP_CALL_NAME);
    } else {
        return _("Unable to connect to Call Sign Lookup API");
    }
}

function getInfoFromFile ($callsign) {
    if ($file = fopen ("/usr/local/etc/stripped.csv", "r")) {
        while (!feof ($file)) {
            $line = fgets ($file);
            $arr = explode ($callsign, $line, 2);
            if (isset ($arr[1]))
               return substr (str_replace(",", "</br>", $arr[1]), 5); /* return $arr[1]; */
        }
        fclose ($file);
    }

    return "---";
}
/* ---------- 13MAD86 ---------- */

if (!class_exists('xGeoLookup')) require_once($_SERVER['DOCUMENT_ROOT'].'/live/class.GeoLookup.php');                                                              
$Flags = new xGeoLookup();
$Flags->SetFlagFile("/usr/local/etc/country.csv");
$Flags->LoadFlags();
// $local_time = date('H:i:s') ." / ". date('m.d.Y');
$local_time = date('H:i:s');
$cpuTempCRaw = exec('cat /sys/class/thermal/thermal_zone0/temp');
if ($cpuTempCRaw > 1000) { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw / 1000, 1)); } else { $cpuTempC = sprintf('%.0f',round($cpuTempCRaw, 1)); }
$cpuTempF = sprintf('%.0f',round(+$cpuTempC * 9 / 5 + 32, 1));
if ($cpuTempC <= 59) { $cpuTempHTML = "<span style='color: #4CFF00;'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 60) { $cpuTempHTML = "<span style='color: #FFD800;'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }
if ($cpuTempC >= 80) { $cpuTempHTML = "<apan style='color: #FF0000;'>".$cpuTempF."&deg;F / ".$cpuTempC."&deg;C</span>\n"; }

$i = 0;
for ($i = 0;  ($i <= 0); $i++) {
    if (isset($lastHeard[$i])) {
        $listElem = $lastHeard[$i];
        if ( $listElem[2] ) {
            $utc_time = $listElem[0];
            $utc_tz =  new DateTimeZone('UTC');
            $local_tz = new DateTimeZone(date_default_timezone_get ());
            $dt = new DateTime($utc_time, $utc_tz);
            $dt->setTimeZone($local_tz);
            if (preg_match('/ /', $listElem[2])) {
                $listElem[2] = preg_replace('/ .*$/', "", $listElem[2]);
            }
            if (is_numeric($listElem[2]) !== FALSE) {
                $listElem[2] = $listElem[2];
            } elseif (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
                $listElem[2] = $listElem[2];
            } else {
                if (strpos($listElem[2],"-") > 0) {
                    $listElem[2] = substr($listElem[2], 0, strpos($listElem[2],"-"));
                }
            }
        }
    }
}

if (strpos($listElem[4], "via ")) {
    $listElem[4] = preg_replace("/via (.*)/", "$1", $listElem[4]);
}

if ( substr($listElem[4], 0, 6) === 'CQCQCQ' ) {
	$target = $listElem[4];
} else {
	$target = str_replace(" ","&nbsp;", $listElem[4]);
}

$target = preg_replace('/TG /', '', $listElem[4]);

if ($listElem[5] == "RF"){
	$source = "<span style='color: #FF0000;'>RF</span>";
} else {
	$source = "<span style='color: #4CFF00;'>$listElem[5]</span>";
}

if ($listElem[6] == null) {
	$utc_time = $listElem[0];
	$utc_tz =  new DateTimeZone('UTC');
	$now = new DateTime("now", $utc_tz);
	$dt = new DateTime($utc_time, $utc_tz);
	$duration = $now->getTimestamp() - $dt->getTimestamp();
	$duration_string = $duration<999 ? round($duration) . "+" : "&infin;";
	$duration = "<span style='color: #FF0000;'>TX " . $duration_string . " sec</span>";
} else if ($listElem[6] == "DMR Data") {
	$duration =  "<span style='color: #FF0000;'>DMR Data</span>";
} else if ($listElem[6] == "POCSAG") {
        $duration =  "<span style='color: #FF0000;'>POCSAG</span>";
} else {
  $utc_time = $listElem[0];
  $utc_tz =  new DateTimeZone('UTC');
  $now = new DateTime("now", $utc_tz);
  $dt = new DateTime($utc_time, $utc_tz);
  $duration = $listElem[6].'s (' . timeago( $dt->getTimestamp(), $now->getTimestamp() ) . ')';
}

if ($listElem[7] == null) {
	$loss = "&nbsp;&nbsp;&nbsp;";
} elseif (floatval($listElem[7]) < 1) {
    $loss = "<span>".$listElem[7]."</span>";
} elseif (floatval($listElem[7]) == 1) {
    $loss = "<span style='color: #4CFF00;'>".$listElem[7]."</span>";
} elseif (floatval($listElem[8]) > 1 && floatval($listElem[7]) <= 3) {
    $loss = "<span style='color: #FFD800;'>".$listElem[7]."</span>";
} else {
	$loss = "<span style='color: #FF0000;'>".$listElem[7]."</span>";
}

if ($listElem[8] == null) {
	$ber = "&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
	$mode = $listElem[8];
}

if ($listElem[1] == null) {
	$ber = "&nbsp;&nbsp;&nbsp;&nbsp;";
} else {
	$mode = $listElem[1];
}

if (floatval($listElem[8]) == 0) {
	$ber = $listElem[8];
} elseif (floatval($listElem[8]) >= 0.0 && floatval($listElem[8]) <= 1.9) {
	$ber = "<span style='color: #4CFF00;'>".$listElem[8]."</span>";
} elseif (floatval($listElem[8]) >= 2.0 && floatval($listElem[8]) <= 4.9) {
	$ber = "<span style='color: #FFD800;'>".$listElem[8]."</span>";
} else {
	$ber = "<span style='color: #FF0000;'>".$listElem[8]."</span>";
}

if (!is_numeric($listElem[2])) {
    $searchCall = $listElem[2];
    $callMatch = array();
    if ($mode == "NXDN") {
	$handle = @fopen("/usr/local/etc/NXDN.csv", "r");
    } else { # all other modes
	$handle = @fopen("/usr/local/etc/stripped.csv", "r");
    }
    if ($handle)
    { 
	while (!feof($handle))
	{
	    $buffer = fgets($handle);
	    if (strpos($buffer, $searchCall) !== FALSE) {
		$csvBuffer = explode(",", $buffer);
		if(strpos($searchCall, $csvBuffer[1]) !== FALSE)
		$callMatch[] = $buffer;
	    }
	}
	fclose($handle);
    }
    /* $callMatch = explode(",", $callMatch[0]);
    $name = sentence_cap(" ", "$callMatch[2] $callMatch[3]");
    $city = ucwords(strtolower($callMatch[4]));
    $state = ucwords(strtolower($callMatch[5]));
    $country = ucwords(strtolower($callMatch[6]));
    if (strlen($country) > 150) {
	$country = substr($country, 0, 120) . '...';
    } */
    if (empty($callMatch[0])) {
	$name = getName($listElem[2]);
	list ($Flag, $Name) = $Flags->GetFlag($listElem[2]);
	$country = $Name;
    }
}
 
if (file_exists("/etc/.TGNAMES")) {
    $target = tgLookup($mode, $target);
} else {
    $modeArray = array('DMR', 'NXDN', 'P25');
    if (strpos($mode, $modeArray[0]) !== false) {
	$target = "TG $target";
    } else {
	$target = $target;
    }
}

if ($listElem[2] == "4000" || $listElem[2] == "9990" || $listElem[2] == "DAPNET") {
	$name = "";
	$city = "";
	$state = "";
	$country = "";
	$loss = "";
	$ber = "";
	$duration = "";
}

list ($Flag, $Name) = $Flags->GetFlag($listElem[2]);
if (is_numeric($listElem[2]) || !preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $listElem[2])) {
    $flContent = "<img src='/live/flags/de.png' alt='' title=' />"; // Germany as default
} elseif (file_exists($_SERVER['DOCUMENT_ROOT']."/live/flags/".$Flag.".png")) {
    $flContent = "<img src='/live/flags/$Flag.png' alt='$Name' title='$Name' />";
} else {
    $flContent = "<img src='/live/flags/de.png' alt='' title='' />"; // Germany as default
}
?>
