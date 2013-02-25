<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Assist
 *
 * This is the model file for User_Model class.
 * This is where all the functions talks to the
 * database.
 *
 * @package		Assist
 * @author		Team Assist
 */

// ------------------------------------------------------------------------
class User_Model extends CI_Model {

	/**
	 * Constructor for the User_Model Class
	 *
	 * Load required model, helper, library class file.
	 *
	 */
	function __construct() {
		parent::__construct();

		$this -> load -> helper('security');
	}

	// --------------------------------------------------------------------

	/**
	 * Authenticates user based on given password and email address.
	 *
	 * This function will make sure that at least one value is return
	 * upon querying the database. If not it will return false.
	 *
	 */

	function authenticate_user($email, $password) {

		$this -> db -> select('Id, FullName');
		$this -> db -> from('AllUsers');
		$this -> db -> where('Email', $email);
		$this -> db -> where('Password', do_hash($password, 'md5'));
		//hash password with MD5
		$this -> db -> where('Status', 'Active');
		$this -> db -> limit(1);

		$query = $this -> db -> get();

		if ($query -> num_rows() == 1) {
			return $query -> result();
		} else {
			return false;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get a list of user roles.
	 *
	 * This will return an array of user role for populating
	 * the select box
	 *
	 */
	function get_user_roles() {

		$query = $this -> db -> get('UserRole');

		return $query -> result_array();

	}

	// --------------------------------------------------------------------

	/**
	 * Get total users
	 *
	 * Get the total number of rows in users all users table
	 *
	 */
	function count_users() {

		return $this -> db -> count_all("AllUsers");

	}

	// --------------------------------------------------------------------

	/**
	 * Get a array of user information
	 *
	 * This will return an array of user information
	 *
	 */
	function get_user_by_id($id) {
		if (isset($id) && !empty($id)) {
			$this -> db -> where('Id', $id);

			//Execute query
			$query = $this -> db -> get('AllUsers');

			if ($query -> num_rows() > 0)
				return $query -> result();

			return null;
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Get a array of user information
	 *
	 * This will return an array of user information
	 *
	 */

	function get_users($params) {
		//Set start
		$start = isset($params['start']) ? $params['start'] : NULL;
		//Set limit
		$limit = isset($params['limit']) ? $params['start'] : NULL;
		//Set sort field
		$sortField = isset($params['sortField']) ? $params['sortField'] : 'FullName';
		//Set sort order
		$sortOrder = isset($params['sortOrder']) ? $params['sortOrder'] : 'asc';
		//Set where
		$whereParam = isset($params['whereParam']) ? $params['whereParam'] : NULL;
		//Set filters
		$filters = isset($params['filters']) ? json_decode($params['filters']) : NULL;
		//Set search
		$isSearch = isset($params['isSearch']) ? json_decode($params['isSearch']) : NULL;

		//Set limit if both start and limit isn't null
		if (!empty($start) && !empty($limit))
			$this -> db -> limit($limit, $start);

		$this -> db -> where('(1=1)');

		//Set where parameter
		if (!empty($whereParam))
			$this -> db -> where('(' . $whereParam . ')');

		//Set search
		if ($isSearch && $filters != null) {
			//get rules
			foreach ($filters -> rules as $rule) {
				$field = $rule -> field;
				$value = mysql_real_escape_string($rule -> data);

				//add like clause
				$this -> db -> like($field, $value, 'after');
			}
		}

		$this -> db -> order_by($sortField, $sortOrder);

		//Execute query
		$query = $this -> db -> get('AllUsers');

		if ($query -> num_rows() > 0)
			return $query -> result();

		return null;
	}

	// --------------------------------------------------------------------

	/**
	 * Quick registration for the Home page
	 *
	 * This allows user to quickly register from the homepage with the minimum
	 * information needed. Users are still required to complete their profile
	 * once they logged in.
	 *
	 */

	function quick_register($result) {

		$this -> load -> helper('security');

		//set object for new user
		$data = array('FirstName' => $result['first_name'], 'LastName' => $result['last_name'], 'Email' => $result['email'], 'Password' => do_hash($result['password'], 'md5'), 'Gender' => $result['gender'], 'DateOfBirth' => ($result['dob_year'] . '-' . $result['dob_month'] . '-' . $result['dob_day']), 'Status' => 'Active');

		//insert into database
		$this -> db -> insert('User', $data);

		//Get returned Id
		$return_id = $this -> db -> insert_id();

		//Inser user role
		$this -> insert_user_role($return_id, 7);
	}

	// --------------------------------------------------------------------

	/**
	 * Insert user role
	 *
	 * This will insert user role to the database based on the id and given role id
	 *
	 */

	function insert_user_role($user_id, $role) {
		//Set object for user team role
		$data = array('UserId' => $user_id, 'UserRoleId' => $role, 'TeamId' => null);

		//insert into database
		$this -> db -> insert('UserTeamRole', $data);
	}

}
?>