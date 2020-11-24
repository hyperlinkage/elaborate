#    Elaborate - A web collaboration engine written in PHP & MySQL
#    Copyright (C) 2004 Tim Booker        
#    https://github.com/hyperlinkage/elaborate
#
#    Contributors: 
#        Tim Booker <tim@hyperlinkage.com>
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

# First set of amendments to database
DROP TABLE IF EXISTS `elaborate_users`;
CREATE TABLE `elaborate_users` (
  `created` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `lastvisited` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(255) default NULL,
  `password` varchar(32) default NULL,
  `email` varchar(255) NOT NULL default '',
  `level` int(11) default NULL,
  `confirmation` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
);

CREATE TABLE `elaborate_links` (
    `page` INT( 11 ) ,
    `link` VARCHAR( 255 ) ,
    `active` TINYINT DEFAULT '0'
);

ALTER TABLE `elaborate_links` ADD UNIQUE (
    `page` ,
    `link`
);

ALTER TABLE `elaborate_revisions` DROP `keywords`;
ALTER TABLE `elaborate_pages` DROP `keywords`;

ALTER TABLE `elaborate_locks` ADD `user` INT( 11 ) AFTER `date`;
ALTER TABLE `elaborate_revisions` ADD `user` INT( 11 ) AFTER `content`;