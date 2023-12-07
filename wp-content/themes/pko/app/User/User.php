<?php

namespace WCD;

class User
{
	/**
	 * @var bool|WCD\User
	 */
	var $wpUser;

	public function __construct(int $userId = null)
	{
		add_action('wp_login', [$this, 'onLogin'], 10, 2);

		if (!$userId)
			$this->wpUser = wp_get_current_user();
		else
			$this->wpUser = get_user_by('id', $userId);

		if (isset($_GET['adminswitchuser']))
			$this->__adminSwitchUser();
	}

	/**
	 * @return bool|WCD\User
	 */
	public function getWordpressUser()
	{
		return $this->wpUser;
	}

	/**
	 * @return int|null
	 */
	public function getId()
	{
		if (!$this->wpUser)
			return null;

		return $this->wpUser->ID;
	}

	/**
	 * @return string
	 */
	public function getLogin()
	{
		return $this->wpUser->user_login;
	}

	public function onLogin()
	{

	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->wpUser->user_email;
	}

	/**
	 * @return array
	 */
	public function getAvatar()
	{
		$user_id = $this->getId();

		$avatar_url = wcd_cua_get_custom_avatar_url($user_id);

		$avatar = array(
			"id" => $this->__getMeta("custom_user_avatar"),
			"url" => $avatar_url["url"] === false ? "" : $avatar_url["url"],
		);

		return $avatar;
	}

	/**
	 * @param string $key
	 * @param $value
	 * @return bool|int
	 */
	private function __setMeta(string $key, $value)
	{
		return update_user_meta($this->getId(), $key, $value);
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	private function __getMeta(string $key)
	{
		return get_user_meta($this->getId(), $key, true);
	}
}
