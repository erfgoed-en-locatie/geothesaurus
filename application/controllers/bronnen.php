<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bronnen extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function index(){

		
		
		$searchstring = 'datasets/';
		$json = file_get_contents($this->config->item('api_url') . $searchstring );

		$result = json_decode($json,true);

		//print_r($result);
		/*
		$fields = array("title", 
						"description", 
						"edits", 
						"editor", 
						"license", 
						"author", 
						"website", 
						"sourceCreationDate"
						);
		for($i=0; $i<count($result); $i++) {
			foreach($fields as $field){
				
				if(!isset($result[$i][$field])){
					$result[$i][$field] = "";
				}
				
			}
		}
		*/

		$searchstring = 'stats/queries/types-per-dataset';
		$json = file_get_contents($this->config->item('api_url') . $searchstring );

		$types = json_decode($json,true);

		$data['types'] = array();
		foreach ($types as $k => $type) {
			$data['types'][$type['dataset']][$type['type']] = $type['count'];
		}

		foreach ($result as $key => $row) {
		    $titles[$key]  = $row['title'];
		}

		array_multisort($titles, SORT_ASC,$result);
		$data['sources'] = $result;

		
		$this->load->view('header');
		$this->load->view('bronnen', $data);
		$this->load->view('footer');

	}


}


/* end of file */