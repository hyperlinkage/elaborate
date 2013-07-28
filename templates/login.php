<?php
    
/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker        
    https://github.com/hyperlinkage/elaborate

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

?>

<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<?php

    if( isset( $data[ 'page' ][ 'content' ] ) ) {    
        print '<p>' . $data[ 'page' ][ 'content' ] . '</p>';
    }
    
?>

<form action="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=login" method="post">
    
<?php
    
    $form = & $data[ 'page' ][ 'form' ];
    $form->printFields();

?>
    <div><input type="submit" value="Log-in" class="button" accesskey="s" /></div>

</form>
