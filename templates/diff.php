<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker        
    http://elaborate.sourceforge.net/

    Contributors: 
        Tim Booker <tim@hyperlinkage.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

*/

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