<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logins extends CI_Controller {



	public function __construct()
	{
		parent::__construct();
		$this->load->model("Login");
		//$this->output->enable_profiler();
	}

	public function index()
	{
		$this->load->view('main');
	}
	public function register_user()
	{	
		
		$logins = $this->Login->register_user($this->input->post());
		

		$this->session->set_flashdata("whoops", "<h1>Thanks, Login now</h1>");
		redirect("/");
	}
	public function login_user()
	{
		$this->load->model("Login");//loads the model from the data base 
		$logins = $this->Login->login_user($this->input->post());//sets $logins equal to the information in the db that matches the inputs.
		if ($logins){

			// 	var_dump($redbelts);
			// die();
			$this->session->set_userdata('name', $logins['name']);//sets $logins in session to display the user's name
			$this->session->set_userdata('user_id', $logins['id']);
			//sets in session the user_id which is the logins id
			$id = $this->session->userdata('user_id');
			//sets $id to be equal to user_id // allows easier access in all_favorites
			$teams = $this->Login->all();
			$my_teams = $this->Login->all_by_id();
			//sets $teams to be all the teams data in the model 
			
			$this->load->view('quotes', array('teams'=>$teams, 'my_teams'=>$my_teams));
			//loads the view page with the three $variables available for display
		}
		else {
			$this->session->set_flashdata("whoops", "whoops, try again");
			redirect ("/");
		}
	}
	public function create_newTeam(){
		$post = $this->input->post();
		$this->load->model("Login");
		$this->Login->create_newTeam($post);
		$teams = $this->Login->all();
	
		redirect('/showNewTeam');

	}
	public function showNewTeam(){
		$my_teams = $this->Login->all_by_id();
		// var_dump($my_teams);
		// die();
		$teams = $this->Login->all();
	    $this->load->view('quotes', array('teams'=>$teams, 'my_teams'=>$my_teams));
	}	
	public function remove(){
		$id = $this->input->post('id');
		$this->Login->remove($id);
		$id = $this->session->userdata('user_id');
		$teams = $this->Login->all();
		$my_teams = $this->Login->all_by_id();
		
		$this->load->view('quotes', array('teams'=>$teams, 'my_teams'=>$my_teams));

	}
	public function log_out()
	{
		$this->session->sess_destroy();
		redirect ("/");
	}


}