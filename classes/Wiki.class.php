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

    class Wiki {

        function Wiki() {

            $this->linksTable = 'elaborate_links';
            $this->locksTable = 'elaborate_locks';
            $this->pagesTable = 'elaborate_pages';
            $this->revisionsTable = 'elaborate_revisions';

            $this->db = & $GLOBALS[ 'db' ];
            $this->session = & $GLOBALS[ 'session' ];
        }

        function getPage( $pageTitle ) {
            // return a page content by title
            // if no title is passed, returns home page

            $pageTitle = $this->cleanName( $pageTitle );

            $page = $this->db->getRows( 'SELECT * FROM ' . $this->pagesTable . ' WHERE ' . ( $pageTitle ? 'title LIKE "' . $pageTitle . '"' : 'type = "home"' ) );

            if( count( $page ) > 0 ) {
                $page = $page[ 0 ];
            }
            return $page;
        }

        function getPageById( $pageId ) {
            // return a page content by id
            // if no id is passed, returns home page

            $pageId = intval( $pageId );

            $page = $this->db->getRows( 'SELECT * FROM ' . $this->pagesTable . ' WHERE ' . ( $pageId ? 'id = ' . $pageId : 'type = "home"' ) );

            if( count( $page ) > 0 ) {
                $page = $page[ 0 ];
            }
            return $page;
        }

        function getPageWithLinks( $pageTitle ) {

            $pageTitle = $this->cleanName( $pageTitle );

            // get page content
            $page = $this->getPage( $pageTitle );

            if( count( $page ) ) {

                // get links from db
                $linkedPages = $this->db->getRows( 'SELECT ' . $this->pagesTable . '.title FROM ' . $this->linksTable . ', ' . $this->pagesTable . ' WHERE ' . $this->linksTable . '.page = ' . $page[ 'id' ] . ' AND ' . $this->linksTable . '.link LIKE ' . $this->pagesTable . '.title' );

                if( count( $linkedPages ) ) {

                    // insert html for each link
                    foreach( $linkedPages as $link ) {

                        $pattern = '/<wiki>\s*(' . $link[ 'title' ] . ')\s*<\/wiki>/isU';
                        $replacement = '<a href="' . $GLOBALS[ 'url' ] . '?page=' . urlencode( $link[ 'title' ] ) . '" title="' . $GLOBALS[ 'title' ] . ': ' . htmlspecialchars( $link[ 'title' ] ) . '">$1</a>';

                        $page[ 'content' ] = preg_replace( $pattern, $replacement, $page[ 'content' ] );
                    }
                }

                // remaining wiki links are given an add button
                if( preg_match_all( '/<wiki>(.*)<\/wiki>/isU', $page[ 'content' ], $matches ) ) {

                    $pattern = '/<wiki>\s*(.*)\s*<\/wiki>/isUe';
                    $replacement = '\'<a class="broken" href="' . $GLOBALS[ 'url' ] . '?action=edit&amp;create=\' . urlencode( $this->cleanName( \'$1\' ) ) . \'" title="\' . htmlspecialchars( "' . $GLOBALS[ 'title' ] . '" ) . \': Create \' . htmlspecialchars( $this->cleanName( "$1" ) ) . \' page">\' . htmlspecialchars( $this->cleanName( "$1" ) ) . \'+</a>\'';

                    $page[ 'content' ] = preg_replace( $pattern, $replacement, $page[ 'content' ] );
                }

            }
            return $page;
        }

        function getPageAlternative( $pageTitle ) {

            // check the revisions table for the page title, in case the page title has been changed
            $alt = $this->db->getRows( 'SELECT page FROM ' . $this->revisionsTable . ' WHERE title LIKE "' . $pageTitle . '" ORDER BY date DESC LIMIT 0,1' );

            if( isset( $alt[ 0 ] ) ) {
                return $this->getPageById( $alt[ 0 ][ 'page' ] );
            }
            return array();
        }

        function getPageList() {
            return $this->db->getRows( 'SELECT title, modified FROM ' . $this->pagesTable . ' ORDER BY title ASC' );
        }

        function getNewPageList( $count = 20 ) {
            // get a list of the most recent pages

            $count = intval( $count );
            return $this->db->getRows( 'SELECT title, content, created FROM ' . $this->pagesTable . ' ORDER BY created DESC LIMIT 0,' . $count );
        }

        function getUpdatedPageList( $count = 20 ) {
            // get a list of the most recently changed

            $count = intval( $count );
            return $this->db->getRows( 'SELECT title, content, modified FROM ' . $this->pagesTable . ' ORDER BY modified DESC LIMIT 0,' . $count );
        }

        function getRevisions( $pageId ) {

            $revisions = $this->db->getRows( 'SELECT * FROM ' . $this->revisionsTable . ' WHERE page = ' . $pageId . ' ORDER BY date DESC' );

            return $revisions;
        }

        function getRevision( $revId ) {

            $revId = intval( $revId );

            $revision = $this->db->getRows( 'SELECT * FROM ' . $this->revisionsTable . ' WHERE id = ' . $revId );

            if( count( $revision  ) > 0 ) {
                $revision = $revision [ 0 ];
            }
            return $revision;
        }

        function getSearchResults( $query, $numResults ) {

            $before = 70;
            $after  = 150;

            $results = $this->db->getRows( 'SELECT * FROM ' . $this->pagesTable . ' WHERE MATCH ( searchdata ) AGAINST ( "' . $query . '" ) LIMIT 0, ' . $numResults );

            // add some context text to the results array, to be displayed on the results page

            foreach( $results as $i => $r ) {

                // normailise whitespace and strip tags
                $r[ 'content' ] = preg_replace( '/\s+/', ' ', strip_tags( $r[ 'content' ] ) );

                // match search word with context chars either side
                $pattern = '/(.*?)(\b.{0,' . $before . '})(' . $query . ')(.{0,' . $after . '}\b\.{0,1})(.*)/is';

                if( preg_match( $pattern, $r[ 'content' ], $matches ) ) {

                    // add bold tags to highlight the search term
                    $highlight = '<strong>' . $matches[ 3 ] . '</strong>';

                    // add ... to indicate that chars were removed from the start or end
                    $startText = ( empty( $matches[ 1 ] ) ? '' : '...' ) . ltrim( $matches[ 2 ] );
                    $endText = rtrim( $matches[ 4 ] ) . ( empty( $matches[ 5 ] ) ? '' : '...' );

                    // re-assemble the string
                    $context = $startText . $highlight . $endText;

                } else {

                    // if the search term isn't found, just return the beginning of the body text
                    $context = substr( $r[ 'content' ], 0, $before + $after ) . '...';
                }
                $results[ $i ][ 'context' ] = $context;
            }
            return $results;
        }

        function createPage( $newTitle, $newContent ) {

            // create a new page in the db

            $newTitle = $this->cleanName( $newTitle );

            $existingPage = $this->getPage( $newTitle );

            if( count( $existingPage ) == 0 && ! empty( $newTitle ) ) {

                $links = $this->getLinks( $newContent );

                $newPage = array(
                    'created'    => time(),
                    'modified'   => time(),
                    'title'      => $newTitle,
                    'content'    => $newContent,
                    'searchdata' => $this->createSearchText( $newTitle, $newContent )
                );

                $pageId = $this->db->insertAssoc( $this->pagesTable, $newPage );

                // create links used in this page
                foreach( $links[ 'active' ] as $val ) {
                    $this->db->insertRows( 'REPLACE INTO ' . $this->linksTable . ' ( page, link, active ) VALUES( ' . $pageId  . ', "' . $val . '", 1 )' );
                }
                foreach( $links[ 'broken' ] as $val ) {
                    $this->db->insertRows( 'REPLACE INTO ' . $this->linksTable . ' ( page, link, active ) VALUES( ' . $pageId  . ', "' . $val . '", 0 )' );
                }

                // update links pointing to this page
                $this->activateLinks( $newTitle );

                return true;
            } else {
                return false;
            }
        }

        function updatePage( $pageId, $newTitle, $newContent ) {

            $newTitle = $this->cleanName( $newTitle );

            $existingPage = $this->getPage( $newTitle );

            if( count( $existingPage ) > 0 && $existingPage[ 'id' ] !=  $pageId  || empty( $newTitle ) ) {
                // different page already uses the new title
                return false;
            } else {

                $currentVersion = $this->getPageById( $pageId );

                // compare current text to old
                $currentHash = md5( $currentVersion[ 'title' ] . $currentVersion[ 'content' ] );
                $newHash = md5( $newTitle . stripslashes( $newContent ) );

                if( $currentHash != $newHash ) {
                    // copy old version of page
                    
                    $this->db->insertRows( 'INSERT INTO ' . $this->revisionsTable . ' SELECT "", "' . time() . '", id, title, content, "", "' . $_SERVER[ 'REMOTE_ADDR' ] . '" FROM  ' . $this->pagesTable . ' WHERE id = ' . $pageId );
                    // update row
                    $this->db->updateRows( 'UPDATE ' . $this->pagesTable . ' SET modified = "' . time() . '", title = "' . addslashes( $newTitle ) . '", content = "' . addslashes( $newContent ) . '", searchdata = "' . addslashes( $this->createSearchText( $newTitle, $newContent ) ) . '" WHERE id = ' . $pageId );

                    // update links used in this page

                    $links = $this->getLinks( $newContent );

                    $this->db->deleteRows( 'DELETE FROM ' . $this->linksTable . ' WHERE page = ' . $pageId );

                    foreach( $links[ 'active' ] as $val ) {
                        $this->db->insertRows( 'REPLACE INTO ' . $this->linksTable . ' ( page, link, active ) VALUES( ' . $pageId  . ', "' . $val . '", 1 )' );
                    }
                    foreach( $links[ 'broken' ] as $val ) {
                        $this->db->insertRows( 'REPLACE INTO ' . $this->linksTable . ' ( page, link, active ) VALUES( ' . $pageId  . ', "' . $val . '", 0 )' );
                    }

                    // update links pointing to this page
                    if( $newTitle != $currentVersion[ 'title' ] ) {
                        // page name has changed, update other pages that link here
                        $this->breakLinks( $currentVersion[ 'title' ] );
                        $this->activateLinks( $newTitle );
                    }
                }

                // unlock page
                $this->unlockPage( $pageId );

                return true;
            }
        }

        function getLinks( $content ) {

            // parse page text and get list of valid and broken links

            $links = array(
                'active' => array(),
                'broken' => array()
            );

            if( preg_match_all( '/<wiki>(.*)<\/wiki>/isU', $content, $matches ) ) {

                foreach( $matches[ 1 ] as $link ) {
                    $clauses[] = 'title LIKE "' . trim( $link ) . '"';
                }

                $query = 'SELECT title FROM ' . $this->pagesTable . ' WHERE ( ' . implode( ' ) OR ( ', $clauses ) . ' )';
                $linkedPages = $this->db->getRows( $query );

                // insert html link to each page
                foreach( $linkedPages as $link ) {
                    $links[ 'active' ][] = strtolower( $link[ 'title' ] );
                }

                foreach( $matches[ 1 ] as $link ) {
                    if( ! in_array( strtolower( trim( $link ) ), $links[ 'active' ] ) ) {
                        $links[ 'broken' ][] = $link;
                    }
                }
            }
            return $links;
        }

        function activateLinks( $pageTitle ) {
            // make all links to this page title active
            $this->db->updateRows( 'UPDATE ' . $this->linksTable . ' SET active = 1 WHERE link = "' . $pageTitle . '"' );
        }

        function breakLinks( $pageTitle ) {
            // make all links to this page title inactive
            $this->db->updateRows( 'UPDATE ' . $this->linksTable . ' SET active = 0 WHERE link = "' . $pageTitle . '"' );
        }

        function lockPage( $pageId ) {

            $this->lockDuration = 300; // duration in seconds

            // delete expired locks
            $this->db->deleteRows( 'DELETE FROM ' . $this->locksTable . ' WHERE date < ( ' . ( time() - $this->lockDuration ) . ' )' );

            $existingLock = $this->db->getRows( 'SELECT * FROM ' . $this->locksTable . ' WHERE page = ' . $pageId );

            if( isset( $existingLock[ 0 ] ) ) {
                $existingLock = $existingLock[ 0 ];
            }

            if( count( $existingLock ) > 0 && $this->session->getId() != $existingLock[ 'session' ] ) {
                return false;
            } else {

                if( ! $existingLock ) {

                    $lock = array(
                        'page' => $pageId,
                        'date' => time(),
                        'ip'   => $_SERVER[ 'REMOTE_ADDR' ],
                        'session' => $this->session->getId()
                    );
                    $this->db->insertAssoc( $this->locksTable, $lock );
                }
                return true;
            }
        }

        function unlockPage( $pageId ) {
            $this->db->deleteRows( 'DELETE FROM ' . $this->locksTable . ' WHERE page = ' . $pageId );
        }

        function cleanName( $pageName ) {
            // remove unwanted chars from page titles

            $pageName = strip_tags( $pageName );
            $pageName = preg_replace( '/\s+/', ' ', trim( $pageName ) ); // clean up whitespace
            $pageName = preg_replace( '/[^a-z0-9_\-\.\'& ]/i', '', $pageName ); // remove everything except: letters, numbers, underscore, hyphen, dot, apostrophe, ampersand

            return $pageName;
        }

        function createSearchText( $title, $content ) {
            // returns clean version of text for searching

            $str = strtolower( strip_tags( $title . ' ' . $content ) ); // strip html and make lowercase
            $str = preg_replace( '/[^\w\s]/', '', $str );     // strip non-word, non-whitespace characters
            $str = preg_replace( '/\b\w{0,2}\b/', '', $str ); // strip words two characters or less
            $str = preg_replace( '/\s+/', ' ', $str );        // normalise whitespace
            return $str;
        }
    }

?>