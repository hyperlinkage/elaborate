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

    $data[ 'page' ][ 'type' ] = 'diff';

    $pageId = ( isset( $params[ 'id' ] ) ? intval( $params[ 'id' ] ) : '' );
    $revisionId = ( isset( $params[ 'rev' ] ) ? intval( $params[ 'rev' ] ) : '' );

    $revisions = $wiki->getRevisions( $pageId );

    foreach( $revisions as $idx => $r ) {

        if( $r[ 'id' ] == $revisionId ) {

            $data[ 'page' ][ 'left' ] = $r;

            if( $idx == 0 ) {
                $data[ 'page' ][ 'right' ] = $wiki->getPageById( $pageId );
            } else {
                $data[ 'page' ][ 'right' ] = $revisions[ $idx - 1 ];
            }

        }
    }
    $data[ 'page' ][ 'title' ] = 'Differences in ' . $data[ 'page' ][ 'right' ][ 'title' ];
    $data[ 'page' ][ 'differences' ] = diff( $data[ 'page' ][ 'left' ][ 'content' ], $data[ 'page' ][ 'right' ][ 'content' ] );

    function diff( $left, $right ) {

        $left = explode( "\r", $left);
        $right = explode( "\r", $right );

        $leftLines = array();
        $rightLines = array();

        $tolerance = 75;

        // for every row on left
        while( $leftLine = array_shift( $left ) ) {

            if( count( $right ) ) {
                $rightLine = array_shift( $right );
            } else {
                $rightLine = '';
            }

            $similarity = textSimilarity( $leftLine, $rightLine );

            // is the right hand row the same or similar?
            if( $similarity > $tolerance ) {

                //copy both rows and set same or changed flags

                if( $similarity == 100 ) {
                    // exact match
                    $leftLines[] = array(
                        'status' => 'unchanged',
                        'text' => $leftLine
                    );
                    $rightLines[] = array(
                        'status' => 'unchanged',
                        'text' => $rightLine
                    );

                } else {
                    // changed
                    $leftLines[] = array(
                        'status' => 'changed',
                        'text' => $leftLine
                    );
                    $rightLines[] = array(
                        'status' => 'changed',
                        'text' => $rightLine
                    );
                }

            } else {

                // is a similar or same row found anywhere on right?
                $found = false;

                foreach( $right as $r ) {
                    if( textSimilarity( $leftLine, $r ) > $tolerance ) {
                        $found = true;
                        break;
                    }
                }

                if( $found ) {

                    //copy right row and set inserted flag

                    $leftLines[] = array(
                        'status' => 'null',
                        'text' => ''
                    );
                    $rightLines[] = array(
                        'status' => 'inserted',
                        'text' => $rightLine
                    );

                    // add left line back onto array
                    array_unshift( $left, $leftLine );

                } else {

                    //copy left rows and set removed flag
                    $leftLines[] = array(
                        'status' => 'removed',
                        'text' => $leftLine
                    );
                    $rightLines[] = array(
                        'status' => 'null',
                        'text' => ''
                    );

                    // add right line back onto array
                    array_unshift( $right, $rightLine );
                }
            }
        }

        if( count( $right ) > 0 ) {

            foreach( $right as $r ) {
                $leftLines[] = array(
                    'status' => 'null',
                    'text' => ''
                );
                $rightLines[] = array(
                    'status' => 'inserted',
                    'text' => trim( $r )
                );
            }
        }
        return array( 'left' => $leftLines, 'right' => $rightLines );
    }

    function textSimilarity( $left, $right ) {
        // compare two pieces of text and return similarity
        // will need improving later

        $similarity = 0;

        if( trim( $left ) == trim( $right ) ) {
            $similarity = 100;
        } else {

            $leftChars = explode( "\r\n", trim( chunk_split( strtolower( $left ), 1 ) ) );
            $rightChars = explode( "\r\n", trim( chunk_split( strtolower( $right ), 1 ) ) );

            $shared = array_intersect( $leftChars, $rightChars );
            $similarity = ( ( count( $shared ) * 2 ) / strlen( $left . $right ) ) * 100;
        }
        return $similarity;
    }

?>