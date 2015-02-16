<?php
/**
*
* @package phpBB Extension - Navlinks in Header
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace sheer\navlinks\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
/**
* Assign functions defined in this class to event listeners in the core
*
* @return array
* @static
* @access public
*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'						=> 'add_page_header_link',
		);
	}

	/**
	* Constructor
	*/
	public function __construct(\phpbb\template\template $template, \phpbb\db\driver\driver_interface $db, $table_prefix, $phpbb_root_path)
	{
		$this->template = $template;
		$this->db = $db;
		$this->table_prefix = $table_prefix;
		$this->phpbb_root_path = $phpbb_root_path;
	}

	public function add_page_header_link($event)
	{
		define ('NAV_LINKS_TABLE', $this->table_prefix . 'nav_links');

		$sql = 'SELECT *
			FROM '. NAV_LINKS_TABLE .'
			WHERE enable = 1
			ORDER BY order_link';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('links', array(
				'ID'	=> $row['id'],
				'LINK'	=> $row['link'],
				'URL'	=> $row['url'],
				'ICON'	=> $row['icon'],
				)
			);
		}
	}
}
