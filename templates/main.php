<?php

    include( 'templates/functions.php' );

    if( $data[ 'page' ][ 'type' ] == 'rss' ) {

        // output xml data for an rss feed
        include( 'templates/rss.php' );

    } else {

?><!DOCTYPE html>
<html>

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php print( $data[ 'page' ][ 'title' ] . ' - ' . $data[ 'site' ][ 'title' ] ); ?></title>

    <link href="<?php print( $data[ 'site' ][ 'url' ] ); ?>res/css/print.css" type="text/css" rel="stylesheet" media="print" />
    <link href="<?php print( $data[ 'site' ][ 'url' ] ); ?>res/css/default.css" type="text/css" rel="stylesheet" media="screen" />
    <link href="<?php print( $data[ 'site' ][ 'url' ] ); ?>res/css/dark.css" type="text/css" rel="stylesheet" media="screen" />

</head>

<body>

<div id="container">

<?php

    if( $data[ 'page' ][ 'type' ] != 'install' ) {

?>

    <div id="header">

        <div class="logo"><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>" title="Go to home page"><?php print( $data[ 'site' ][ 'title' ] ); ?></a></div>
    
        <div class="nav">
			<a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=tools">Wiki Tools</a>
        </div>
		
        <div class="search">

            <form id="frmSearch" action="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=search" method="post">
                <div><label title="Find a page by entering a word or phrase">Search <input type="text" name="qry" class="text" value="<?php print( isset( $data[ 'page' ][ 'query' ] ) ? $data[ 'page' ][ 'query' ] : '' ); ?>" /></label><input type="submit" class="button" value="Go" /></div>
            </form>

        </div>
    </div>

<?php

    }

?>

    <div id="tabs">

<?php
    if( $data[ 'page' ][ 'type' ] == 'view' ) {
?>


        <ul>
            <li><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=edit&amp;id=<?php print( $data[ 'page' ][ 'id' ] ); ?>" title="Edit this page">Edit This Page</a></li>
            <li><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=changes&amp;page=<?php print( $data[ 'page' ][ 'id' ] ); ?>" title="View a list of changes to this page">Page History</a></li>
        </ul>


<?php
        }
?>

    </div>

    <div id="page">

<?php

    switch( $data[ 'page' ][ 'type' ] ) {
        case 'install' : {
            include( 'templates/install.php' );
            break;
        }
        case 'about' : {
            include( 'templates/about.php' );
            break;
        }
        case 'edit' : {
            include( 'templates/edit.php' );
            break;
        }
        case 'all' : {
            include( 'templates/all.php' );
            break;
        }
        case 'tools' : {
            include( 'templates/tools.php' );
            break;
        }
        case 'changes' : {
            include( 'templates/changes.php' );
            break;
        }
        case 'search' : {
            include( 'templates/search.php' );
            break;
        }
        case 'diff' : {
            include( 'templates/diff.php' );
            break;
        }
        case 'rssfeeds' : {
            // output a list of available rss feeds
            include( 'templates/rssfeeds.php' );
            break;
        }
        case 'login' : {
            include( 'templates/login.php' );
            break;
        }
        case 'register' : {
            include( 'templates/register.php' );
            break;
        }
        default : {
            include( 'templates/view.php' );
            break;
        }
    }

?>

    </div>

<?php

    if( $data[ 'page' ][ 'type' ] != 'install' ) {
        print( '<div id="footer">' );
        print( '<p>Powered by <a href="' . $data[ 'site' ][ 'url' ] . '?action=about">Elaborate</a></p>' );
        print( '</div>' );
    }

?>

</div>

</body>

</html>

<?php

    }

?>