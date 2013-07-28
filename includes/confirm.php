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
    
    $data[ 'page' ][ 'type' ] = 'confirm';
    $data[ 'page' ][ 'title' ] = 'Registration';

    $data[ 'page' ][ 'content' ] = 'To complete your registration, your email address must be confirmed.  Please check your email for instructions.';    

    if( isset( $params[ 'quiet' ] ) ) {    
    
        $data[ 'page' ][ 'content' ] = 'Registraton successful!';    
    
    } else {

		$id   = ( isset( $_GET[ 'id' ] ) ? $_GET[ 'id' ] : '' );
		$code = ( isset( $_GET[ 'code' ] ) ? $_GET[ 'code' ] : '' );

        if( $id && $code ) {
    
            $returnCode = $user->confirmEmail( $id, $code );
            
            switch( $returnCode ) {
                case '0' : { 
                    $data[ 'page' ][ 'content' ] = 'Your email address has been confirmed.  Thanks for registering.';    
                    break;
                }
                case '1' : {
                    $data[ 'page' ][ 'content' ] = '<p class="error">Your email address has already been confirmed.</p>';    
                    break;
                }
                case '2' : {
                    $data[ 'page' ][ 'content' ] = '<p class="error">Unknown confirmation code.</p>';        
                    break;
                }
            }
        }
    }


?>