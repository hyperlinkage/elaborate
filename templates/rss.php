<?php

    // output rss data

    header( 'Content-type: text/xml' );

    print( $rss->getRSS() );

?>