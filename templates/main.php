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

    include( 'templates/functions.php' );

    if( $data[ 'page' ][ 'type' ] == 'rss' ) {

        // output xml data for an rss feed
        include( 'templates/rss.php' );

    } else {

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xml:lang="en-gb" lang="en-gb"
    xmlns="http://www.w3.org/1999/xhtml">

<head>

    <title><?php print( $data[ 'site' ][ 'title' ] . ' : ' . $data[ 'page' ][ 'title' ] ); ?></title>

    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />

    <link href="<?php print( $data[ 'site' ][ 'url' ] ); ?>res/css/print.css" type="text/css" rel="stylesheet" media="print" />
    <link href="<?php print( $data[ 'site' ][ 'url' ] ); ?>res/css/default.css" type="text/css" rel="stylesheet" media="screen" />

</head>

<body>

<div id="container">

<?php

    if( $data[ 'page' ][ 'type' ] != 'install' ) {

?>

    <div id="header">

        <div class="logo"><?php print( $data[ 'site' ][ 'title' ] ); ?></div>
    
        <div class="search">

            <form id="frmSearch" action="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=search" method="post">
                <div><label title="Find a page by entering a word or phrase">Search <input type="text" name="qry" class="text" value="<?php print( isset( $data[ 'page' ][ 'query' ] ) ? $data[ 'page' ][ 'query' ] : '' ); ?>" /></label><input type="submit" class="button" value="Go" /></div>
            </form>

        </div>

        <div class="nav">

            <ul>
                <li><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>" title="Go to home page">Home Page</a></li>
                <li><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=all" title="View the full index of pages">Page Index</a></li>
                <li><a href="<?php print( $data[ 'site' ][ 'url' ] ); ?>?action=rssfeeds" title="View available RSS feeds for this site">RSS Feeds</a></li>
            </ul>

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