<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/live/core.php'; // Core Config
?>
<div class='live-page-wrapper'>
  <div class='row'>
    <div class='column'>
      <div class='orange-column'>
        <span class='oc_call'><?php echo "$listElem[2]"; ?></span>
      </div>
    </div>
    <div class='column'>
      <div class='orange-column'>
        <span style="position: relative; top: 2vw; transform: translateY(-50%);"><?php echo $flContent; ?></span>
      </div>
    </div>
    <div class='column'>
      <div class='orange-column'>
        <span class='oc_caller'>
            <?php echo getInfoFromFile ($listElem[2]); ?>
        </span>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='column'>
      <div class='dark-column'>
	<span class='dc_info'>
	  Source: 
	  <span class='dc_info_def'>
	    <?php echo $source; ?>
	  </span>
	  <br />
	  Mode: 
	  <span class='dc_info_def'>
	    <?php echo $mode; ?>
	  </span>
	  <br />
	  Target: 
	  <span class='dc_info_def'>
	    <?php echo $target; ?>
	  </span>
	</span>
      </div>
    </div>
    <div class='column'>
      <div class='dark-column'>
	<span class='dc_info'>
	  TX Duration: 
	  <span class='dc_info_def'>
	    <?php echo $duration ?>
	  </span>
	  <br />
          Packet Loss: 
	  <span class='dc_info_def'>
	    <?php echo $loss ?>
	  </span>
	  <br />
          Bit Error Rate: 
	  <span class='dc_info_def'>
	    <?php echo $ber ?>
	  </span>
	  <span class="last-caller" style="display:none;"><br />Last Caller ID: <span class='dc_info_def'></span></span>
	</span>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='column'>
      <div class='footer-column'>
        <span class='foot_left'>
	  <a href="/">Main Dashboard</a>
	</span>
        <span class='foot_right'>
          Hotspot Time:
          <span class='hw_info_def'>
            <?php echo $local_time; ?>
          </span>
	</span>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='column'>
      <div class='footer-column'>
        <span class='foot_left'>
          Hostname: <?php echo exec('cat /etc/hostname'); ?>
        </span>
        <span class='foot_right'>
          <div class='hw_info'>
             CPU Temp:
             <span class='hw_info_def'>
                <?php echo $cpuTempHTML; ?>
             </span>
          </div>
	</span>
      </div>
    </div>
  </div>
</div>

<!-- <script>
  if(typeof localStorage.getItem('last_caller') !== 'undefined' ) {
    jQuery('.last-caller').show().find('span').html(localStorage.getItem('last_caller'));
  }
</script> -->
