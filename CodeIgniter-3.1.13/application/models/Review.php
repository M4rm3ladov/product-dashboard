<?php
    class Review extends CI_Model {
        /*  DOCU: This function returns all user reviews for a product.
        Owner: Renier
        */
        public function get_reviews_by_id($id)
        {
            $query = "SELECT reviews.*, CONCAT(first_name, ' ', last_name) AS name FROM reviews
                        INNER JOIN users ON reviews.user_id = users.id
                        WHERE product_id = ? 
                        ORDER BY reviews.created_at DESC";
            return $this->db->query($query, $id)->result_array();
        }
        /*  DOCU: This function inserts new review of a user for a product.
        Owner: Renier
        */
        public function add_review($product_id, $comment)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "INSERT INTO reviews (user_id, product_id, comments, created_at) VALUES (?,?,?,?)";
            $values = array(
                $this->session->userdata('user')['id'],
                $product_id,
                $this->security->xss_clean($comment), 
                date("Y-m-d H:i:s")
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function checks if the description field is filled up.
        Owner: Renier
        */
        public function validate_review()
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_message('required', 'Please fill in your review');
            $this->form_validation->set_rules('review', 'Review', 'trim|required');

            if(!$this->form_validation->run()) 
            {
                return validation_errors();
            }
        }
    }