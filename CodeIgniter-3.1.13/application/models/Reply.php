<?php
    class Reply extends CI_Model {
        /*  DOCU: This function returns all user replies for a product.
        Owner: Renier
        */
        public function get_reply_by_id($id)
        {
            $query = "SELECT replies.*, CONCAT(first_name, ' ', last_name) AS name FROM replies
                        INNER JOIN users ON replies.user_id = users.id
                        WHERE review_id = ? 
                        ORDER BY replies.created_at DESC";
            return $this->db->query($query, $id)->result_array();
        }
        /*  DOCU: This function inserts new reply to a user for a product.
        Owner: Renier
        */
        public function add_reply($review_id, $comment)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "INSERT INTO replies (user_id, review_id, comments, created_at) VALUES (?,?,?,?)";
            $values = array(
                $this->session->userdata('user')['id'],
                $review_id,
                $this->security->xss_clean($comment), 
                date("Y-m-d H:i:s")
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function checks if the description field is filled up.
        Owner: Renier
        */
        public function validate_reply()
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_message('required', 'Please fill in your reply');
            $this->form_validation->set_rules('reply', 'Reply', 'trim|required');

            if(!$this->form_validation->run()) 
            {
                return validation_errors();
            }
        }
    }