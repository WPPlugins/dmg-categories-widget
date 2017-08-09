=== DMG Categories Widget ===
Contributors: dancoded
Tags: categories widget, menu, css, list categories, category list
Donate link: http://dancoded.com/wordpress-plugins/
Requires at least: 3.1
Tested up to: 4.6
Stable tag: 1.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/

Displays categories as a list or dropdown jump-menu. With advanced options to add CSS classes and modify the title .

== Description ==

Display categories as a list of links or a dropdown jump-menu (automatically navigate to page when selected).

Includes advanced options to change the taxonomy, display post counts and the category hierarchy, change how they are ordered, add CSS styles and modify the title.

Replaces the built in Categories Widget (WP_Widget_Categories).

A hook is available to filter the title: `dmg_categories_widget_title`.

For example, to change the title on a single page or post, you could add this to your functions.php file:


`function myTitleFilter( $title )
{
	if( is_singular() )
	{
		return "<strong>$title</strong>";
	}
	else
	{
		return $title;		
	}
}
add_filter( 'dmg_categories_widget_title' , 'myTitleFilter');`

More information about this plugin can be found at <http://dancoded.com/wordpress-plugins/categories-widget/>.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/dmg-categories-widget` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the 'Plugins' page in the WordPress admin area
1. Drag onto any active sidebar on the 'Appearance > Widgets' page

== Changelog ==
= 1.0 =
* Initial version