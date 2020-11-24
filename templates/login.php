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
