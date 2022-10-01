<?php
    class Users extends CI_Controller {
        public function index()
        {    
            $this->dashboard_redirect();      
            redirect('signin');     
        }
        /*  DOCU: This function is triggered to redirect to dashboard if user is logged in
            Owner: Renier
        */
        private function dashboard_redirect()
        {
            if(!empty($this->session->userdata('user')['id']))
            {
               redirect('dashboards');
            }
        }
        /*  DOCU: This function is triggered to display sign in page if there's no user session yet
            Owner: Renier
        */
        public function signin()
        {
            $this->dashboard_redirect();
            $this->load->view('users/signin');
        }
        /*  DOCU: This function is triggered to display registration page if there's no user session yet.
            Owner: Renier
        */
        public function register() 
        {       
            $this->dashboard_redirect();
            $this->load->view('users/register');
        }
        /*  DOCU: This function is triggered to display profile edit page if there's a user session else redirect to sign in page.
            Owner: Renier
        */
        public function edit()
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('signin');
            }
            $this->load->view('users/edit');
        }
        /*  DOCU: This function logs out the current user then goes to sign in page.
            Owner: Renier
        */
        public function signout() 
        {
            $this->session->sess_destroy();
            redirect('signin');   
        }
        /*  DOCU: This function is triggered when the sign in button is clicked. 
        This validates the required form inputs and if user password matches in the database by given email.
        If no problem occured, user will be redirected to signin.
        Owner: Renier
        */
        public function process_signin() 
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect('signin');
            }
            
            $result = $this->user->validate_signin();
            if(isset($result)) {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
            
                redirect('signin');
            } 
 
            $email = $this->input->post('email');
            $user = $this->user->get_user_by_email($email);
            $result = $this->user->validate_signin_match($user, $this->input->post('password'));
            
            if($result == "success") 
            {
                $user_data = $user;
                $session_data = array(
                    'user' => array(
                                'id' => $user_data['id'],
                                'first_name' => $user_data['first_name'],
                                'last_name' => $user_data['last_name'],
                                'email' => $user_data['email'],
                                'is_admin' => $user_data['is_admin'],
                            )
                );
                $this->session->set_userdata($session_data);

                $this->dashboard_redirect();
            }
            $view_data['errors']['email'] = $result;
            $view_data['values'] = $this->input->post();
            $this->session->set_flashdata($view_data);

            redirect('signin');
        }
        /*  DOCU: This function is triggered when the register button is clicked. 
        This validates the required form inputs then checks if the email is already taken. 
        If no problem occured, user information will be stored in database 
        and said user will be redirected to register.
        Owner: Renier
        */
        public function process_registration() 
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect('signin');
            }
            $result = $this->user->validate_registration($this->input->post('email'));
            
            if(!empty($result))
            {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
                
                redirect('register');
            }

            $form_data = $this->input->post();
            $this->user->create_user($form_data);

            $user_data = $this->user->get_user_by_email($form_data['email']);
            $session_data = array(
                'user' => array(
                            'id' => $user_data['id'],
                            'first_name' => $user_data['first_name'],
                            'last_name' => $user_data['last_name'],
                            'email' => $user_data['email'],
                            'is_admin' => $user_data['is_admin']
                        )
            );
            $this->session->set_userdata($session_data);
            
            $this->dashboard_redirect();
        }
        /*  DOCU: This function is triggered when the edit information save button is clicked in profile. 
        This validates the required form inputs then checks if the email is already taken. 
        If no problem occured, user information will be stored in database 
        and said user will be redirected to edit.
        Owner: Renier
        */
        public function process_profile_update()
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect('signin');
            }
            $email = $this->input->post('email');
            $result = $this->user->validate_profile_update($email);
            
            if(!empty($result))
            {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
                
                redirect('users/edit');
            }

            $form_data = $this->input->post();
            $form_data['id'] = $this->session->userdata('user')['id'];
            $this->user->update_user_profile($form_data);

            $user_data = $this->user->get_user_by_email($form_data['email']);
            $session_data = array(
                'user' => array(
                            'id' => $user_data['id'],
                            'first_name' => $user_data['first_name'],
                            'last_name' => $user_data['last_name'],
                            'email' => $user_data['email'],
                            'is_admin' => $user_data['is_admin'],
                        )
            );
            $this->session->set_userdata($session_data);

            $view_data['success']['profile'] = "Profile successfully Updated!";
            $this->session->set_flashdata($view_data);
            
            redirect('users/edit');
        }
        /*  DOCU: This function is triggered when the change password save button is clicked in profile. 
        This validates the required form inputs then checks if the email is already taken. 
        If no problem occured, user information will be stored in database 
        and said user will be redirected to edit.
        Owner: Renier
        */
        public function process_password_update()
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect('signin');
            }
            $user = $this->user->get_user_by_email($this->session->userdata('user')['email']);
            $password = $this->input->post('old_password');
            $result = $this->user->validate_password_update($user, $password);
            
            if(!empty($result))
            {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
                
                redirect('users/edit');
            }

            $form_data['new_password'] = $this->input->post('new_password');
            $form_data['id'] = $this->session->userdata('user')['id'];
            $this->user->update_user_password($form_data);

            $view_data['success']['password'] = "Password successfully Updated!";
            $this->session->set_flashdata($view_data);
            
            redirect('users/edit');
        }
    }