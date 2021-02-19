<h1><?php print( $data[ 'page' ][ 'title' ] ); ?></h1>

<?php print( $data[ 'page' ][ 'content' ] ); ?>

<?php 
    
    if( isset( $data[ 'page' ][ 'alt' ] ) ) {        
        print '<p><a href="?page=' . urlencode( $data[ 'page' ][ 'alt' ] ) . '">' . $data[ 'page' ][ 'alt' ] . '</a></p>' . "\n\n";
    }

    if( isset( $data[ 'page' ][ 'modified' ] ) ) {
        print '<p class="date">Page updated ' . readableDate( $data[ 'page' ][ 'modified' ] ) . '</p>' . "\n\n"; 
    }


	if($data[ 'page' ][ 'incoming' ]) {
		print "<div class=\"incoming\">";
		print "<p>Incoming Links: ";
		foreach( $data[ 'page' ][ 'incoming' ] as $key =>  $lnk ) {
			if($key != 0)
			{
				print "&bull;&nbsp;";
			}
			print "<a href=\"?page=" . $lnk['title'] . "\">" . $lnk['title'] . "</a> ";
		}
		print "</div>";
	}

?>