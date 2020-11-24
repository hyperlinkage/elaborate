<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<p><?php print( $data[ 'page' ][ 'content' ] ); ?></p>


<?php

    if( isset( $data[ 'page' ][ 'form' ] ) ) {
    
        $form = & $data[ 'page' ][ 'form' ];

        print( '<form action="' . $data[ 'site' ][ 'url' ] . '?action=register" method="post">' );        
        $form->printFields();
        print( '    <input name="submit" type="submit" class="button" value="Register" />' );
        print( '</form>' );
    }

?>


