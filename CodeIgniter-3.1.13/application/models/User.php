<?php
    class User extends CI_Model {
        /*  DOCU: This function inserts new user info upon registration.
        Owner: Renier
        */
        public function create_user($user)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "INSERT INTO users (first_name, last_name, email, password, is_admin, created_at) VALUES (?,?,?,?,?,?)";
            $values = array(
                $this->security->xss_clean($user['first_name']), 
                $this->security->xss_clean($user['last_name']), 
                $this->security->xss_clean($user['email']), 
                $this->security->xss_clean(password_hash($user['password'], PASSWORD_BCRYPT)),
                empty($this->get_all_users()) ? 1 : 0,
                date("Y-m-d H:i:s")
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function updates the user info.
        Owner: Renier
        */
        public function update_user_profile($user)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "UPDATE users SET first_name=?, last_name=?, email=?, updated_at=? WHERE id=?";
            $values = array(
                $this->security->xss_clean($user['first_name']), 
                $this->security->xss_clean($user['last_name']), 
                $this->security->xss_clean($user['email']), 
                date("Y-m-d H:i:s"),
                $user['id']
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function updates the user password.
        Owner: Renier
        */
        public function update_user_password($user)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "UPDATE users SET password=?, updated_at=? WHERE id=?";
            $values = array(
                $this->security->xss_clean(password_hash($user['new_password'], PASSWORD_BCRYPT)),
                date("Y-m-d H:i:s"),
                $user['id']
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function retrieves user information filtered by email.
        Owner: Renier
        */
        public function get_user_by_email($email)
        {  
            $query = "SELECT * FROM Users WHERE email=?";
            return $this->db->query($query, $this->security->xss_clean($email))->row_array();
        }
        /*  DOCU: This function retrieves user information filtered by email.
        Owner: Renier
        */
        public function get_all_users()
        {  
            return $this->db->query("SELECT * FROM users")->row_array();
        }
        /*  DOCU: This function checks required input fields and if unique email.
        Owner: Renier
        */
        public function validate_registration($email) 
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');        
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
            
            $errors = array();
            if(!$this->form_validation->run()) 
            {
                $errors = $this->form_validation->error_array();
            }
            if($this->get_user_by_email($email))
            {
                $errors['email'] = "Email already taken.";
            }
            return $errors;
        }
        /*  DOCU: This function checks if all required fields were filled up.
        Owner: Renier
        */
        public function validate_signin() 
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
        
            if(!$this->form_validation->run()) 
            {
                return $this->form_validation->error_array();
            }
        }
        /*  DOCU: This function contains simple condition to match database record and user input in password.
        Owner: Renier
        */
        public function validate_signin_match($user, $password) 
        {
            if(isset($user) && password_verify($this->security->xss_clean($password), $user['password']))
            {
                return "success";
            }
            return "Incorrect email/password.";
        }
        /*  DOCU: This function checks if all required fields were filled up for profile update.
        Owner: Renier
        */
        public function validate_profile_update($email) 
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');        
        
            $errors = array();
            if(!$this->form_validation->run()) 
            {
                $errors = $this->form_validation->error_array();
            }
            if($this->get_user_by_email($email) && $this->session->userdata('user')['email'] != $this->security->xss_clean($email))
            {
                $errors['email'] = "Email already taken.";
            }
            return $errors;
        }
         /*  DOCU: This function checks if all required fields were filled up for password update.
        Owner: Renier
        */
        public function validate_password_update($user, $password) 
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('old_password', 'Old Password', 'required');    
            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]|differs[old_password]');    
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
            
            $errors = array();
            if(!$this->form_validation->run()) 
            {
                $errors = $this->form_validation->error_array();
            }
            if(!password_verify($this->security->xss_clean($password), $user['password']))
            {
                $errors['old_password'] = "Password is incorrect.";
            }
            return $errors;
        }
    }