<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//$this->output->enable_profiler();

	}
	public function register_user($post)
	{	
		// //email validations
		$this->form_validation->set_rules("name", "Name", "trim|required");
		$this->form_validation->set_rules("alias", "Alias", "trim|required");
		$this->form_validation->set_rules("email", "Email Address", "trim|required|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[8]");
		$this->form_validation->set_rules("password_rpt", "Password Confirmation", "trim|required|matches[password]");
		//end validations
		if($this->form_validation->run() === FALSE)
		{
			$this->session->set_flashdata("errors", validation_errors());
		}
		else
		{
		$values = array(
	 		'name'=>$post["name"], 
	 		'alias'=>$post["alias"],
	 		'email'=> $post["email"],
	 		'password'=>$post["password"],
	 	);
			$query = "INSERT INTO users (name, alias, email, password, created_at, updated_at) VALUES (?,?,?,?,NOW(),NOW())";
			
			$data = $this->db->query($query, $values);
			return $data;

		}
	}
	public function login_user($post)
	{
		//check against database
		$this->form_validation->set_rules("email", "Email Address", "trim|required");
		$this->form_validation->set_rules("password", "password", "trim|required");
		// //end validations
		if($this->form_validation->run() === FALSE) 
		{
			$this->session->set_flashdata("errors", validation_errors());
		}
		else 
		{
			// check if user info is in DB- 
			$values = array($post["email"],$post["password"]);
			$query = "SELECT * FROM users WHERE email = ? and password = ?";
			$user = $this->db->query($query, $values)->row_array();
		 	return $user;
			//remember to return the user or just return the query!!!
		
			// if it is save user in session
			if(empty($user))
			{
				$this->session->set_flashdata("errors", "email or password you entered is invalid");
				return false;
			}
			// //otherwise send back and show error
			else{
			$this->session->set_userdata("id", $user["id"]);
				return ;
			}
					
		}	
	
	}
	public function create_newTeam($post)
	{
		
		$values = array('team'=>$post['team']);
		$query = "INSERT INTO teams (name, created_at, updated_at) VALUES (?,NOW(),NOW())";
		$this->db->query($query, $values);
		$query2 = "SELECT * FROM teams ORDER BY id DESC LIMIT 1";
		$team_id = $this->db->query($query2)->result_array();
		
		$query3 = "INSERT INTO teams_has_users (team_id, user_id) VALUES (?,?)";
		$data = array('team_id' => $team_id[0]['id'], 'user_id' => $this->session->userdata('user_id'));
		
		$this->db->query($query3, $data);

	}
	public function all()
  	{	
  		$query = "SELECT * FROM teams";
		return $this->db->query($query)->result_array();
	}
	public function all_by_id()
	{	
		$user = $this->session->userdata('user_id');
		return $this->db->query("SELECT  team_id, user_id, users.id, users.name, teams.name FROM users JOIN teams_has_users on (users.id = ?) JOIN teams where team_id = teams.id AND user_id = users.id;",($user))->result_array();
	}
	public function remove($id)
	{
		$this->db->query("DELETE FROM teams_has_users WHERE team_id = ?", ($id) );
		$this->db->query("DELETE FROM teams WHERE id = ?", ($id) );
		
	}


		


}

