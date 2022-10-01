<?php
    class Product extends CI_Model {
        /*  DOCU: This function returns all products.
        Owner: Renier
        */
        public function get_all_products() {
            $query = "SELECT products.*, sum(order_quantity) AS quantity_sold FROM products
                        LEFT JOIN orders ON products.id = orders.product_id
                        LEFT JOIN users ON users.id = orders.user_id
                        GROUP BY name";

            return $this->db->query($query)->result_array();
        }
        /*  DOCU: This function returns all products.
        Owner: Renier
        */
        public function get_product_by_id($id) {
            $query = "SELECT products.*, sum(order_quantity) AS quantity_sold FROM products
                        LEFT JOIN orders ON products.id = orders.product_id
                        LEFT JOIN users ON users.id = orders.user_id
                        WHERE products.id=? 
                        GROUP BY name";
            
            return $this->db->query($query, $this->security->xss_clean($id))->row_array();
        }
        /*  DOCU: This function returns all orders by product id.
        Owner: Renier
        */
        public function get_orders_by_id($product_id)
        {
            $query = "SELECT * FROM orders WHERE orders.product_id=?";
            return $this->db->query($query, $product_id)->result_array();
        }
        /*  DOCU: This function inserts new product info upon save.
        Owner: Renier
        */
        public function create_product($product)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "INSERT INTO products (name, description, price, product_count, created_at) VALUES (?,?,?,?,?)";
            $values = array(
                $this->security->xss_clean($product['name']), 
                $this->security->xss_clean($product['description']), 
                $this->security->xss_clean($product['price']),
                $this->security->xss_clean($product['count']), 
                date("Y-m-d H:i:s")
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function updates the product info.
        Owner: Renier
        */
        public function update_product($id, $product)
        {
            date_default_timezone_set('Asia/Manila');
            $query = "UPDATE products SET name=?, description=?, price=?, product_count=?, updated_at=? WHERE id=?";
            $values = array(
                $this->security->xss_clean($product['name']), 
                $this->security->xss_clean($product['description']), 
                $this->security->xss_clean($product['price']),
                $this->security->xss_clean($product['count']),
                date("Y-m-d H:i:s"),
                $id
            ); 
            
            return $this->db->query($query, $values);
        }
        /*  DOCU: This function deletes a product.
        Owner: Renier
        */
        public function delete_product($id)
        {
            if(empty($this->get_orders_by_id($id)))
            {
                $query = "DELETE FROM products WHERE id=?";
                return $this->db->query($query, $id);
            }
        }
        /*  DOCU: This function checks required input fields.
        Owner: Renier
        */
        public function validate_product() 
        {
            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'trim|required');        
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('count', 'Inventory Count', 'trim|required|is_natural');
            
            if(!$this->form_validation->run()) 
            {
                return $this->form_validation->error_array();
            }
        }   
    }