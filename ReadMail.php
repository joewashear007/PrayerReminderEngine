<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

print_r($imap = imap_open("{host155.hostmonster.com:993}", "prayer+joesboxoftricks.com", "prayer4ME"));

if( $imap ) {
   
     //Check no.of.msgs
     $num = imap_num_msg($imap);

     //if there is a message in your inbox
     if( $num >0 ) {
          //read that mail recently arrived
          echo imap_qprint(imap_body($imap, $num));
     }

     //close the stream
     imap_close($imap);
}
?>