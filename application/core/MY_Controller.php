<?php    

class MY_Controller extends CI_Controller {

    public function __construct()
    {
        parent::__construct();  //make sure you extend the parent constructor

        //Your code:
        if( ! $this->session->userdata('lang') )
            $this->session->set_userdata('lang','french');
    }

}

?>
