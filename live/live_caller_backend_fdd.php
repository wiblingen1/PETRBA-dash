<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/live/core.php'; // Core Config
?>

  <div class="w3-row">
    <div class="w3-col m3">
      <div class="w3-card w3-round w3-center w3-margin w3-hide-small" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container">
         <div class="w3-center">
           <h1>FREEDMR DIGITAL<h1>
           <img class="w3-image" src="banner_fdd.png">
         </div>
        </div>
      </div>
      <div class="w3-card w3-round w3-margin w3-hide-small" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container">
         <div class="w3-center"><h1>TRANSCEIVER</br>
<?php // TRX Status code
if (isset($lastHeard[0])) {
	$listElem = $lastHeard[0];
	if ( $listElem[2] && $listElem[6] == null && $listElem[5] !== 'RF')
	        echo "TX $listElem[1]";
	else {
	        if (getActualMode($lastHeard, $mmdvmconfigs) === 'idle') {
	                echo "Listening";
	        } elseif (getActualMode($lastHeard, $mmdvmconfigs) === NULL) {
	                if (isProcessRunning("MMDVMHost")) { echo "Listening"; } else { echo "OFFLINE"; }
	        } elseif ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $mmdvmconfigs) === 'D-Star') {
	                echo "RX D-Star";
	        } elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'D-Star') {
	                echo "Listening D-Star";
	        } elseif ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $mmdvmconfigs) === 'DMR') {
	                echo "RX DMR";
	        } elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'DMR') {
	                echo "Listening DMR";
	        } elseif ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $mmdvmconfigs) === 'YSF') {
	                echo "RX YSF";
	        } elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'YSF') {
	                echo "Listening YSF";
	        } elseif ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $mmdvmconfigs) === 'P25') {
        	        echo "RX P25";
        	} elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'P25') {
        	        echo "Listening P25";
		} elseif ($listElem[2] && $listElem[6] == null && getActualMode($lastHeard, $mmdvmconfigs) === 'NXDN') {
        	        echo "RX NXDN";
		} elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'NXDN') {
        	        echo "Listening NXDN";
		} elseif (getActualMode($lastHeard, $mmdvmconfigs) === 'POCSAG') {
        	        echo "POCSAG";
		} else
        	        echo getActualMode($lastHeard, $mmdvmconfigs);
	}
}
?>
         </h1></div>
        </div>
      </div>
    </div>
    <div class="w3-col m6">
      <div class="w3-card w3-round w3-center w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-center"><h1>CALLSIGN<h1></div>
        <div class="w3-center w3-text-yellow w3-hide-small" style="font-size: 8em;"><h0><?php echo "$listElem[2]"; ?></h0></div>
        <div class="w3-center w3-text-yellow w3-hide-large w3-jumbo"><h0><?php echo "$listElem[2]"; ?></h0></div>
        <div class="w3-container">
          <div class="w3-center"><h1>
            <?php echo getInfoFromFile ($listElem[2]); ?>
          </h1></div>
        </div>
      </div>
    </div>
    <div class="w3-col m3">
      <div class="w3-card w3-round w3-center w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container">
          <div class="w3-center"><h1>COUNTRY<h1></div>
        <div class="w3-container">
          <div class="w3-center"><h1>
            <?php echo $flContent; ?>
          </h1></div>
        </div>
        </div>
      </div>
      <div class="w3-card w3-round w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container">
         <div class="w3-center"><h1>FREQUENCY</br>
          TX: <?php echo getMHZ(getConfigItem("Info", "TXFrequency", $mmdvmconfigs)); ?></br>
          RX: <?php echo getMHZ(getConfigItem("Info", "RXFrequency", $mmdvmconfigs)); ?>
         <h1></div>
      </div>
    </div>
  </div>
  <div class="w3-row">
    <div class="w3-col m6">
      <div class="w3-card w3-round w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container"><h1>
          Source: <?php echo $source; ?></br>
          Mode: <?php echo $mode; ?></br>
          Target: <?php echo $target; ?>
        <h1></div>
      </div>
    </div>
    <div class="w3-col m6">
      <div class="w3-card w3-round w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <div class="w3-container"><h1>
          TX Duration: <?php echo $duration ?></br>
          Packet Loss: <?php echo $loss ?></br>
          Bit Error Rate: <?php echo $ber ?>
        <h1></div>
      </div>
    </div>
  </div>
  <div class="w3-row">
    <div class="w3-col m3">
      <div class="w3-card w3-round w3-center w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <h1>HOSTNAME</br><?php echo exec('cat /etc/hostname'); ?></h1>
      </div>
    </div>
    <div class="w3-col m6">
      <div class="w3-card w3-round w3-center w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <h1>CURRENT TIME</br><?php echo $local_time; ?></h1>
      </div>
    </div>
    <div class="w3-col m3">
      <div class="w3-card w3-round w3-center w3-margin" style="color:#<?php echo $piStarCssContent; ?>; background-color:#<?php echo $piStarCssBanner; ?>">
        <h1>CPU TEMPERATURE</br><?php echo $cpuTempHTML; ?></h1>
      </div>
    </div>
  </div>
