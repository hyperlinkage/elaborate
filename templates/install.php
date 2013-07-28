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

?>

<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<p><?php print( $data[ 'page' ][ 'content' ] ); ?></p>

<?php
    if( isset( $data[ 'page' ][ 'confirm' ] ) ) {
?>

<form action="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=install" method="post">
    <input name="submit" type="submit" class="button" value="Continue" />
</form>

<?php
    }
?>

<p><strong>Elaborate</strong><br />Version <?php print( $version ); ?><br />&copy; 2004 Tim Booker</p>

<p>Elaborate comes with ABSOLUTELY NO WARRANTY.  This is free software, and you are
welcome to redistribute it under certain conditions.  See the <a href="licence.txt">GNU
General Public License</a> for more details.</p>
