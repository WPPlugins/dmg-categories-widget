<?php
/*
Plugin Name: DMG Categories Widget
Plugin URI: http://dancoded.com/wordpress-plugins/categories-widget/
Description: A widget to display a list of categories with advanced options to show the list as a dropdown, display a post count, show a hierarchy, add CSS classes and display the title
Version: 1.0
Author: Dan Gifford
Author URI: http://dancoded.com/


    Copyright (C) 2016  Dan Gifford

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */



/*
	Prevent direct access
 */
if( !defined( 'ABSPATH' ) ) { exit; }



/*
	Requires
 */
if( !class_exists('DMG\\WP_Widget_Base\\WP_Widget_Base') )
{
    require_once 'vendor/DMG/WP_Widget_Base/src/WP_Widget_Base.php';
}

require_once 'src/WP_Categories_Widget.php';



/*
	Register widget
 */
add_action( 'widgets_init', function()
{
    unregister_widget( 'WP_Widget_Categories' );
    register_widget( 'DMG\\WP_Categories_Widget\\WP_Categories_Widget' );
});