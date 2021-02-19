<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<table>
    <thead>
    <tr>
     <td>Modified</td>
     <td>Name</td>
    </tr>
    </thead>
    
<?php 

    foreach( $data[ 'page' ][ 'content' ] as $p ) {
        print( ' <tr>' );
        print( '  <td>' . readableDate( $p[ 'modified' ] ) . '</a></td>' . "\n" );
        print( '  <td><a href="' . $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $p[ 'title' ] ) . '">' . $p[ 'title' ] . '</a></td>' . "\n" );
        print( ' </tr>' );
    }

?>

</table>
