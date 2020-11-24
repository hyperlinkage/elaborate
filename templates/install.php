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
