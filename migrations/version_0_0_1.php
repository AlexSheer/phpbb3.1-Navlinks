<?php
/**
*
* @package phpBB Extension - Nav Links In Header
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace Sheer\navlinks\migrations;

class version_0_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
			'add_tables'		=> array(
				$this->table_prefix . 'nav_links'	=> array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', null, 'auto_increment'),
						'link'			=> array('VCHAR:64', ''),
						'url'			=> array('VCHAR:255', ''),
						'icon'			=> array('VCHAR:64', ''),
						'enable'		=> array('BOOL', 0),
						'order_link'	=> array('USINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'		=> array(
				$this->table_prefix . 'nav_links',
			),
		);
	}

	public function update_data()
	{
		return array(
			// Current version
			array('config.add', array('navlinks_version', '0.0.1')),
			// Add permissions
			array('permission.add', array('a_manage_navlinks', true, 'a_board')),
			// ACP
			array('module.add', array('acp', 'ACP_CAT_DOT_MODS', 'ACP_NAV_LINKS')),
			array('module.add', array('acp', 'ACP_NAV_LINKS', array(
				'module_basename'	=> '\Sheer\navlinks\acp\main_module',
				'module_langname'	=> 'ACP_NAV_LINKS_MANAGE',
				'module_mode'		=> 'manage',
				'module_auth'		=> 'ext_Sheer/navlinks && acl_a_board && acl_a_manage_navlinks',
			))),
		);
	}
}
