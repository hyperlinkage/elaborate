<?php

/*
    Elaborate - A web collaboration engine written in PHP & MySQL
    Copyright (C) 2004 Tim Booker
    http://elaborate.sourceforge.net/

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
    
    $data[ 'page' ][ 'type' ] = 'register';
    $data[ 'page' ][ 'title' ] = 'Registration';
        
    $adminExists = $user->adminExists();    
        
    if( ! $adminExists || $userRegister ) {        
        $form = new Form();    
        $form->addField( 'username', 'Username', 'smalltext', true );    
        $form->addField( 'email', 'Email address', 'smalltext', true );
        $form->addField( 'password', 'Password', 'password', true );
    }
    
    if( ! $adminExists ) {
        $data[ 'page' ][ 'content' ] = 'Please enter your details here to create an administrator account.';
    } elseif( $userRegister ) {
        $data[ 'page' ][ 'content' ] = 'Please enter your details here to create an account.';
    } else {
        $data[ 'page' ][ 'content' ] = 'Registration of new accounts is disabled.';
    }
    
    if( isset( $_POST[ 'submit' ] ) && ( ! $adminExists || $userRegister ) ) {
        
        foreach( $_POST as $name => $value ) {
            $form->addValue( $name, stripslashes( $value ) );
        }
    
        // validate form data
    
        if( $form->validate() ) {     
        
            $level = ( $adminExists ? 1 : 2 );      
            $quiet = ( $adminExists ? false : true );                  
            
            $returnCode = $user->register( $form->values[ 'username' ], $form->values[ 'password' ], $form->values[ 'email' ], $level, $quiet );
            
            if( $returnCode == 0 ) {
                // registration succeeded
                                
                header( 'Location: ' . $data[ 'site' ][ 'url' ] . '?action=confirm' . ( $quiet ? '&quiet=true' : '' ) );
                exit;
                
            } else {

                // report errors on form   
                
                switch( $returnCode ) {
                    case '1' : {
                        $form->errors[ 'username' ] = 'Invalid username.  Please enter only letters and numbers.';
                        break;
                    }   
                    case '2' : {
                        $form->errors[ 'password' ] = 'Invalid password.  Please enter only letters and numbers.';
                        break;
                    }
                    case '3' : {
                        $form->errors[ 'email' ] = 'Invalid email address.';
                        break;
                    }
                    case '4' : {
                        $form->errors[ 'username' ] = 'An account with that username already exists.';
                        break;
                    }
                    case '5' : {
                        $form->errors[ 'email' ] = 'An account with that email address already exists.';
                        break;
                    }
                }
            }
        }    
    }
    
    if( isset( $form ) ) {
        $data[ 'page' ][ 'form' ] = & $form;
    }
    
?>