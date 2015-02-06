<?php
/**
*
* @package phpBB Extension - Nav Links In Header
* @copyright (c) 2015 Sheer
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace Sheer\navlinks\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $template, $cache, $request, $table_prefix;
		global $phpbb_root_path, $phpbb_admin_path;

		$phpbb_admin_path = (defined('PHPBB_ADMIN_PATH')) ? PHPBB_ADMIN_PATH : './';

		define ('NAV_LINKS_TABLE', $table_prefix.'nav_links');

		$action		= request_var('action', '');
		$link_id	= request_var('link_id', 0);

		$ids		= request_var('ids', array(0));
		$links		= request_var('links', array(''));
		$urls		= request_var('urls', array(''));
		$icons		= request_var('icons', array(''));
		$s_enable	= request_var('enable', array('' => 0));
		$deletemark	= $request->variable('delmarked', false, false, \phpbb\request\request_interface::POST);
		$deleteall	= $request->variable('delall', false, false, \phpbb\request\request_interface::POST);

		$link_name	= request_var('link_name', '', true);
		$link_url	= request_var('link_url', '');
		$link_icon	= request_var('link_icon', '');
		$link_active= request_var('link_active', true);

		$this->tpl_name = 'acp_navlinks_body';
		$this->page_title = $user->lang('ACP_NAV_LINKS');
		$error = $_error = array();

		$dir = "{$phpbb_root_path}ext/Sheer/navlinks/images";
		$dp = @opendir($dir);
		if ($dp)
		{
			$files = array();
			while (($file = readdir($dp)) !== false)
			{
				$files[] = $file;
			}
			$files = array_diff($files, array('.', '..', 'index.htm'));
		}

		$new_icon_select = '<option value="spacer.gif">' . $user->lang['SELECT'] . '</option>';
		foreach($files as $key => $icon)
		{
			$selected = ($link_icon == $icon) ? ' selected="selected"' : '';
			if($icon != 'spacer.gif')
			{
				$new_icon_select .= '<option value= ' . $icon . ' ' . $selected . '>' . $icon . '</option>';
			}
		}

		add_form_key('Sheer/navlinks');

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('Sheer/navlinks'))
			{
				trigger_error('FORM_INVALID');
			}

			if(sizeof($ids))
			{
				foreach($ids as $key => $id)
				{
					if(!$links[$id])
					{
						$error[] = $user->lang['EMPTY_LINK'];
						break;
					}

					if(!$urls[$id])
					{
						$error[] = $user->lang['EMPTY_URL'];
						break;
					}

					if (!sizeof($error))
					{
						$sql_data = array(
							'link'		=> $links[$id],
							'url'		=> $urls[$id],
							'icon'		=> $icons[$id],
							'enable'	=> isset($s_enable[$id]) ? 1: 0,
						);

						$sql = 'UPDATE ' . NAV_LINKS_TABLE . '
							SET ' . $db->sql_build_array('UPDATE', $sql_data) . '
							WHERE id = ' . $id;
						$db->sql_query($sql);

						meta_refresh(3, append_sid($this->u_action));
						trigger_error($user->lang['UPDATE_SUCCESS']);
					}
				}
			}
			else
			{
				meta_refresh(3, append_sid($this->u_action));
				trigger_error($user->lang['UPDATE_FAIL'], E_USER_WARNING);
			}
		}

		if (($deletemark || $deleteall))
		{
			if (confirm_box(true))
			{
				if ($deletemark && sizeof($ids))
				{
					$msg = $user->lang['DELETE_MARKED_SUCESS'];
					foreach($ids as $id)
					{
						$sql = 'SELECT order_link
							FROM ' . NAV_LINKS_TABLE. '
							WHERE id = '. $id;
						$result = $db->sql_query($sql);
						$order_link = (int) $db->sql_fetchfield('order_link');
						$db->sql_freeresult($result);

						$sql = 'DELETE FROM ' . NAV_LINKS_TABLE. ' WHERE id = '. $id;
						$db->sql_query($sql);

						$sql = 'SELECT id, order_link
							FROM ' . NAV_LINKS_TABLE. '
							WHERE order_link > '. $order_link;
						$result = $db->sql_query($sql);

						while ($row = $db->sql_fetchrow($result))
						{
							$sql = 'UPDATE ' . NAV_LINKS_TABLE. ' SET order_link = order_link - 1 WHERE id = '. $row['id'] . '';
							$db->sql_query($sql);
						}
						$db->sql_freeresult($result);
					}
				}
				if($deleteall)
				{
					$sql = 'TRUNCATE ' . NAV_LINKS_TABLE;
					$msg = $user->lang['DELETE_SUCESS'];
					$db->sql_query($sql);
				}
				meta_refresh(3, append_sid($this->u_action));
				trigger_error($msg);
			}
			else
			{
				confirm_box(false, $user->lang['CONFIRM_OPERATION'], build_hidden_fields(array(
					'delmarked'	=> $deletemark,
					'delall'	=> $deleteall,
					'ids'		=> $ids,
					'action'	=> $this->u_action))
				);
			}
		}

		$sql = 'SELECT *
			FROM ' . NAV_LINKS_TABLE . ' ORDER BY order_link';
		$result = $db->sql_query($sql);
		while ($row = $db->sql_fetchrow($result))
		{
			$icon_select = '';
			foreach($files as $key => $icon)
			{
				$selected = ($row['icon'] == $icon) ? ' selected="selected"' : '';
				$icon_select .= '<option value= ' . $icon . ' '. $selected . '>' . $icon . '</option>';
			}

			$template->assign_block_vars('links', array(
				'ID'			=> $row['id'],
				'LINK'			=> $row['link'],
				'URL'			=> $row['url'],
				'ICON_FILENAME'	=> $row['icon'],
				'S_ENABLE'		=> ($row['enable']) ? 'checked="checked"' : '',
				'ICON'			=> '' . $phpbb_root_path . 'ext/Sheer/navlinks/images/' . $row['icon'] . '',
				'S_IMAGES'		=> $icon_select,
				'U_MOVE_UP'		=> $this->u_action . '&amp;action=move_up&amp;link_id=' . $row['id'] . '',
				'U_MOVE_DOWN'	=> $this->u_action . '&amp;action=move_down&amp;link_id=' . $row['id'] . '',
				)
			);
		}
		$db->sql_freeresult($result);

		if ($request->is_set_post('add'))
		{
			$sql = 'SELECT MAX(order_link) AS max FROM ' . NAV_LINKS_TABLE;
			$result = $db->sql_query($sql);
			$max = (int) $db->sql_fetchfield('max');
			$db->sql_freeresult($result);
			++$max;

			if(!$link_name)
			{
				$_error[] = $user->lang['EMPTY_LINK'];
			}

			if(!$link_url)
			{
				$_error[] = $user->lang['EMPTY_URL'];
			}

			if(!sizeof($_error))
			{
				$sql_ary = array(
					'link'		=> $link_name,
					'url'		=> $link_url,
					'icon'		=> $link_icon,
					'enable'	=> $link_active,
					'order_link'=> $max,
				);

				$db->sql_query('INSERT INTO ' . NAV_LINKS_TABLE . ' ' . $db->sql_build_array('INSERT', $sql_ary));
				meta_refresh(3, append_sid($this->u_action));
				trigger_error($user->lang['ADD_SUCCESS']);
			}
		}

		switch ($action)
		{
			case 'move_up':
			case 'move_down':
			$move_name = $this->move($link_id, $action);
			$cache->destroy('sql', NAV_LINKS_TABLE);
			if ($request->is_ajax())
			{
				$json_response = new \phpbb\json_response;
				$json_response->send(array(
					'success'	=> ($move_name !== false),
				));
			}
			break;
		}

		$template->assign_vars(array(
			'U_ACTION'		=> $this->u_action,
			'ERROR'			=> (sizeof($error)) ? implode('<br />', $error) : '',
			'S_ERROR'		=> (sizeof($_error)) ? implode('<br />', $_error) : '',
			'S_IMAGES'		=> $new_icon_select,
			'LINK_URL'		=> $link_url,
			'ICON'			=> ($link_icon) ? '' . $phpbb_root_path . 'ext/Sheer/navlinks/images/' . $link_icon . '' : '' . $phpbb_root_path . 'images/spacer.gif',
		));
	}

	function move($id, $action = 'move_up')
	{
		global $db;
		$sql = 'SELECT order_link
			FROM ' . NAV_LINKS_TABLE . '
			WHERE id = ' . $id;
		$result = $db->sql_query_limit($sql, 1);
		$order = $db->sql_fetchfield('order_link');
		$db->sql_freeresult($result);

		$sql = 'SELECT id, order_link
			FROM ' . NAV_LINKS_TABLE . "
			WHERE " . (($action == 'move_up') ? "order_link < {$order} ORDER BY order_link DESC" : "order_link > {$order} ORDER BY order_link ASC");
		$result = $db->sql_query_limit($sql, 1);
		$target = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$target = $row;
		}
		$db->sql_freeresult($result);

		if (!sizeof($target))
		{
			return false;
		}

		if ($action == 'move_up')
		{
			$sql = 'UPDATE ' . NAV_LINKS_TABLE. ' SET order_link = order_link + 1 WHERE id = '. $target['id'] . '';
			$db->sql_query($sql);
			$sql = 'UPDATE ' . NAV_LINKS_TABLE. ' SET order_link = order_link - 1 WHERE id = '. $id . '';
			$db->sql_query($sql);
		}
		else
		{
			$sql = 'UPDATE ' . NAV_LINKS_TABLE. ' SET order_link = order_link - 1 WHERE id = '. $target['id'] . '';
			$db->sql_query($sql);
			$sql = 'UPDATE ' . NAV_LINKS_TABLE. ' SET order_link = order_link + 1 WHERE id = '. $id . '';
			$db->sql_query($sql);
		}
		return $order;
	}
}
