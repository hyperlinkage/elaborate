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

    // edit contents of a page

    $data[ 'page' ][ 'type' ] = 'edit';

    // define form structure
    $form = new Form();    
    $form->addField( 'id', '', 'hidden', false );
    $form->addField( 'title', 'Title', 'smalltext', true );
    $form->addField( 'content', 'Content', 'html', true );
        
    // if a page id is set, get the details from the db
    if( isset( $params[ 'id' ] ) ) {
    
        $form->addValue( 'id', intval( $params[ 'id' ] ) );
    
        if( isset( $params[ 'rev' ] ) ) {      
        
            // open previous revision of this page        
            $revision = intval( $params[ 'rev' ] );    
            $page = $wiki->getRevision( $revision );
            
        } else {            
            
            // open current version of page    
            $page = $wiki->getPageById( $form->values[ 'id' ] );                        
        }

        foreach( $page as $name => $value ) {
            $form->addValue( $name, $value );
        }
    }
    
    // process posted data, creating or updating page if needed
    
    if( isset( $_POST[ 'id' ] ) ) {

        foreach( $_POST as $name => $value ) {
            $form->addValue( $name, stripslashes( $value ) );
        }
        
        // validate form data
        if( $form->validate() ) {    
    
            $pageId      = $_POST[ 'id' ];
            $pageTitle   = $wiki->cleanName( $_POST[ 'title' ] );
            $pageContent = $_POST[ 'content' ];
                    
            if( $pageId ) {
    
                // update existing page
                if( $wiki->updatePage( $pageId, $pageTitle, $pageContent ) ) {
                    header( 'Location: ' . $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $pageTitle ) );
                    exit;
                } else {
                    $form->errors[ 'title' ] = 'A page with that name already exists';
                }
    
            } else {

                // create new page
                if( $wiki->createPage( $pageTitle, $pageContent ) ) {
                    header( 'Location: ' . $data[ 'site' ][ 'url' ] . '?page=' . urlencode( $pageTitle ) );
                    exit;
                } else {
                    $form->errors[ 'title' ] = 'A page with that name already exists';
                }    
            }        
        }
    } // end processing post data

    if( isset( $form->values[ 'id' ] ) && ! empty( $form->values[ 'id' ] ) ) {
    
        $data[ 'page' ][ 'title' ] = 'Editing ' . $form->values[ 'title' ];
        $data[ 'page' ][ 'id' ] = $form->values[ 'id' ];
        
        if( ! $wiki->lockPage( $form->values[ 'id' ] ) ) {
            $data[ 'page' ][ 'error' ] = 'This page is locked for editing by another user.  Please try again later.';        
        }    
        
    } else {    
        $data[ 'page' ][ 'title' ] = 'Create a New Page';    
        
        if( isset( $params[ 'create' ] ) ) {
            $form->addValue( 'title', stripslashes( $params[ 'create' ] ) );
        }
    }

    $data[ 'page' ][ 'form' ] = & $form;

?>