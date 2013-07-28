<?php

    class Mail {
        
        function send( $recipient, $subject, $body, $from ) {
        
            $headers = '';       
			$headers .= 'From: ' . $from . "\n";
			$headers .= "\n";

			// config bounce email address
			$bounceMail = '-f ' . $from;
            
            @ mail( $recipient, $subject, $body, $headers, $bounceMail );            
        }
    }

?>
