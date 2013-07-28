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

    // class to handle form structure and validation

    class Form {

        function Form() {

            $this->fields = array();
            $this->values = array();
            $this->errors = array();
        }

        function addField( $name, $label, $type = 'smalltext', $required = false, $default = null ) {

            $this->fields[ $name ] = array(
                'label' => $label,
                'type' => $type,
                'required' => $required
            );

            if( $default ) {
                $this->addValue( $name, $default );
            }
        }

        function addValue( $field, $value ) {
            if( isset( $this->fields[ $field ] ) ) {
                $this->values[ $field ] = $value;
            }
        }

        function getValue( $field ) {

            if( isset( $this->values[ $field ] ) ) {
                return $this->values[ $field ];
            } else {
                return '';
            }
        }

        function validate() {

            $this->errors = array();

            foreach( $this->fields as $name => $field ) {

                if( $field[ 'required' ] ) {
                    if( ! isset( $this->values[ $name ] ) || empty( $this->values[ $name ] ) ) {
                        $this->errors[ $name ] = $field[ 'label' ] . ' must not be empty';
                    }
                }
            }

            if( count( $this->errors ) > 0 ) {
                return false;
            } else {
                return true;
            }
        }

        function printFields() {

            // print html for form fields

            foreach( $this->fields as $name => $field ) {

                $value = htmlspecialchars( $this->getValue( $name ) );

                if( $field[ 'type' ] != 'hidden' && $field[ 'type' ] != 'checkbox' ) {

                    print( '<div class="label">' . $field[ 'label' ] . ':</div>' . "\n" );

                    if( isset( $this->errors[ $name ] ) ) {
                        print '<div class="error">' . $this->errors[ $name ] . '</div>' . "\n";
                    }
                }

                switch( $field[ 'type' ] ) {
                    case 'hidden' : {
                        print( '<input type="hidden" name="' . $name . '" value="' . $value . '" />' . "\n\n" );
                        break;
                    }
                    case 'checkbox' : {
                        print( '<div class="field"><input type="checkbox" name="' . $name . '"' . ( ! empty( $value ) ? ' checked="checked"' : '' ) . ' /> ' . $field[ 'label' ] . '</div>' . "\n\n" );
                        break;
                    }
                    case 'text' : {
                        print( '<div class="field"><textarea name="' . $name . '" class="text">' . $value . '</textarea></div>' . "\n\n" );
                        break;
                    }
                    case 'html' : {
                        print( '<div class="field"><textarea name="' . $name . '" class="html">' . $value . '</textarea></div>' . "\n\n" );
                        break;
                    }
                    case 'password' : {
                        // password field contents never returned to screen
                        print( '<div class="field"><input type="password" name="' . $name . '" class="smalltext" value="" /></div>' . "\n\n" );
                        break;
                    }
                    default : {
                        print( '<div class="field"><input type="text" name="' . $name . '" class="smalltext" value="' . $value . '" /></div>' . "\n\n" );
                    }
                }
            }
        }
    }

?>