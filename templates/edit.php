<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker
    http://elaborate.sourceforge.net/

    Contributors:
        Tim Booker <elaborate@7segment.org>

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
    print( '<h1>' . $data[ 'page' ][ 'title' ] . '</h1>' . "\n\n" );

    if( isset( $data[ 'page' ][ 'error' ] ) ) {

        print( '<p class="error">' . $data[ 'page' ][ 'error' ] . '</p>' . "\n\n" );

    } else {

        print( '<form action="' . $data[ 'site' ][ 'url' ] . '?action=edit' . ( isset( $data[ 'page' ][ 'id' ] ) ? '&amp;id=' . $data[ 'page' ][ 'id' ] : '' ) . '" method="post">' . "\n\n" );

        $form = & $data[ 'page' ][ 'form' ];
        $form->printFields();

?>

    <input type="reset" value="Undo Changes" class="button" accesskey="z" onclick="return confirm( 'Are you sure you want to undo your changes?' );" />
    <input type="submit" value="Save Changes" class="button" accesskey="s" />

</form>

<?php

    }

?>