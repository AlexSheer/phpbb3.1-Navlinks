<?php
/**
*
* info_acp_navlinks [Russian]
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
	'ACP_NAV_LINKS'				=> 'Ссылки навигации',
	'ACP_NAV_LINKS_EXPLAIN'		=> 'Здесь можно настроить параметры расширения.',
	'ACP_NAV_LINKS_MANAGE'		=> 'Управление',
	'LINK_NAME'					=> 'Отображаемое имя',
	'LINK_URL'					=> 'URL-адрес',
	'LINK_ICON'					=> 'Иконка',
	'LINK_ICON_FILENAME'		=> 'Имя файла',
	'LINK_ACTIVE'				=> 'Активно',
	'DELETE_MARKED_SUCESS'		=> 'Выбранные ссылки были успешно удалены',
	'DELETE_SUCESS'				=> 'Все ссылки были успешно удалены',
	'UPDATE_SUCCESS'			=> 'Выбранные ссылки были успешно изменены',
	'UPDATE_FAIL'				=> 'Ничего не выбрано',
	'EMPTY_LINK'				=> 'Не указано имя ссылки',
	'EMPTY_URL'					=> 'Не указан URL ссылки',
	'ADD_SUCCESS'				=> 'Ссылка успешно добавлена',
));
