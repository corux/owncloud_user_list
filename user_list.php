<?php

/**
 * ownCloud
 *
 * @author Tobias Wallura
 * @copyright 2013 Tobias Wallura <tobias@wallura.org>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU AFFERO GENERAL PUBLIC LICENSE for more details.
 *
 * You should have received a copy of the GNU Affero General Public
 * License along with this library.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

class OC_USER_LIST extends OC_User_Backend {

	public function __construct() {
	}

	public function deleteUser($uid) {
		// Can't delete user
		OC_Log::write('OC_USER_LIST', 'Not possible to delete users from web frontend using the List user backend', 3);
		return false;
	}

	public function setPassword ( $uid, $password ) {
		// We can't change user password
		OC_Log::write('OC_USER_LIST', 'Not possible to change password for users from web frontend using the List user backend', 3);
		return false;
	}

	public function checkPassword( $uid, $password ) {
		// We don't authenticate users.
		OC_Log::write('OC_USER_LIST', 'Not possible to check password for users with the List user backend', 3);
		return false;
	}

	/*
	* User will be checked based on existing directory under 'data/'.
	*/
	public function userExists( $uid ){
		$dir = OC_Config::getValue( "datadirectory", OC::$SERVERROOT."/data" ) . '/' . $uid . "/files";
		return file_exists($dir);
	}

	/**
	 * @return bool
	 */
	public function hasUserListings() {
		return true;
	}

	/*
	* All users with a data directory.
	*/
	public function getUsers($search = '', $limit = 10, $offset = 0) {
		$returnArray = array();
		
		$dir = OC_Config::getValue( "datadirectory", OC::$SERVERROOT."/data" );
		if ($handle = opendir($dir)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != "..") {
					if (file_exists($dir . '/' . $entry . "/files")) {
						$returnArray[] = $entry;
					}
				}
			}
		}

		return $returnArray;
	}
}
