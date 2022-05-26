<?php
date_default_timezone_set("Asia/Kolkata");
$CurrentTime=time();
$DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
echo $DateTime;
?>
