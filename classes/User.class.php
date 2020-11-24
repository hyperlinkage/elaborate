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

    class User {

        function User() {

            $this->usersTable = 'elaborate_users';

            $this->db = & $GLOBALS[ 'db' ];
            $this->session = & $GLOBALS[ 'session' ];

            $this->encryptPwds = true;

            $this->userLevel = 1;
            $this->adminLevel = 2;
            
            $this->id   = $this->session->getVariable( 'userid' );
            $this->name = $this->session->getVariable( 'username' );
            $this->level = ( $this->session->getVariable( 'userlevel' ) ? $this->session->getVariable( 'userlevel' ) : 0 );
        }

        function getDetails() {

            if( $this->id ) {

                $userRows = $GLOBALS[ 'db' ]->getRows( 'SELECT * FROM users WHERE id = ' . $this->id );
                $emailRows = $GLOBALS[ 'db' ]->getRows( 'SELECT `address` FROM `users_emails` WHERE `primary` = 1 AND `user_id` = ' . $this->id );

                if( count( $userRows ) > 0 ) {
                    $userRows[ 0 ][ 'email' ] = $emailRows[ 0 ][ 'address' ];
                    return $userRows[ 0 ];
                }
            }
            return false;
        }

        function adminExists() {
            // determine whether admin account exists
            
            if( $this->db->active ) {
                $admin = $this->getAdminDetails();
                if( count( $admin ) > 0 ) {
                    return true;
                }
            }
            return false;
        }

        function getAdminDetails() {            
            // return details of the admin user, if any
            
            $userRows = $this->db->getRows( 'SELECT * FROM ' . $this->usersTable . ' WHERE `level` = ' . $this->adminLevel . ' LIMIT 0,1' );

            if( count( $userRows ) > 0 ) {
                return $userRows[ 0 ];
            }
            return array();
        }

        function autoLogIn() {

            if( isset( $_COOKIE[ 'user' ] ) ) {
                $storedInfo = explode( ':', $_COOKIE[ 'user' ] );
                return $this->logIn( $storedInfo[ 0 ], $storedInfo[ 1 ], true, true );
            }
            return false;
        }

        function logIn( $username, $password, $remember = false, $auto = false ) {

            $encpwd = ( $this->encryptPwds && ! $auto ? md5( $password ) : $password );
            $query = $this->db->getRows( 'SELECT * FROM ' . $this->usersTable . ' WHERE username = "' . $username . '" AND password = "' . $encpwd . '"' );

            foreach( $query as $profileRow ) {

                // register user in globals
                $this->id    = $profileRow[ 'id' ];
                $this->name  = $profileRow[ 'username' ];
                $this->level = $profileRow[ 'level' ];

                // set user on session
                $this->session->setVariable( 'userid', $this->id );
                $this->session->setVariable( 'username', $this->name );
                $this->session->setVariable( 'userlevel', $this->level );

                // store log in details in cookie
                if( $remember ) {
                    // permanent cookie
                    $storedInfo = $username . ':' . $encpwd;
                    $expiry = time() + 15768000;
                    setcookie( 'user', $storedInfo, $expiry, '/', '' );
                } else {
                    // unset cookie
                    setcookie( 'user', '', 100, '/', '' );
                }

                // update last visit date
                $this->db->updateRows( 'UPDATE ' . $this->usersTable . ' SET lastvisited = ' . time() . ', modified = ' . time() . ' WHERE id = "' . $profileRow[ 'id' ] . '"' );

                return true;
            }
            return false;
        }

        function logOut() {

            $this->id = null;
            $this->name = null;
            $this->country = null;

            $this->session->unsetVariable( 'userid' );
            $this->session->unsetVariable( 'username' );
            $this->session->unsetVariable( 'country' );

            setcookie( 'user', '', 100, '/', '' );
        }

        function register( $username, $password, $email, $level = 1, $quiet = false ) {
            /* 
                Return codes for this function
                    0 - success
                    1 - invalid username
                    2 - invalid password
                    3 - invalid email
                    4 - user exists
                    5 - email exists
            */

            if( ! $username || preg_match( '/[^a-zA-Z0-9-_\.]/', $username ) ) {
                return 1;
            }
            if( ! $password || preg_match( '/[^a-zA-Z0-9]/', $password ) ) {
                return 2;
            }
            if( ! $email || preg_match( '/[^a-zA-Z0-9\.@_-]/', $email ) ) {
                return 3;
            }
            
            $existingUsers = $GLOBALS[ 'db' ]->getRows( 'SELECT * FROM ' . $this->usersTable . ' WHERE username LIKE "' . $username . '" OR email LIKE "' . $email . '"' );

            if( count( $existingUsers ) > 0 ) {

                foreach( $existingUsers as $u ) {
                    if( $u[ 'username' ] == $username ) {
                        return 4;
                    } elseif( $u[ 'email' ] == $email ) {
                        return 5;
                    }
                }
            }

            $encpwd = ( $this->encryptPwds ? md5( $password ) : $password );

            $confirmation = md5( time() + rand() );
            
            $userRow = array(
                'created'      => time(),
                'modified'      => time(),
                'lastvisited'  => time(),
                'username'     => $username,
                'email'        => $email,
                'password'     => $encpwd,
                'level'        => $level,
                'confirmation' => ( $quiet ? 'confirmed' : $confirmation )
            );

            $id = $GLOBALS[ 'db' ]->insertAssoc( $this->usersTable, $userRow );
            
            $mailBody =
                'You have created a user account on the ' . $GLOBALS[ 'data' ][ 'site' ][ 'title' ] . ' wiki located at:' . "\n" .
                $GLOBALS[ 'data' ][ 'site' ][ 'url' ] . "\n" .
                '' . "\n";

            if( ! $quiet ) {
                $mailBody .=
                    'To confirm your email address and complete registration of your' . "\n" .
                    'account, please visit the following address:' . "\n" .
                    $GLOBALS[ 'data' ][ 'site' ][ 'url' ] . '?action=confirm&id=' . $id . '&code=' . $confirmation . "\n" .
                    '' . "\n";
            }
            
            $mailBody .=
                'Please keep a record of the following log-in details:' . "\n" .
                'Username: ' . $username . "\n" .
                'Password: ' . $password;
        
            $admin = $this->getAdminDetails();
            $from = ( isset( $admin[ 'username' ] ) ? $admin[ 'username' ] : $username ) . '<' . ( isset( $admin[ 'email' ] ) ? $admin[ 'email' ] : $email ) . '>';
            
            $subject = ( $quiet ? 'Your account details' : 'Confirm your account' );
            
            $mail = new Mail();
            $mail->send( $email, $subject, $mailBody, $from );

            return 0;
        }

        function confirmEmail( $id, $code ) {
            /* 
                Return codes for this function
                    0 - success
                    1 - already confirmed
                    2 - invalid confirmation code
            */

            $confirmed = $this->db->getRows( 'SELECT * FROM `' . $this->usersTable . '` WHERE id = "' . $id . '" AND confirmation = "confirmed"' );

            if( count( $confirmed ) > 0 ) {
                return 1;
            }

            $tobeconfirmed = $this->db->getRows( 'SELECT * FROM `' . $this->usersTable . '` WHERE id = "' . $id . '" AND confirmation = "' . $code . '"' );

            if( count( $tobeconfirmed ) > 0 ) {
                $this->db->updateRows( 'UPDATE `' . $this->usersTable . '` SET confirmation = "confirmed", modified = ' . time() . ' WHERE id = "' . $id . '"' );
                return 0;
            }
            return 2;
        }
    }

?>