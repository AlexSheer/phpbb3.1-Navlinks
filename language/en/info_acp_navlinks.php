<?php
/**
*
* info_acp_navlinks [En]
*
* @package phpBB Extension - Nav Links In Header
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
	'ACP_NAV_LINKS'				=> 'Nav links',
	'ACP_NAV_LINKS_EXPLAIN'		=> 'Here you can configure the extension.',
	'ACP_NAV_LINKS_MANAGE'		=> 'Manage',
	'LINK_NAME'					=> 'Name',
	'LINK_URL'					=> 'URL-address',
	'LINK_ICON'					=> 'Icon',
	'LINK_ICON_FILENAME'		=> 'Filename',
	'LINK_ACTIVE'				=> 'Active',
	'DELETE_MARKED_SUCESS'		=> 'Selected links have been successfully removed',
	'DELETE_SUCESS'				=> 'All links have been successfully removed',
	'UPDATE_SUCCESS'			=> 'Selected links have been updated successfully',
	'UPDATE_FAIL'				=> 'Nothing selected',
	'EMPTY_LINK'				=> 'Not specified name links',
	'EMPTY_URL'					=> 'No URL address',
	'ADD_SUCCESS'				=> 'Link successfully added',
));
