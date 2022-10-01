<?php
    class Dashboards extends CI_Controller {
        public function index()
        {
            if(!empty($this->session->userdata('user')['id']) && $this->session->userdata('user')['is_admin'] == 0)
            {
                redirect('dashboard');
            }
            else if(!empty($this->session->userdata('user')['id']) && $this->session->userdata('user')['is_admin'] == 1)
            {
                redirect('dashboard/admin');
            }
            redirect('users');
        }
        public function admin_dashboard()
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }
            
            if(!isset($_SERVER['HTTP_REFERER']) && !empty($this->session->userdata('user')['id']) && $this->session->userdata('user')['is_admin'] == 0)
            {
                redirect('dashboard');
            }
            $data['products'] = $this->product->get_all_products();
            $this->load->view('dashboards/admin_dashboard', $data);
        }
        public function user_dashboard()
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }

            if(!isset($_SERVER['HTTP_REFERER']) && !empty($this->session->userdata('user')['id']) && $this->session->userdata('user')['is_admin'] == 1)
            {
                redirect('dashboard/admin');
            }
            $data['products'] = $this->product->get_all_products();
            $this->load->view('dashboards/user_dashboard', $data);
        }
    }