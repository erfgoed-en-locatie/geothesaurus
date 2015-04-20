<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Start extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function index(){

		$apiurl = "http://api.histograph.io/search?";
		$data['count'] = 0;
		$data['results'] = array();
		$q = "";

		if(isset($_GET['q'])){ 

			$q = $_GET['q'];
			$searchstring = 'name=' . urlencode('"' . $q . '"');
			$json = file_get_contents($apiurl . $searchstring );
			$result = json_decode($json,true);

			$data['count'] = count($result['features']);
			$data['results'] = $result['features'];
		}

		$data['q'] = $q;

		//print_r($data['results']);

		$this->load->view('header');
		$this->load->view('start', $data);
		$this->load->view('footer');

	}


}


/* end of file */