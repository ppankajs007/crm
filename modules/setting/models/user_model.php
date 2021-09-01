<?php

class user_model extends CI_Model 
{	

	private static $db;

    function __construct(){ 
        parent::__construct();
        self::$db = &get_instance()->db;
    }


	// for finding user via facebook id
	function get_user_by_facebook_id($facebook_id)
	{
		$query = $this->db->query("SELECT users.*, user_profiles.facebook_id FROM users " .
								  "JOIN user_profiles ON users.id=user_profiles.user_id " .
								  "WHERE facebook_id='$facebook_id'");		
		return $query->result();
	}
	
	// for finding user via twitter id
	function get_user_by_twitter_id($twitter_id)
	{
		$query = $this->db->query("SELECT users.*, user_profiles.twitter_id FROM users " .
								  "JOIN user_profiles ON users.id=user_profiles.user_id " .
								  "WHERE twitter_id='$twitter_id'");		
		return $query->result();
	}	
	
	// for finding user via gfc id
	function get_user_by_gfc_id($gfc_id)
	{
		$query = $this->db->query("SELECT users.*, user_profiles.gfc_id FROM users " .
								  "JOIN user_profiles ON users.id=user_profiles.user_id " .
								  "WHERE gfc_id='$gfc_id'");		
		return $query->result();
	}	

	// Returns user by its email
	function get_user_by_email($email)
	{
		$query = $this->db->query("SELECT * FROM users u, user_profiles up WHERE u.email='$email' and u.id = up.user_id");
		return $query->result();
	}
	
	// update user profile with facebook id
	function update_facebook_user_profile($user_id, $facebook_id)
	{
		$query = $this->db->query("UPDATE user_profiles SET facebook_id='$facebook_id' WHERE user_id='$user_id'");
	}
	
	// update user profile with twitter id
	function update_twitter_user_profile($user_id, $twitter_id)
	{
		$query = $this->db->query("UPDATE user_profiles SET twitter_id='$twitter_id' WHERE user_id='$user_id'");
	}	
	
	// update user profile with gfc id
	function update_gfc_user_profile($user_id, $gfc_id)
	{
		$query = $this->db->query("UPDATE user_profiles SET gfc_id='$gfc_id' WHERE user_id='$user_id'");
	}		

	// return the user given the id
	function get_user($user_id)
	{
		$query = $this->db->query("SELECT users.*, user_profiles.* FROM users, user_profiles WHERE " .
								  "users.id='$user_id' AND user_profiles.user_id='$user_id'");
		return $query->result();
	}





	/********************************************************* 
	*														 * 	
	*	Custom code start for perfection kitchens CRM 		 *
	*	Developer Parveen Chauhan							 *	
	*	April 24, 2019 										 *	
	*														 *	
	**********************************************************/








    // Get logged in user ID
    static function get_id()
    {
        $ci = &get_instance();
        return $ci->tank_auth->get_user_id();
    }

    // Get logged in user ID
    static function logged_in()
    {
        $ci = &get_instance();
        $logged_in = ($ci->tank_auth->is_logged_in()) ? TRUE : FALSE;
        if(!$logged_in) redirect('login');
        return ;
    }

    // Get user information
    static function view_user($id)
    {
        return self::$db->where('id',$id)->get('users')->row();
    }

    /**
     * Check user if admin
     */
    static function is_admin() {
        $ci = &get_instance();
        return ($ci->tank_auth->get_role_id() == 'Admin') ? TRUE : FALSE;
    }

    /**
     * Check user if client
     */
    static function is_contributer() {
        $ci = &get_instance();
        return ($ci->tank_auth->get_role_id() == 'Contributer') ? TRUE : FALSE;
    }

    

    /**
     * Get user login information
     *
     * @return User data array
     */

    static function login_info($id) {
        return self::$db->where('id',$id)->get('users')->row();
    }

    

    // Get all users
    static function all_users(){
        return self::$db->get('users')->result();
    }

    /**
     * Display username or full name if exists
     */
    static function displayName($user = '') {
        if(!self::check_user_exist($user)) return '[MISSING USER]';

        return (self::profile_info($user)->name == NULL)
            ? self::login_info($user)->username
            : self::profile_info($user)->name;
    }

   


    /**
     * Get user role name e.g admin,staff etc
     */

    static function login_role_name() {
        $ci = &get_instance();
        return $ci->tank_auth->user_role($ci->tank_auth->get_role_id());
    }

    /**
     * Get user role name usind ID e.g admin,staff etc
     */

    static function get_role($user) {
        $ci = &get_instance();
        $id = self::login_info($user)->role_id;
        return $ci->tank_auth->user_role($id);
    }

    // Get all admin list
    static function admin_list(){
        return self::$db->where(array('role_id' => 1,'activated' => 1))->get('users')->result();
    }


    // Get staff list
    static function contributer_list(){
        return self::$db->where(array('role_id' => 3,'activated' => 1))->get('users')->result();
    }

    // Get roles
    static function get_roles(){
        return self::$db->get('roles')->result();
    }

    /**
     * Get user profile information
     */

    static function profile_info($id) {
        return self::$db->where('user_id',$id) -> get('user_profiles')->row();
    }


    static function user_log($user)
    {
        return self::$db->where('user',$user)->order_by('activity_date','DESC')->get('activities')->result();
    }

    // Get user avatar URL
    static function avatar_url($user = NULL) {
        if(!self::check_user_exist($user)) return base_url().'resource/avatar/default_avatar.jpg';

        if (config_item('use_gravatar') == 'TRUE' && self::profile_info($user)->use_gravatar == 'Y') {
            $user_email = self::login_info($user)->email;
            return Applib::get_gravatar($user_email);
        } else {
            return base_url().'resource/avatar/'.self::profile_info($user)->avatar;
        }
    }

    static function check_user_exist($user){
        return self::$db->where('id',$user)->get('users')->num_rows();
    }
    
    
/* public function Pkdelete_query($ids,$table){
        $this->db->where('id',$ids);
        $query = $this->db->delete($table);
        if($query == true){
            return 'true';
        } else {
            return 'false';
        }    
    }*/







}
?>