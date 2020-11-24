#    Elaborate - A web collaboration engine written in PHP & MySQL
#    Copyright (C) 2004 -2020 Tim Booker        
#    https://github.com/hyperlinkage/elaborate
#
#    Contributors: 
#        Tim Booker <timbooker@hyperlinkage.com>
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

# SQL queries for creation of elaborate database tables from scratch

# Table structure for table `elaborate_locks`
DROP TABLE IF EXISTS `elaborate_locks`;
CREATE TABLE `elaborate_locks` (
  `page` int(11) NOT NULL default '0',
  `date` int(11) default NULL,
  `user` INT( 11 ) default NULL,
  `ip` varchar(255) default NULL,
  `session` varchar(32) default NULL,
  PRIMARY KEY  (`page`)
) ;

# Table structure for table `elaborate_pages`
DROP TABLE IF EXISTS `elaborate_pages`;
CREATE TABLE `elaborate_pages` (
  `created` int(11) NOT NULL default '0',
  `modified` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) default NULL,
  `content` text,
  `searchdata` text,
  `type` varchar(255) default NULL,
  PRIMARY KEY (`id`),
  FULLTEXT KEY `searchdata` (`searchdata`)
) ;

# Data for table `elaborate_pages`
INSERT INTO `elaborate_pages` VALUES ( UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), '', 'Home', '<p>Thanks for installing Elaborate!  This page is now yours, so feel free to click the edit tab to remove this message and start creating your own content.</p>', '', 'home' );

# Table structure for table `elaborate_revisions`
DROP TABLE IF EXISTS `elaborate_revisions`;
CREATE TABLE `elaborate_revisions` (
  `id` int(11) NOT NULL auto_increment,
  `date` int(11) default NULL,
  `page` int(11) default NULL,
  `title` varchar(255) default NULL,
  `content` text,
  `user` INT( 11 ) default NULL,
  `ip` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) ;

# Table structure for table 'elaborate_users'
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
) ;

# Table structure for table 'elaborate_links'
DROP TABLE IF EXISTS `elaborate_links`;
CREATE TABLE `elaborate_links` (
    `page` INT( 11 ) ,
    `link` VARCHAR( 255 ) ,
    `active` TINYINT DEFAULT '0'
);

ALTER TABLE `elaborate_links` ADD UNIQUE (
    `page` ,
    `link`
)
