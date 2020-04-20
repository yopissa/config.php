<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class loginc extends CI_Controller {

	public function index()
	{
        if($this->session->userdata('login') != TRUE ){
            redirect('loginc/login');
        } else {
            redirect('dashboardc');            
        }

	}

/*===========================================================================================================================================*/
/*===========================================================================================================================================*/

    public function login()
    {
        if($this->session->userdata('ID') != '' ){
            redirect('loginc');
        };

        $data=array(
        );      
        $this->load->view('pages/login');
    }

    function proses_login() {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        //query the database
        $result = $this->adminm->login($username, $password);
        if($result) {
            $sess_array = array();
            foreach($result as $row) {
                //create the session
                $sess_array = array(
                    'id_user' => $row->id_user,
                    'nm_user'=>$row->nm_user,
                    'username' => $row->username,
                    'password'=>$row->password,
                    'level_user' => $row->level_user,
                    'login'=>true,
                );
                //set session with value from database
                $this->session->set_userdata($sess_array);
                redirect('dashboardc','refresh');

            }
            return TRUE;
        } else {
            //jika validasi salah
            $this->session->set_flashdata('notif','Password atau Username salah');
            redirect('loginc/login','refresh');
            return FALSE;
        }
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('');
    }

}