<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /*public function authenticate($email, $password) {
        $query = $this->db->get_where('user', array('email' => $email, 'password' => $password));

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false; 
        }
    }*/

    public function insert_user($data) {
        // Insert user data into the 'users' table
        $this->db->insert('user', $data);
    }




 
    // In your login_model
    public function authenticate($email, $password) {

        $query = $this->db->get_where('user', array('email' => $email, 'password' => $password));

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        else
        {
            return false; 
        }
    }

public function getAccessData() {
    // Assuming you have a table called 'files' with columns 'user', 'file_name', and 'access_level'
    $query = $this->db->get('user');
    return $query->result();
}


public function getRecordByEmail($email) {
    $this->db->where('email', $email);
    $query = $this->db->get('user');
    return $query->row();
}
public function getRecordByName($name) {
    $this->db->where('name', $name);
    $query = $this->db->get('user');
    return $query->row();
}



public function insert_data($data) {
        
    $this->db->insert('user', $data);
    return ($this->db->affected_rows() > 0) ? true : false;
}
    
public function update_image($id, $image_data) {
    $data = array(
        'pic' => $image_data
    );
    $this->db->where('id', $id);
    $this->db->update('user', $data);
}
public function getUserData($userId) {
    // Fetch user data from the database based on the correct column name
    $userData = $this->db->get_where('user', ['id' => $userId])->row();

    return $userData;
}

    public function changepswd($email, $newPassword) 
    {
        $this->db->where('email', $email);
       $query = $this->db->get('user');

       if ($query->num_rows() > 0)
       {
           $userData = $query->row();
           $userData->password = $newPassword;

           $this->db->where('email', $email);
           $this->db->update('user', ['password' => $newPassword]);

           return true; 
       } 
       else 
       {
           return false;
       }
    }

    public function emailExists($email)
    {
        // Assume your users table is named 'users'
        $this->db->where('email', $email);
        $query = $this->db->get('user');

        return $query->num_rows() > 0;
    }

 
    public function get_user_details($id)
    {
        // Assuming you have a 'users' table with columns 'id', 'name', etc.
        $query = $this->db->get_where('user', array('id' => $id));

        return $query->row(); // Returns a single row as an object
    }

    public function getUserByEmail($email)
    {
       return  $this->db->where('email', $email)->get('user')->row();
    }
 
 
    public function saveFileData($user_id, $file_name)
{
    $data = array(
        'file_name' => $file_name,
        
    );

    $this->db->where('id', $user_id);
    $this->db->update('user', $data);

    return $this->db->affected_rows() > 0;
}

    
    public function getData() 
    {
        $query = $this->db->get('user');
        return $query->result();
    }

    public function file_data() {
        $query = $this->db->get('user');
        return $query->result_array();
    }
    public function save_user($data) 
    {
        $this->db->insert('user', $data);
    }

    public function insert_file($id,$file){
        $data = array(
            'files' => $file
        );
        $this->db->where('id', $id);
        $this->db->update('data_table', $data);
    }

    public function get_user() 
    {
        $query = $this->db->get('user');
        return $query->result_array();
    }
    public function getdata_by_id($id){
        $c=['id'=>$id];
        $query = $this->db->get_where('user', $c);
        return $query->row();
    }

    public function get_user_by_id($id) 
    {
        $query = $this->db->get_where('user', array('id' => $id));
        return $query->row_array();
    }

    public function update_user($id, $data) 
    {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    public function delete_user($id) 
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
    }

    public function get_user_data($user_id) 
    {
        $query = $this->db->get_where('user', array('id' => $user_id));
        return $query->row_array();
    }

    public function update_profile($new_email) 
    {
        $data = array(
            'email' => $new_email,
        );

        $this->db->where('id', $this->session->userdata('person_id'));
        $this->db->update('user', $data);
    }

    public function is_email_duplicate($email) 
    {
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }
    public function getTotalUsers() {
        $this->db->from('user');
        $total_users = $this->db->count_all_results();
        return $total_users;
    }

    public function getTotalUsersByRole($role)
    {
        return $this->db
            ->where('role', $role)
            ->count_all_results('user'); 
    }

    public function getTotalUsersByGender($gender)
    {
        $this->db->where('gender', $gender);
        return $this->db->count_all_results('user'); // Replace 'your_users_table' with your actual table name
    }

   // In your login_model
public function getHRData()
{
    // Assuming 'user_type' is the field that determines whether a user is HR
    $this->db->where('access', 'HR');
    $query = $this->db->get('user'); // Replace 'your_table_name' with the actual table name

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return false;
    }
}

public function getManagerData()
{
    $this->db->where('access', 'manager');
    $query = $this->db->get('user');

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return false;
    }
}

public function getDeveloperData()
{
    $this->db->where('access', 'senior developer');
    $query = $this->db->get('user'); 

    if ($query->num_rows() > 0) {
        return $query->result();
    } else {
        return false;
    }
}

public function insert_logs($data) {
        
    $this->db->insert('user_activity_log', $data);
    return ($this->db->affected_rows() > 0) ? true : false;
}

public function getLogData() 
    {
        $this->db->order_by('timestamp', 'DESC');
        $query = $this->db->get('user_activity_log');
        return $query->result();
    }

    public function pages() {
        
        $query = $this->db->get('pages');
        return $query->result();
    }

    public function user_pages()
    {
        $query = $this->db->get('user_pages');
        return $query->result();
    }

    public function update_page($id, $data) 
    {
        $this->db->where('id', $id);
        $this->db->update('pages', $data);
    }

    public function user_update_page($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('user_pages', $data);
    }

    public function get_dict_name($name) {
        $this->db->where('side_menu', $name);
        $query = $this->db->get('pages');
        
        return $query->row();
    }

    public function user_get_dict_name($name)
    {
        $this->db->where('side_menu', $name);
        $query = $this->db->get('user_pages');

        return $query->row();
    }

    public function color() {
        
        $query = $this->db->get('theme');
        return $query->result();
    }

    public function update_theme($role,$title,$logo,$footer){
        $data = array(
            'color' => $role,
            'title'=>$title,
            'logo'=>$logo,
            'footer'=>$footer
        );
        $this->db->where('id', "1");
        $this->db->update('theme', $data);
    }
    

public function remove_profile($id) {
    $data = array('pic' => 'default.jpg');
    $this->db->where('id', $id);
    $this->db->update('user', $data); 
}


public function admin_menu() {

    $query = $this->db->get('admin_menu');
    return $query->result();
}


public function get_user_documents($id) {
    $this->db->where('id', $id);

    return $this->db->get('user')->result();
}


public function select_pages() {
        
    $query = $this->db->get('select_pages');
    return $query->result();
}
public function getRecords() {
    // Assuming you have a table named 'your_table_name' in your database
    // Adjust the table name and fields based on your database schema
    $query = $this->db->get('user');
    return $query->result();
}

public function insertImportedData($importedData) {
    // Assuming $importedData is a 2D array representing rows and columns of the imported data
    foreach ($importedData as $row) {
        $data = array(
            'name' => $row[0],
            'file_name' => $row[1],
            'email' => $row[2],
            'role' => $row[3],
            'access' => $row[4],
            // Add other columns as needed
        );

        // Insert data into the database
        $this->db->insert('user', $data);
    }
}
}
