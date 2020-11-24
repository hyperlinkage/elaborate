<?php

    $leftLines = $data[ 'page' ][ 'differences' ][ 'left' ];
    $rightLines = $data[ 'page' ][ 'differences' ][ 'right' ];

    print '<h1>' . $data[ 'page' ][ 'title' ] . '</h1>' . "\n\n";

    print '<table border="0" cellpadding="0" cellspacing="1" class="diff">' . "\n\n";
    print '<thead>' . "\n";
    print ' <tr>' . "\n";
    print '  <td>Previous version&nbsp;</td>' . "\n";
    print '  <td>Version created ' . readableDate( $data[ 'page' ][ 'left' ][ 'date' ] ) . '</td>' . "\n";
    print ' </tr>' . "\n";
    print '</thead>' . "\n\n";

    foreach( $leftLines as $idx => $l ) {

        $r = $rightLines[ $idx ];

        print '<tr>' . "\n";
        print '<td class="' . $l[ 'status' ] . '">' . nl2br( htmlspecialchars( trim( chunk_split( $l[ 'text' ], 46 ) ) ) ) . '&nbsp;</td>' . "\n";
        print '<td class="' . $r[ 'status' ] . '">' . nl2br( htmlspecialchars( trim( chunk_split( $r[ 'text' ], 46 ) ) ) ) . '&nbsp;</td>' . "\n";
        print '</tr>' . "\n\n";
    }
    print '</table>' . "\n";

?>