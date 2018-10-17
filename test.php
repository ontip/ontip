<?php
$exec = "send_email_notificaties.php?toernooi=".$toernooi."&vereniging_id=".$vereniging_id;
echo exec($exec);

}
