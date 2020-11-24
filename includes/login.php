<?php

/*
	Elaborate - A web collaboration engine written in PHP & MySQL
	Copyright (C) 2004-2020 Tim Booker        
	https://github.com/hyperlinkage/elaborate

	Contributors: 
		Tim Booker <timbooker@hyperlinkage.com>

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

    // prompt for log-in

    $data[ 'page' ][ 'type' ] = 'login';
    $data[ 'page' ][ 'title' ] = 'Log-in';

    if( $accessRequired == 2 ) {
        $data[ 'page' ][ 'content' ] = 'This page is only available to the site administrator.  Please log-in.';
    } else {
    
        $data[ 'page' ][ 'content' ] = 'This page is only available to registered users.  Please log-in' . ( $userRegister ? ' or <a href="' . $data[ 'site' ][ 'url' ] . '?action=register">register an account</a>' : '' ) . '.';
    
    }

    // define form structure
    $form = new Form();    
    $form->addField( 'username', 'Username', 'smalltext', true );    
    $form->addField( 'password', 'Password', 'password', true );    
    $form->addField( 'remember', 'Automatically log-in each time I visit', 'checkbox' );    

    if( isset( $_POST[ 'password' ] ) ) {

        foreach( $_POST as $name => $value ) {
            $form->addValue( $name, stripslashes( $value ) );
        }

        if( $form->validate() ) {

            if( $user->logIn( $form->getValue( 'username' ), $form->getValue( 'password' ), $form->getValue( 'remember' ) ) ) {
            
                // successfully logged in, redirect to destination page            
                $destination = ( $session->getVariable( 'destination' ) ? $session->getVariable( 'destination' ) : $GLOBALS[ 'url' ] );
                $session->unsetVariable( 'destination' );
    
                header( 'Location: ' . $destination );
                exit;
                
            } else {
                // log in failed
                $form->errors[ 'username' ] = 'Incorrect username/password combination';
            }
        }
    }
        
    $data[ 'page' ][ 'form' ] = & $form;

?>