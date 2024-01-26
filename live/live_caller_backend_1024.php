<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/live/core.php'; // Core Config
?>
<table width="100%" height="100%">
<tbody>
	<tr height="7%">
		<td align="left" class="frame1" colspan="2" width="75%" valign="middle">
			<span style="color: #ffffff; font-size: 25px;">My DMR ID: <span style="color: #ff0000;"><?php echo getConfigItem("General", "Id", $mmdvmconfigs); ?></span></span>
		</td>
		<td align="center" class="frame1" colspan="2" width="25%" valign="middle">
			<span style="color: #ffffff; font-size: 25px;">FreeDMR Digital</span>
		</td>
	</tr>
	<tr height="76%">
		<td colspan="2" width="100%">
			<table width="100%" height="100%">
			<tbody>
				<tr height="7%">
                                        <td align="left" width="85%" valign="middle">
                                                Master Server: <span style="color: #FDFA0E;"><?php echo getConfigItem("DMR Network", "Address", $mmdvmconfigs); ?></span>
                                        </td>
					<td align="center" class="frame1" width="15%" valign="middle">
						<a href="index_1024.php?page=history" style="color: #ffffff; text-decoration: none;">HISTORY</a>
					</td>
				</tr>
<?php
	if ($_GET["page"] == "history") {
?>
				<tr height="93%">
					<td colspan="2" width="100%" valign="top">
						<table width="100%" height="100%">
						<tbody>
							<tr>
								<td align="left" class="frame1" width="15%" valign="middle">Time</td>
								<td align="left" class="frame1" width="15%" valign="middle">Mode</td>
								<td align="left" class="frame1" width="40%" valign="middle">Callsign</td>
								<td align="left" class="frame1" width="17%" valign="middle">Target</td>
								<td align="left" class="frame1" width="13%" valign="middle">Source</td>
							</tr>
<?php
    include_once $_SERVER['DOCUMENT_ROOT'].'/config/ircddblocal.php';

$i = 0;
for ($i = 0;  ($i <= 9); $i++) { // Last 10 calls
	if (isset($lastHeard[$i])) {
		$listElem = $lastHeard[$i];
		if ($listElem[2]) {
			$utc_time = $listElem[0];
			$utc_tz =  new DateTimeZone('UTC');
			$local_tz = new DateTimeZone(date_default_timezone_get ());
			$dt = new DateTime($utc_time, $utc_tz);
			$dt->setTimeZone($local_tz);
			$time = $dt->format('H:i:s');
			echo "<tr>";
			echo "<td align=\"left\">$time</td>";
			echo "<td align=\"left\">".str_replace('Slot ', 'TS', $listElem[1])."</td>";
			echo "<td align=\"left\">$listElem[2]</td>";
			if (strlen($listElem[4]) == 1) { $listElem[4] = str_pad($listElem[4], 8, " ", STR_PAD_LEFT); }
			if (substr($listElem[4], 0, 6) === 'CQCQCQ')
				echo "<td align=\"left\">$listElem[4]</td>";
			else
				echo "<td align=\"left\">".str_replace(" ","&nbsp;", $listElem[4])."</td>";
			if ($listElem[5] == "RF")
				echo "<td align=\"left\" style=\"color: #ff0000;\">RF</td>";
			else
				echo "<td align=\"left\">$listElem[5]</td>";
			echo "</tr>\n";
		}
	}
}
?>
						</table>
						</tbody>
					</td>
				</tr>
<?php
	} else {
?>
				<tr height="93%">
					<td colspan="2" width="100%" valign="top">
						<p>
							<span style="color: #FDFA0E; font-size: 75px; text-decoration: underline; overflow-wrap: anywhere;"><?php echo "$listElem[2]"; ?></span></br>
							TX Duration: <?php echo $duration ?>
						</p>
						<span style="font-size: 40px;"><?php echo getInfoFromFile ($listElem[2]); ?></span>
					</td>
				</tr>
<?php
	}
?>
			</tbody>
			</table>
		</td>
		<td colspan="2" width="25%" valign="top">
			<table width="100%" height="100%">
			<tbody>
				<tr height="10%">
					<td align="center" class="frame1" width="50%" valign="middle">
						Hostname</br>
						<?php echo exec('cat /etc/hostname'); ?>
					</td>
					<td align="center" class="frame1" width="50%" valign="middle">
						Time</br>
						<?php echo $local_time; ?>
					</td>
				</tr>
				<tr height="10%">
					<td align="center" class="frame1" width="50%" valign="middle">
						Temperature</br>
						<?php echo $cpuTempHTML; ?>
					</td>
					<td align="center" class="frame1" width="50%" valign="middle">
						Version</br>
						<span style="color: #FDFA0E;">1.0.5</span>
					</td>
				</tr>
				<tr height="40%">
					<td align="center" class="frame1" colspan="2" width="100%" valign="middle">
						<?php echo $flContent; ?>
					</td>
				</tr>
				<tr height="10%">
					<td align="center" class="frame1" colspan="2" width="100%" valign="middle">
						Transceiver</br>
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
					</td>
				</tr>
				<tr height="10%">
					<td align="center" class="frame1" colspan="2" width="100%" valign="middle">
						Source</br>
						<?php echo $source; ?>
					</td>
				</tr>
				<tr height="10%">
					<td align="center" class="frame1" width="50%" valign="middle">
						Mode</br>
						<?php echo $mode; ?>
					</td>
					<td align="center" class="frame1" width="50%" valign="middle">
						Target</br>
						<?php echo $target; ?>
					</td>
				</tr>
				<tr height="10%">
					<td align="center" class="frame1" width="50%" valign="middle">
						Packet Loss</br>
						<?php echo $loss ?>
					</td>
					<td align="center" class="frame1" width="50%" valign="middle">
						Bit Error Rate</br>
						<?php echo $ber ?>
					</td>
				</tr>
			</tbody>
			</table>
		</td>
	</tr>
	<tr height="7%">
		<td align="center" class="frame1" width="37%" valign="middle">
			RX: <span style="color: #29F2F3;"><?php echo getMHZ(getConfigItem("Info", "TXFrequency", $mmdvmconfigs)); ?></span>
		</td>
		<td align="center" class="frame1" width="37%" valign="middle">
			TX: <span style="color: #29F2F3;"><?php echo getMHZ(getConfigItem("Info", "RXFrequency", $mmdvmconfigs)); ?></span>
		</td>
		<td align="center" class="frame1" width="25%" valign="middle">
			created by <span style="color: #FDFA0E;">13MAD86</span>
		</td>
	</tr>
</tbody>
</table>

