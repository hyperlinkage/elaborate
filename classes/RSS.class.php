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

    class RSS {

        function RSS() {
            $this->items = array();            
            $this->meta = array();
        }
        
        function addMetaData( $title, $description, $link ) {
            // add meta data for the rss feed

            $this->meta[ 'title' ] = $title;
            $this->meta[ 'description' ] = $description;
            $this->meta[ 'link' ] = $link;
        }
        
        function addItem( $title, $description, $link ) {
            // add an item to the rss feed        
        
            $this->items[] = array( 
                'title' => $title,
                'description' => $description,
                'link' => $link
            );
        }

        function getRSS( $version = 0.91 ) {
            // return xml of the rss feed
            // needs improvement - a more generic set of functions to return different rss versions
        
            $xml = '';

            foreach( $this->items as $i ) {
            
                $xml .= 
                    '    <item>' . "\n" .
                    '        <title>' . htmlspecialchars( $i[ 'title' ] ) . '</title>' . "\n" .
                    '        <description>' . htmlspecialchars( $i[ 'description' ] ) . '</description>' . "\n" .
                    '        <link>' . htmlspecialchars( $i[ 'link' ] ) . '</link>' . "\n" .
                    '    </item>' . "\n\n";
            }

            $xml = 
                '<?xml version="1.0" encoding="ISO-8859-1" ?>' . "\n" .
                '<rss version="0.91">' . "\n" .
                '' . "\n" .
                '<channel>' . "\n" .
                '' . "\n" .
                '    <title>' . htmlspecialchars( $this->meta[ 'title' ] ) . '</title>' . "\n" .
                '    <description>' . htmlspecialchars( $this->meta[ 'description' ] ) . '</description>' . "\n" .
                '    <link>' . htmlspecialchars( $this->meta[ 'link' ] ) . '</link>' . "\n" .
                '' . "\n" .
                $xml .
                '</channel>' . "\n" .
                '' . "\n" .
                '</rss>';                

            return $xml;
        }        
    }
    
?>