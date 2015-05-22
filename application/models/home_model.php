<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
	function __construct() {
        parent::__construct();
        //$this->load->library('common_model')
        $this->load->library('session');
        $this->load->helper('cookie');
     }
    
}