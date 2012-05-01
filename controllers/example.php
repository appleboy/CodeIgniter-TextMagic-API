<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // load library
        $this->load->library('textmagic');
    }
}
/* End of file example.php */
/* Location: ./application/controllers/example.php */
