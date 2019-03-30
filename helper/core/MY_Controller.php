<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->library('Twig', NULL, 'view');
        
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */