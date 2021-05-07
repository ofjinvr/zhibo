<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


class Category_model extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
   

}