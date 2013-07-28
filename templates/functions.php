<?php

    function readableDate( $timestamp ) {

        $diff = time() - $timestamp;

        if( $diff < 60 * 60 ) {
            $period = floor( $diff / 60 );
            $unit = 'minute';
            if( $period < 1 ) {
                // never show a time of 0 minutes
                $period = 1;
            }
        } elseif( $diff < 60 * 60 * 24 ) {
            $period = floor( $diff / ( 60 * 60 ) );
            $unit = 'hour';
        } elseif( $diff < 60 * 60 * 24 * 14 ) { // show "days" if time is within two weeks
            $period = floor( $diff / ( 60 * 60 * 24 ) );
            $unit = 'day';
        } else {
            $period = floor( $diff / ( 60 * 60 * 24 * 7 ) );
            $unit = 'week';
        }

        $textdate = $period . ' ' . $unit . ( $period != 1 ? 's' : '' ) . ' ago';
        return $textdate;
    }
    
?>