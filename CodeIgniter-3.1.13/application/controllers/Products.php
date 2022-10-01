<?php
    class Products extends CI_Controller {
        /*  DOCU: This function is triggered to display create new products if there's a user session else redirect to sign in page.
            Owner: Renier
        */
        public function new()
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }
            $this->load->view('products/new');
        }
        /*  DOCU: This function is triggered to edit product if there's a user session else redirect to sign in page.
            Owner: Renier
        */
        public function edit($id)
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }
            $data['product'] = $this->product->get_product_by_id($id);
            $this->load->view('products/edit', $data);
        }
        /*  DOCU: This function is triggered to display all products if there's a user session else redirect to sign in page.
            Owner: Renier
        */
        public function show($id)
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }
            $data['product'] = $this->product->get_product_by_id($id);
            $reviews = $this->review->get_reviews_by_id($id);
            for($index = 0 ; $index < count($reviews); $index++)
            {
                $data['reviews'][$index] = $reviews[$index];
                $data['reviews'][$index]['replies'] = $this->reply->get_reply_by_id($reviews[$index]['id']);
            }
            $this->load->view('products/show', $data);
        }
        /*  DOCU: This function is triggered to remove a product if there's a user session else redirect to sign in page.
            Owner: Renier
        */
        public function remove($id)
        {
            if(empty($this->session->userdata('user')['id']))
            {
                redirect('users');
            }
            $this->product->delete_product($id);
            redirect('dashboards');
        }
        /*  DOCU: This function is triggered when the create button is clicked. 
        This validates the required form inputs. 
        If no problem occured, product information will be stored in database 
        and said user will be redirected to new.
        Owner: Renier
        */
        public function process_product_create() 
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect('products/new');
            }

            $result = $this->product->validate_product($this->input->post());
            if(!empty($result))
            {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
                
                redirect('products/new');
            }
            
            $this->product->create_product($this->input->post());

            $view_data['success'] = "Product successfully Created!";
            $this->session->set_flashdata($view_data);

            redirect('products/new');
        }
        /*  DOCU: This function is triggered when the create button is clicked. 
        This validates the required form inputs. 
        If no problem occured, product information will be stored in database 
        and said user will be redirected to edit.
        Owner: Renier
        */
        public function process_product_update($id) 
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect("products/edit/{$id}");
            }

            $result = $this->product->validate_product($this->input->post());
            if(!empty($result))
            {
                $view_data['errors'] = $result;
                $view_data['values'] = $this->input->post();
                $this->session->set_flashdata($view_data);
                
                redirect("products/edit/{$id}");
            }
            
            $this->product->update_product($id, $this->input->post());

            $view_data['success'] = "Product successfully Updated!";
            $this->session->set_flashdata($view_data);

            redirect("products/edit/{$id}");
        }
        /*  DOCU: This function is triggered when the post button is clicked. 
        This validates the required form input. 
        If no problem occured, review message will be stored in database 
        and said user will be redirected to show.
        Owner: Renier
        */
        public function process_add_review($id)
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect("products/show/{$id}");
            }
            
            $result = $this->review->validate_review();
            if(!empty($result))
            { 
                $this->session->set_flashdata('review_error', $result);
                redirect("products/show/{$id}");
            }
            
            $this->review->add_review($id, $this->input->post('review'));
            redirect("products/show/{$id}");
        }
        /*  DOCU: This function is triggered when the post button is clicked. 
        This validates the required form input. 
        If no problem occured, reply message will be stored in database 
        and said user will be redirected to show.
        Owner: Renier
        */
        public function process_add_reply($product_id, $review_id)
        {
            if(!isset($_SERVER['HTTP_REFERER']))
            {
                redirect("products/show/{$product_id}");
            }
            
            $result = $this->reply->validate_reply();
            if(!empty($result))
            { 
                $this->session->set_flashdata('reply_error', $result);
                redirect("products/show/{$product_id}");
            }

            $this->reply->add_reply($review_id, $this->input->post('reply'));
            redirect("products/show/{$product_id}");
        }
    }