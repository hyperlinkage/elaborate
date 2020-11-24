<?php

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