<?php
/**
*
* @package phpBB Extension - Nav Links In Header
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace Sheer\navlinks\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\Sheer\navlinks\acp\main_module',
			'version'	=> '1.0.0',
			'title' => 'ACP_NAV_LINKS_MANAGE',
			'modes'		=> array(
				'settings'	=> array(
					'title' => 'ACP_NAV_LINKS_MANAGE',
					'auth' => 'ext_Sheer/navlinks && acl_a_board && acl_a_manage_navlinks',
					'cat' => array('ACP_NAV_LINKS')
				),
			),
		);
	}
}
