Elaborate - A web collaboration engine written in PHP & MySQL
Copyright (C) 2004 Tim Booker
http://elaborate.sourceforge.net/

Contributors:
    Tim Booker <elaborate@7segment.org>

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

Installation:
    - Unzip the file to a directory in your web server document root.
    - Edit includes/config.php to add your install location and MySQL access details.
    - View the site in a browser, and follow the instructions on-screen.

Features:
    - A free Wiki engine (a web site on which users can create and edit pages through a web interface)
    - Wiki links created by using <wiki> tags
    - All other formatting using plain HTML
    - Optional user registration
    - Editing and page viewing can be restricted to registered users
    - Complete change history stored for each page
    - Roll-back to previous version of a page
    - Keyword search
    - RSS feeds of new and/or updated pages
    - PHP & MySQL based
    - Available under the GNU General Public Licence

Changes:
    2004-12-12
        - Added <wiki></wiki> syntax for links
        - Added roll-back to previous version of a page 
        - Added user registration
        - Added RSS feeds for new and updated pages        
        - Added print stylesheet
        - Added friendly error message hen requesting an old page name
        - Improved form handling code, including inline error reporting
        - Improved site design
        - Improved context text shown on search results pages
        - Removed privilege checking on MySQL account (buggy)
        
    2004-11-10
        - First release of the software
