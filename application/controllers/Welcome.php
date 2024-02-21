<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set('Asia/Kolkata');
require_once APPPATH. 'libraries/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use Facebook\FacebookApp;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use PhpOffice\PhpSpreadsheet\IOFactory;

class Welcome extends CI_Controller 
{

	public function __construct() 
	{			
		parent::__construct();
        $this->load->helper('form');
        $this->load->library('form_validation');			
		$this->load->model('login_model');
		$this->load->library('session');
		$this->load->library('email');
		$this->load->library('upload');
		$this->load->database(); 
		$this->load->helper('download'); // Make sure the download helper is loaded
		 		                           
	}
	public function register_page()
	{
		$this->load->view('register_page');
	}

	/*public function process_registration() {
		// Form data
		$name = $this->input->post('name');
		$father_name = $this->input->post('father_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repeatPassword = $this->input->post('Repeat_Password'); // Fix variable name
	
		// Password validation
		$passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/';
		if (!preg_match($passwordRegex, $password)) {
			// Password does not meet the criteria
			$this->session->set_flashdata('error', 'Password should contain at least one capital letter, one number, and one special character.');
			redirect('welcome/register_page'); // Redirect to registration page
		}


	
		// Check if the repeat password matches the original password
		if ($password !== $repeatPassword) {
			$this->session->set_flashdata('error', 'Repeat password should match the original password.');
			redirect('welcome/register_page'); // Redirect to registration page
		}
	
		// Form data
		$data = array(
			'name' => $name,
			'father_name' => $father_name,
			'email' => $email,
			'password' => $password,
		);
	
		// Insert data into the database
		$this->login_model->insert_user($data);
	
		// Redirect to login page or any other desired page
		redirect('welcome/index');
	}*/

	public function process_registration() {
		// Form data
		$name = $this->input->post('name');
		$father_name = $this->input->post('father_name');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repeatPassword = $this->input->post('Repeat_Password'); // Fix variable name
		
	
	
		// Password validation
		$passwordRegex = '/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+]).{8,}$/';
		if (!preg_match($passwordRegex, $password)) {
			// Password does not meet the criteria
			$this->session->set_flashdata('error', 'Password should contain at least one capital letter, one number, and one special character.');
			redirect('welcome/register_page'); // Redirect to registration page
		}
	
		// Check if the repeat password matches the original password
		if ($password !== $repeatPassword) {
			$this->session->set_flashdata('error', 'Repeat password should match the original password.');
			redirect('welcome/register_page'); // Redirect to registration page
		}
	
		// Form data
		$data = array(
			'name' => $name,
			'father_name' => $father_name,
			'email' => $email,
			'password' => $password,
		);
	
		// Insert data into the database
		$this->login_model->insert_user($data);
	
		// Redirect to login page or any other desired page
		redirect('welcome/index');
	}
	
 
	//login page
	public function index()
	{
		if ($this->session->userdata('admin_logged')) 
		{
			redirect('welcome/dashboard');
		} 
		elseif ($this->session->userdata('user_logged')) 
		{
			redirect('welcome/dashboard');
		} 
		else 
		{
			$this->load->view('login');
		}
	}
	//google login function
	public function google_login()
    {
       // echo 'hai';
	   require_once APPPATH. 'libraries/vendor/autoload.php';
	   
		$client = new GoogleClient();
		$client->setApplicationName('TW Google Login');
		$client->setClientId('330310567174-e4qo347n90c8etb8f7d81kdbqh5ahq46.apps.googleusercontent.com');
		$client->setClientSecret('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');
		$client->setRedirectUri('http://localhost/admin/welcome/google_login');
		$client->addScope(['https://www.googleapis.com/auth/userinfo.email','https://www.googleapis.com/auth/userinfo.profile']);
		// echo 'hai';

		if($code = $this->input->get('code'))
		{
			//echo 'working here';
			$token = $client->fetchAccessTokenWithAuthCode($code);
			$client->setAccessToken($token);
			$oauth = new Oauth2($client);
			
			$user_info = $oauth->userinfo->get();
			//echo print_r($user_info);die();
			$data['name'] = $user_info->name;
			$data['email'] = $user_info->email;
			$data['pic'] = $user_info->picture;
			

			$data['password'] ='123';


			$this->session->set_userdata('email',$data['email']);
			$this->session->set_userdata('password',$data['password']);
			// $this->session->set_userdata('id', $user->id);
			
			if($user = $this->login_model->getRecordByEmail($user_info->email))
			{
				// print_r($user);

			}
			else
			{
				//echo 'no';
				$this->login_model->insert_data($data);				
			}
		
			redirect('welcome/check');

		}
		else
		{
			$url = $client->createAuthUrl();
			header('Location:'.filter_var($url,FILTER_SANITIZE_URL));
		}
    }
	//logout function
	public function logout() 
	{
		
		session_destroy();
		//redirect('welcome/index');
		$this->load->view('login');
	}
	//login checking function
	/*public function check()
	{
		
		if(isset($_POST['login']))
		{
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$user = $this->login_model->authenticate($email, $password);

			
		} 
		elseif ($this->session->userdata('fb_login')) 
		{
			// Handle Facebook login
			$user = $this->session->userdata('fb_login');
			$this->session->unset_userdata('fb_login'); // Remove fb_login from session
		}
		else 
		{
			//google login
			$email = $this->session->userdata('email');
			$password = $this->session->userdata('password');
			$user = $this->login_model->authenticate($email, $password);
			
		}

		if ($user) 
		{
			$this->session->set_userdata('val2', $user);
			$this->session->set_userdata('admin_', $user->name);
			$this->session->set_userdata('id', $user->id);
			$this->session->set_userdata('user_role', $user->role);

			if ($user->role == 'admin') 
			{
				// Admin login
				$this->session->set_userdata('admin_logged', true);
				$this->session->set_userdata('logged_inn_as', 'admin');
				$this->session->set_userdata('person_id', $user->id);

				// $this->load->view('header');
				// $this->load->view('dashboard');
				// $this->load->view('footer');
				redirect('welcome/dashboard');
			} 
			else 
			{
				// User login
				$this->session->set_userdata('user_logged', true);
				$this->session->set_userdata('person_id', $user->id);

				// $this->load->view('user_header');
				// $this->load->view('user_dashboard');
				// $this->load->view('footer');
				redirect('welcome/dashboard');
			}
		} 
		else 
		{
			// Handle unsuccessful authentication
			$this->load->view('notfoundpage');
		}
	}*/


	public function check()
	{
		if (isset($_POST['login'])) {
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			// Validate reCAPTCHA
			$recaptchaResponse = $this->input->post('g-recaptcha-response');
			$recaptchaSecretKey = '6LdCBGApAAAAAEdldykrcNHO_ERR_D0wL3UchVpn'; // Replace with your reCAPTCHA secret key

			$recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
			$recaptchaVerifyData = array(
				'secret' => $recaptchaSecretKey,
				'response' => $recaptchaResponse
			);

			$recaptchaVerifyOptions = array(
				'http' => array(
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'method' => 'POST',
					'content' => http_build_query($recaptchaVerifyData),
				),
			);

			$recaptchaVerifyContext = stream_context_create($recaptchaVerifyOptions);
			$recaptchaVerifyResult = file_get_contents($recaptchaVerifyUrl, false, $recaptchaVerifyContext);
			$recaptchaVerifyResult = json_decode($recaptchaVerifyResult);

			if (!$recaptchaVerifyResult->success) {
				// Captcha verification failed
				$this->session->set_flashdata('error', 'reCAPTCHA verification failed. Please try again.');
				redirect('welcome/index');
				return;
			}

			// Continue with the rest of your authentication logic
			$user = $this->login_model->authenticate($email, $password);
 
		} elseif ($this->session->userdata('fb_login')) {
			// Handle Facebook login
			$user = $this->session->userdata('fb_login');
			$this->session->unset_userdata('fb_login'); // Remove fb_login from session

		} else {
			//google
			$email = $this->session->userdata('email');
			$password = $this->session->userdata('password');
			$user = $this->login_model->authenticate($email, $password);
		}

		if ($user) {
			$this->session->set_userdata('val2', $user);
			$this->session->set_userdata('admin_', $user->name);
			$this->session->set_userdata('id', $user->id);
			$this->session->set_userdata('user_role', $user->role);

			if ($user->role == 'admin') {
				// Admin login
				$this->session->set_userdata('admin_logged', true);
				$this->session->set_userdata('logged_inn_as', 'admin');
				$this->session->set_userdata('person_id', $user->id);

				redirect('welcome/dashboard');

			} else {
				// User login
				$this->session->set_userdata('user_logged', true);
				$this->session->set_userdata('person_id', $user->id);

				redirect('welcome/dashboard');
			}

		} else {
			// Handle unsuccessful authentication
			$this->session->set_flashdata('error', 'Invalid email or password. Please try again.');
				$this->load->view('notfoundpage');
		}
	}
	//dashboard function
	public function dashboard()
	{
		$this->session->unset_userdata('admin_logged');
		$this->session->unset_userdata('user_logged');
		$user_role = $this->session->userdata('user_role');

		if ($user_role && $user_role == 'admin') 
		{
			// Get total users
			$totalUsers = $this->login_model->getTotalUsers();

			// Get total users by role
			$totalAdminUsers = $this->login_model->getTotalUsersByRole('admin');
			$totalManagerUsers = $this->login_model->getTotalUsersByRole('Manager');
			$totalITSupportUsers = $this->login_model->getTotalUsersByRole('IT Support');
			$totalHRUsers = $this->login_model->getTotalUsersByRole('HR');
			$totalSeniorDeveloperUsers =  $this->login_model->getTotalUsersByRole('senior developer');
			$totalAccountantUsers  = $this->login_model->getTotalUsersByRole('accountant');
			$totalTraineeUsers = $this->login_model->getTotalUsersByRole('Trainee');
			$maleUsers = $this->login_model->getTotalUsersByGender('Male');
        	$femaleUsers = $this->login_model->getTotalUsersByGender('Female');
			$otherGenderUsers = $this->login_model->getTotalUsersByGender('Others');

			// Add similar calls for other roles

			// Pass the total users and role-wise counts to the view
			$data = array(
				'totalUsers' => $totalUsers,
				'totalAdminUsers' => $totalAdminUsers,
				'totalManagerUsers' => $totalManagerUsers,
				'totalITSupportUsers' => $totalITSupportUsers,
				'totalHRUsers' => $totalHRUsers,
				'totalSeniorDeveloperUsers' => $totalSeniorDeveloperUsers,
				'totalAccountantUsers'=> $totalAccountantUsers,
				'totalTraineeUsers' => $totalTraineeUsers,
				'maleUsers' => $maleUsers,
				'femaleUsers' => $femaleUsers,
				'otherGenderUsers' => $otherGenderUsers,
			);

			$this->load->view('header');
			$this->load->view('dashboard', $data);
			$this->load->view('footer');
		} 
		else
		{
			$this->load->view('user_header');
			$this->load->view('user_dashboard');
			$this->load->view('footer');
		}
	}


	//users page
	public function show() 
	{
		$d=$this->login_model->pages();
		$data['d']=$d;
		$this->session->unset_userdata('admin_logged');

		$data['records'] = $this->login_model->getData(); 

		$val=$this->session->userdata('val');
		//echo $val->email;
		$this->load->view('header');
		$this->load->view('user_view', $data);
		$this->load->view('footer');
	}

	//add user register controller
	public function register() 
	{
    	$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'gender' => $this->input->post('gender'),
			'name' => $this->input->post('name'),
			'role' => $this->input->post('role'),
			'father_name' => $this->input->post('father_name'),
			'mother_name' => $this->input->post('mother_name'),
			'country' => $this->input->post('country'),
			'mobile' => $this->input->post('mobile')
		);
		
		
		$newUserName = $this->input->post('name');
		$loggedInUserName = $this->session->userdata('val2'); // Adjust the key according to your actual session data
		//echo ($loggedInUserName->name);
		
		$data2 = array(
			'name' => $loggedInUserName->name,
			'action' => 'add',
			'page' => 'add_users',
			'message' =>  $loggedInUserName->name. ' added ' . $newUserName,
		);


		$this->login_model->insert_logs($data2);

    	if ($this->login_model->is_email_duplicate($data['email'])) 
		{
			$this->session->set_flashdata('error_message', 'Email is already registered.');
			$this->load->view('header');
			$this->load->view('add_user', $data); 
			$this->load->view('footer');
    	} 
		else 
		{
			$this->login_model->save_user($data);
			redirect('welcome/show');
    	}
	}
	//add user page
	public function add_user() 
	{
        $this->session->unset_userdata('admin_logged');
        $data['records'] = $this->login_model->getData(); 

        $this->load->view('header');
        $this->load->view('add_user',$data);
        $this->load->view('footer');
	}
	//edit user page
	public function edit_user($user_id) 
	{
		$user_data = $this->login_model->get_user_data($user_id);
		$this->session->set_userdata('row_id', $user_id);
	
		$data = array(
			'user_id' => $user_data['id'],
			'user_email' => $user_data['email'],
			'user_password' => $user_data['password'],
			'name' => $user_data['name'],
			'role' => $this->input->post('role'),
			'gender' => $user_data['gender'],
			'father_name' => $user_data['father_name'],
			'mother_name' => $user_data['mother_name'],
			'country' => $user_data['country'],
			'mobile' => $user_data['mobile']
		);
		
	
		$this->load->view('header');
		$this->load->view('edit_user', $data);
		$this->load->view('footer');
	}
	//update user data controller
	public function update() 
	{
		$id=$this->session->userdata('row_id');
		$data = array(
			'email' => $this->input->post('email'),
			'password' => $this->input->post('password'),
			'name' => $this->input->post('name'),
			'role' => $this->input->post('role'),
			'gender' => $this->input->post('gender'),
			'father_name' => $this->input->post('father_name'),
			'mother_name' => $this->input->post('mother_name'),
			'country' => $this->input->post('country'),
			'mobile' => $this->input->post('mobile')
		);

		$newUserName = $this->input->post('name');
		$loggedInUserName = $this->session->userdata('val2'); // Adjust the key according to your actual session data
		//echo ($loggedInUserName->name);
		
		$data2 = array(
			'name' => $loggedInUserName->name,
			'action' => 'edit',
			'page' => 'users',
			'message' =>  $loggedInUserName->name. ' edited ' . $newUserName,
		);

		$this->login_model->insert_logs($data2);

		$this->login_model-> update_user($id,$data);
		redirect('welcome/show');
	}	
	//delete controller

	public function delete_user($id)
	{
		$userToDelete = $this->login_model->get_user_details($id);

		if ($userToDelete) {
			$deletion_successful = $this->login_model->delete_user($id);
			$loggedInUser = $this->session->userdata('val2');

			$data2 = array(
				'name' => $loggedInUser->name, 
				'action' => 'delete',
				'page' => 'users',
				'message' => $loggedInUser->name . ' deleted  ' . $userToDelete->name,
		
			);

			$this->login_model->insert_logs($data2);

			if ($deletion_successful) {
				$this->session->set_flashdata('status', 'User deleted successfully');
			} else {
				$this->session->set_flashdata('error', 'Failed to delete user');
			}
		} else {
			$this->session->set_flashdata('error', 'User not found');
		}

		redirect('welcome/show');
	}

	//forgot password smtp
	public function send_password()
	{
		$toemail=$this->input->post('email');
		//echo $toemail;

		if (!$this->login_model->emailExists($toemail)) {
			echo '<script>
				alert("This email is not registered. Please enter a registered email address.");
				window.location.href = "'.base_url('welcome/forgot_password').'";
			</script>';
			return;
		}

		$config['protocol']  = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']  = 'frontenddeveloper2k01@gmail.com';//host name
		$config['smtp_pass'] = 'afnn ccyv kmsr emac';//host pswd
		$config['charset'] = 'utf-8';
		$config['newline']  = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not     
		
		$this->email->initialize($config);
		$from_email = "frontenddeveloper2k01@gmail.com";//from mail it can be any mail of user

		function pswd_gen()
		{
			$pswd='';
			$st='abcdefghijk';
			for($i=0;$i<5;$i++){
				$pswd.=$st[random_int(0,9)];
			}
			return $pswd;
		}
		
		$subject = "New password for your account";
		$new_password = pswd_gen();

		$c = $this->login_model->changepswd($toemail, $new_password);
		
		$message = "Dear user,<br><br>Your password has been reset successfully. <br><br>Your new password is: $new_password<br><br>Please login with the new password and consider changing it after logging in.";
		//Load email library
		$this->email->from($from_email, 'TeamWork APAC Pvt Ltd');//    from(from_mail,identification)
		$this->email->to($toemail);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
		
		echo '<script>
		if (confirm("Password reset email sent successfully. Check your email for the new password. Click OK to redirect to the index page.")) {
			window.location.href = "'.base_url('welcome/index').'";
		} else {
			window.location.href = "'.base_url('welcome/index').'";
		}
	</script>';
	}

	//forgot password page 
	public function forgot_password()
	{
		$this->load->view('forgot_password');
	}

	//change password controller
	/*public function change_password()
	{
		$this->session->unset_userdata('admin_logged');
		$this->session->unset_userdata('user_logged');
		$user_role = $this->session->userdata('val2'); // Replace 'user_role' with the actual key used in your session
  		$id =$user_role->id;
 		
		$name = $this->input->post('old_password'); // old password       
		$password = $this->input->post('password'); // new password
		
		$value = $this->login_model->getdata_by_id($id);
  		$e = $value->email;
		$this->login_model->changepswd($e, $password);//change in db
		$toemail=$e;
	
		$config['protocol']  = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_port'] = '465';
		$config['smtp_timeout'] = '7';
		$config['smtp_user']  = 'frontenddeveloper2k01@gmail.com';//host name
		$config['smtp_pass'] = 'afnn ccyv kmsr emac';//host pswd
		$config['charset'] = 'utf-8';
		$config['newline']  = "\r\n";
		$config['mailtype'] = 'html'; // or html
		$config['validation'] = TRUE; // bool whether to validate email or not     
		$this->email->initialize($config);
		$from_email = "frontenddeveloper2k01@gmail.com";//from mail it can be any mail of user

		   
		$subject = "Password Reset Confirmation";
		$sender_name = "TW Login";
		$sender_email = "frontenddeveloper2k01@gmail.com";

		$message = '<html>
		<head>
			<style>
				body {
					font-family: Arial, sans-serif;
					background-color: #f4f4f4;
					color: #333;
					padding: 20px;
				}
				.container {
					max-width: 600px;
					margin: 0 auto;
					background-color: #fff;
					padding: 20px;
					border-radius: 8px;
					box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
				}
				h2 {
					color: #3498db;
				}
				p {
					margin-bottom: 15px;
				}
			</style>
		</head>
		<body>
			<div class="container">
			<img src="https://i.ibb.co/8PpsG7j/logo.png" alt="Your Company Logo" style="max-width: 100px; height: 50px;">
			<h2>Password Reset Confirmation</h2>
				<p>Dear User,</p>
				<p>We are writing to inform you that your password has been successfully changed for your account.</p>
				<p>Your new password is: <strong>' . $password . '</strong></p>
				<p>If you did not request this change or have any concerns, please contact us immediately at <a href="mailto:' . $sender_email . '">' . $sender_email . '</a>.</p>
				<p>Thank you for choosing ' . $sender_name . '.</p>
				<p>Best regards,<br>' . $sender_name . ' Team</p>
			</div>
		</body>
		</html>';
		//Load email library
		$this->email->from($from_email, 'TW Login');//    from(from_mail,identification)
		$this->email->to($e);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();

		$this->session->set_flashdata('status','Your Password has been changed successfully');
		//redirect('welcome/index');
	
		//$val=explode(',',$this->session->userdata('access'));
	
		$user_role = $this->session->userdata('user_role'); // Replace 'user_role' with the actual key used in your session
		//echo $val->email;
		if($user_role && $user_role == 'admin')	
		{
			//echo'yes admin';
			$ans=$this->login_model->file_data();
			$v=$this->login_model->authenticate($name,$password);
			$this->load->view('header');
			$this->load->view('change_password');
			$this->load->view('footer');
		}
		else
		{
			////echo'no admin';
			$ans=$this->login_model->file_data();
			$v=$this->login_model->authenticate($name,$password);	   
			$ans['records'] = $this->login_model->getData(); 
			$this->load->view('user_header');
			$this->load->view('change_password',$val);
			$this->load->view('footer');

		}
	}	*/

	/*public function change_password()
{
    $this->session->unset_userdata('admin_logged');
    $this->session->unset_userdata('user_logged');
    
    $user_role = $this->session->userdata('val2');
    $id = $user_role->id;
    
    $old_password = $this->input->post('old_password');
    $new_password = $this->input->post('password');
    $repeat_password = $this->input->post('repeat_password');

    // Validate if the new password and repeat password match
    if ($new_password !== $repeat_password) {
        $this->session->set_flashdata('status', 'New password and repeat password do not match');
        redirect('welcome/change_password'); // Redirect to the appropriate page
        return;
    }

    // Proceed with changing password in the database
    $value = $this->login_model->getdata_by_id($id);
    $e = $value->email;
    $this->login_model->changepswd($e, $new_password);

    // Your existing email sending code here...
    $config['protocol']  = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '7';
    $config['smtp_user']  = 'frontenddeveloper2k01@gmail.com';
    $config['smtp_pass'] = 'afnn ccyv kmsr emac';
    $config['charset'] = 'utf-8';
    $config['newline']  = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $this->email->initialize($config);
    $from_email = "frontenddeveloper2k01@gmail.com";

    $subject = "Password Reset Confirmation";
    $sender_name = "TW Login";
    $sender_email = "frontenddeveloper2k01@gmail.com";

    $message = '<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #3498db;
            }
            p {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
        <img src="https://i.ibb.co/8PpsG7j/logo.png" alt="Your Company Logo" style="max-width: 100px; height: 50px;">
        <h2>Password Reset Confirmation</h2>
            <p>Dear User,</p>
            <p>We are writing to inform you that your password has been successfully changed for your account.</p>
            <p>Your new password is: <strong>' . $new_password . '</strong></p>
            <p>If you did not request this change or have any concerns, please contact us immediately at <a href="mailto:' . $sender_email . '">' . $sender_email . '</a>.</p>
            <p>Thank you for choosing ' . $sender_name . '.</p>
            <p>Best regards,<br>' . $sender_name . ' Team</p>
        </div>
    </body>
    </html>';

    $this->email->from($from_email, 'TW Login');
    $this->email->to($e);
    $this->email->subject($subject);
    $this->email->message($message);
    $this->email->send();

    $this->session->set_flashdata('status', 'Your Password has been changed successfully');
    
    $user_role = $this->session->userdata('user_role');

    if ($user_role && $user_role == 'admin') {
        $ans = $this->login_model->file_data();
        $v = $this->login_model->authenticate($old_password, $new_password);
        $this->load->view('header');
        $this->load->view('change_password');
        $this->load->view('footer');
    } else {
        $ans = $this->login_model->file_data();
        $v = $this->login_model->authenticate($old_password, $new_password);
        $ans['records'] = $this->login_model->getData();
        $this->load->view('user_header');
        $this->load->view('change_password', $val);
        $this->load->view('footer');
    }
}*/

public function change_password()
{
    $this->session->unset_userdata('admin_logged');
    $this->session->unset_userdata('user_logged');
    
    $user_role = $this->session->userdata('val2');
    $id = $user_role->id;
    
    $old_password = $this->input->post('old_password');
    $new_password = $this->input->post('password');
    $repeat_password = $this->input->post('repeat_password');

    // Validate if the new password and repeat password match
    if ($new_password !== $repeat_password) {
        $this->session->set_flashdata('status', 'New password and repeat password do not match');
        redirect('welcome/change_password'); // Redirect to the appropriate page
        return;
    }

    // Proceed with changing password in the database
    $value = $this->login_model->getdata_by_id($id);
    $e = $value->email;
    $this->login_model->changepswd($e, $new_password);

    // Send email notification
    $this->send_password_reset_confirmation($e, $new_password);

    

    $this->session->set_flashdata('status', 'Your Password has been changed successfully');
    
    $user_role = $this->session->userdata('user_role');

    if ($user_role && $user_role == 'admin') {
        $ans = $this->login_model->file_data();
        $v = $this->login_model->authenticate($old_password, $new_password);
        $this->load->view('header');
        $this->load->view('change_password');
        $this->load->view('footer');
    } else {
        $ans = $this->login_model->file_data();
        $v = $this->login_model->authenticate($old_password, $new_password);
        $ans['records'] = $this->login_model->getData();
        $this->load->view('user_header');
        $this->load->view('change_password', $val);
        $this->load->view('footer');
    }
}

private function send_password_reset_confirmation($recipient_email, $new_password)
{
    $config['protocol']  = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '7';
    $config['smtp_user']  = 'frontenddeveloper2k01@gmail.com';
    $config['smtp_pass'] = 'afnn ccyv kmsr emac';
    $config['charset'] = 'utf-8';
    $config['newline']  = "\r\n";
    $config['mailtype'] = 'html';
    $config['validation'] = TRUE;

    $this->email->initialize($config);
    $from_email = "frontenddeveloper2k01@gmail.com";

    $subject = "Password Reset Confirmation";
    $sender_name = "TW Login";
    $sender_email = "frontenddeveloper2k01@gmail.com";

    $message = '<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                padding: 20px;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2 {
                color: #3498db;
            }
            p {
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>
        <div class="container">
        <img src="https://i.ibb.co/8PpsG7j/logo.png" alt="Your Company Logo" style="max-width: 100px; height: 50px;">
        <h2>Password Reset Confirmation</h2>
            <p>Dear User,</p>
            <p>We are writing to inform you that your password has been successfully changed for your account.</p>
            <p>Your new password is: <strong>' . $new_password . '</strong></p>
            <p>If you did not request this change or have any concerns, please contact us immediately at <a href="mailto:' . $sender_email . '">' . $sender_email . '</a>.</p>
            <p>Thank you for choosing ' . $sender_name . '.</p>
            <p>Best regards,<br>' . $sender_name . ' Team</p>
        </div>
    </body>
    </html>';

    $this->email->from($from_email, 'TW Login');
    $this->email->to($recipient_email);
    $this->email->subject($subject);
    $this->email->message($message);
    $this->email->send();
}






	public function file()
	{
		$data['records'] = $this->login_model->getData();
		// $this->load->view('header');
		// $this->load->view('file_view',$data);
    	// $this->load->view('footer');
		$role = $this->session->userdata('user_role'); // Change to 'user_role'
		
		// if ($role !== null && $role == 'admin'){        
			$this->load->view('header');
			$this->load->view('user_file',$data);
			$this->load->view('footer');
		} 
		
	
	//file view upload code
	public function upload()
	{
		$data['records'] = $this->login_model->getData();
		// $this->load->view('header');
		// $this->load->view('file_view',$data);
    	// $this->load->view('footer');
		$role = $this->session->userdata('user_role'); // Change to 'user_role'
		if ($role !== null && $role == 'admin'){        
			$this->load->view('header');
			$this->load->view('file_view',$data);
			$this->load->view('footer');
		} 
		else {
			$this->load->view('user_header');
			$this->load->view('user_file',$data);
			$this->load->view('footer');
		}
	}	
	
	//multi upload
	public function file_upload() 
	{
	
		
		$role = $this->session->userdata('user_role'); // Change to 'user_role'
		
		if ($role !== null && $role == 'admin'){        
			$this->load->view('header');
			$this->load->view('upload_page');
			$this->load->view('footer');
		} 
		else {
			$this->load->view('user_header');
			$this->load->view('upload_page');
			$this->load->view('footer');
		}

		$data['records'] = $this->login_model->getData();

		$this->load->library('upload');

		if ($this->input->post('submit')) {
			$config['upload_path']   = './uploads/';
			$config['allowed_types'] = 'gif|jpg|png|pdf|docx|doc|xls|xlsx|ppt|pptx|txt|csv|zip|rar|tar|7z|mp3|mp4|avi|mkv';
			$config['max_size']      = 10000;

			$this->upload->initialize($config);

			$files = $_FILES['userfile'];
			$file_count = count($files['name']);
			$arr = array();

			for ($i = 0; $i < $file_count; $i++) {
				$_FILES['uploadedFile']['name'] = $files['name'][$i];
				$_FILES['uploadedFile']['type'] = $files['type'][$i];
				$_FILES['uploadedFile']['tmp_name'] = $files['tmp_name'][$i];
				$_FILES['uploadedFile']['error'] = $files['error'][$i];
				$_FILES['uploadedFile']['size'] = $files['size'][$i];

				if ($this->upload->do_upload('uploadedFile')) {
					$a = $_FILES['uploadedFile']['name'];
					array_push($arr, $a);
					$r = json_encode($arr);
					$file_saved = $this->login_model->saveFileData($this->session->userdata('id'), $r);

					
                // Log entry for successful file upload
                $loggedInUserName = $this->session->userdata('val2');
                $log_data = array(
                    'name' => $loggedInUserName->name,
                    'action' => 'upload',
                    'page' => 'file_upload',
                    'message' => $loggedInUserName->name . ' uploaded file: ' . $a,

                );

                $this->login_model->insert_logs($log_data);
				} else {
					$data['error']['upload_error'][] = $this->upload->display_errors();
				}
			}

			if (empty($data['error']['upload_error'])) 
			{
				$this->session->set_flashdata('success', 'Files successfully uploaded!');
				
				// Set the appropriate session data based on the user role
				$user_role = $this->session->userdata('user_role');
				if ($user_role == 'admin') {
					$this->session->set_userdata('admin_logged', true);
					redirect('Welcome/upload');
				} else {
					$this->session->set_userdata('user_logged', true);
					redirect('Welcome/upload');

				}

			
			} 
			else 
			{
				$this->session->set_flashdata('error', implode('<br>', $data['error']['upload_error']));
			}
		}
	}

	public function update_file($id)
	{
		//echo ($id);
		$file_name = $this->login_model->getdata_by_id($id);
	
		$data['file_name'] = $file_name;
	
		

		$role = $this->session->userdata('user_role'); // Change to 'user_role'

		if ($role !== null && $role == 'admin'){        
			$this->load->view('header');
			$this->load->view('update_file', $data);
			$this->load->view('footer');
			//print_r($data);die();

		} 
		else {
			$this->load->view('user_header');
			$this->load->view('update_file', $data);
			$this->load->view('footer');
		}


	}

	

	public function profile() {
		$this->session->unset_userdata('admin_logged');
		$this->session->unset_userdata('user_logged');
		$id = $this->session->userdata('person_id');
		$data = $this->login_model->getdata_by_id($id);
	
		$role = $this->session->userdata('user_role');
	
		if ($role !== null && $role == 'admin') {
			// Admin logic
			$email = $this->session->userdata('email');
			$password = $this->session->userdata('password');
	
			$ans = $this->login_model->file_data();
			$v = $this->login_model->authenticate($email, $password);
			$val['v'] = $v;
			$ans['records'] = $this->login_model->getData(); 
	
			$this->load->view('header');
			$this->load->view('profile', $val);
			$this->load->view('footer');
		} else {
			// User logic
			$email = $this->session->userdata('email');
			$password = $this->session->userdata('password');
	
			$ans = $this->login_model->file_data();
			$v = $this->login_model->authenticate($email, $password);
			$val['v'] = $v;
			$ans['records'] = $this->login_model->getData(); 
	
			$this->load->view('user_header');
			$this->load->view('profile', $val);
			$this->load->view('footer');
		}
	}

	public function dashboard_img() {
		$config['upload_path'] =  'uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png|gif';
		$config['max_size'] = 20048; // Maximum file size in kilobytes (2MB in this case)
	
		$this->load->library('upload', $config);
	
		//print_r($_FILES['pic']['name']);

	
		if (!$this->upload->do_upload('pic')) {
			$image_data = $_FILES['pic']['name'];
 			$i = $this->session->userdata('person_id');

			$loggedInUserName = $this->session->userdata('val2'); // Adjust the key according to your actual session data
			//echo ($loggedInUserName->name);
			
			$data2 = array(
				'name' => $loggedInUserName->name,
				'action' => 'edit',
				'page' => 'profile',
				'message' =>  $loggedInUserName->name. ' updated profile ',
			);
	
			$this->login_model->insert_logs($data2);

			$this->login_model->update_image($i, $image_data);
			$msg = "Image updated successfully";
		} else {
			$msg = $this->upload->display_errors();
		}
	
		// Debug statements
		 
		$role = $this->session->userdata('user_role'); // Assuming user_role is stored in the session
	
		if ($role !== null && strpos($role, 'admin') !== false) {
			$this->load->view('header');
		} else {
			$this->load->view('user_header');
		}
	
		$data['msg'] = $msg;
		$this->load->view('profile', $data);
	}
	
	public function access_show() 
	{
		$d=$this->login_model->pages();
		$data['d']=$d;
		$this->session->unset_userdata('admin_logged');

		$data['records'] = $this->login_model->getData(); 

		$this->load->view('header');
		$this->load->view('access_view', $data);
		$this->load->view('footer');
		
	}

	public function access_edit($id) 
	{
		$file_name = $this->login_model->getdata_by_id($id);
		$data['n'] = $file_name;

		$this->load->view('header');
		$this->load->view('access_edit', $data);
		$this->load->view('footer');
	}

	public function update_access($id)
	{
		$data = array(
			'email' => $this->input->post('email'),
			'name' => $this->input->post('name'),
			'role' => $this->input->post('role'),
			'access' => $this->input->post('access'),
		);

		$loggedInUserName = $this->session->userdata('val2');

		$this->login_model->update_user($id, $data);
		
		// Log entry for updating user access
		$log_data = array(
			'name' => $loggedInUserName->name,
			'action' => 'edit',
			'page' => 'update_access',
			'message' => $loggedInUserName->name . ' updated access for '  . $data['name'],

		);

		$this->login_model->insert_logs($log_data);

		// Redirect to the access_show page
		redirect('welcome/access_show');
	}



	

	public function access_page_HR()
{
	$user_role = $this->session->userdata('user_role'); // Replace 'user_role' with the actual key used in your session

    $data['records'] = $this->login_model->getHRData();
	if ($user_role && $user_role == 'admin') {
		$this->load->view('header');
		$this->load->view('HR_page', $data);
		$this->load->view('footer');
	} else {
		$this->load->view('user_header');
		$this->load->view('HR_page',$data);
		$this->load->view('footer');
	}
   
}


	public function access_page_Manager()
	{
	
		$user_role = $this->session->userdata('user_role'); // Replace 'user_role' with the actual key used in your session

		$data['records'] = $this->login_model->getManagerData();


		if ($user_role && $user_role == 'admin') {
			$this->load->view('header');
			$this->load->view('manager_page', $data);
			$this->load->view('footer');
		} else {
			$this->load->view('user_header');
			$this->load->view('manager_page',$data);
			$this->load->view('footer');
		}
	}

	public function access_page_Developer()
	{
		$user_role = $this->session->userdata('user_role'); // Replace 'user_role' with the actual key used in your session

		$data['records'] = $this->login_model->getDeveloperData();

		if ($user_role && $user_role == 'admin') {
			$this->load->view('header');
			$this->load->view('developer_page', $data);
			$this->load->view('footer');
		} else {
			$this->load->view('user_header');
			$this->load->view('developer_page',$data);
			$this->load->view('footer');
		}
	
	}

	public function logs()
	{
		$data['records'] = $this->login_model->getLogData();
		$this->load->view('header');
		$this->load->view('logs',$data);
		$this->load->view('footer');

	}

	//facebook
	public function facebook_login() {
		$app_id = '747279053925045'; // Replace with your Facebook App ID
		$redirect_url = base_url('welcome/callback');  
		$login_url = "https://www.facebook.com/v13.0/dialog/oauth?client_id=$app_id&redirect_uri=$redirect_url&scope=email";
		redirect($login_url);
	}
	
	public function callback() {
		$code = $this->input->get('code');
	
		if ($code) {
			$app_id = '747279053925045'; // Replace with your Facebook App ID
			$app_secret = '2e3d01e38c791784bfd48d29d8fde1b1'; // Replace with your Facebook App Secret
			$redirect_url = base_url('welcome/callback');
	
			// Exchange code for access token
			$token_url = "https://graph.facebook.com/v13.0/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_url&client_secret=$app_secret&code=$code";
			$response = $this->fetchUrl($token_url);
	
			if ($response) {
				$params = json_decode($response, true);
	
				if (isset($params['access_token'])) {
					$graph_url = "https://graph.facebook.com/v13.0/me?fields=id,name,email,picture&access_token={$params['access_token']}";
					$user = json_decode($this->fetchUrl($graph_url));
	
					if ($user && !isset($user->error)) {
						$data['password'] = '123';
						$data['name'] = $user->name;
						$data['email'] = $user->email;
						$profile_pic = isset($user->picture->data->url) ? $user->picture->data->url : "https://graph.facebook.com/{$user->id}/picture?type=large"; // Get the profile picture URL
						$data['pic'] = $profile_pic;
	
						$existing_user = $this->login_model->getRecordByEmail($data['email']);
	
						if ($existing_user) {
							// User exists, set session data
							$this->session->set_userdata('fb_login', $existing_user);
							$this->session->set_userdata('user_data', $existing_user);
						} else {
							// User doesn't exist, insert into database
							$this->login_model->insert_data($data);
							// Set session data
							$this->session->set_userdata('fb_login', $data);
							$this->session->set_userdata('user_data', $data);
						}
	
						redirect('welcome/check');
					} else {
						echo "Error occurred while fetching user profile.";
						// Log or print the error for debugging
						print_r($user->error);
					}
				} else {
					echo "Error occurred while fetching access token.";
				}
			} else {
				echo "Error occurred while exchanging code for access token.";
			}
		} else {
			echo "Invalid callback.";
		}
	}
	
	private function fetchUrl($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function pages()
	{
		$d=$this->login_model->select_pages();
		$data['d']=$d;
		// Load views
		$this->load->view('header');
		$this->load->view('pages',$data);
		$this->load->view('footer');
	}

	public function dictionary()
	{
	
		$d=$this->login_model->pages();
		$data['d']=$d;
		// Load views
		$this->load->view('header');
		$this->load->view('dictionary',$data);
		$this->load->view('footer');
	}

	public function user_dictionary()
	{
	
		$d=$this->login_model->user_pages();
		$data['d']=$d;
		// Load views
		$this->load->view('header');
		$this->load->view('user_dictionary',$data);
		$this->load->view('footer');
	}

	public function dictionary_update()
	{
		//$id=$this->session->userdata('row_id');

		$i=$this->input->post('name');
 		$f=$this->login_model->get_dict_name($i);
  		$data['f']=$f;
		// Load views$
		$this->load->view('header');
		$this->load->view('dictionary_update',$data);
		// $this->load->view('footer');
	}

	public function user_dictionary_update()
	{
		//$id=$this->session->userdata('row_id');

		$i=$this->input->post('name');
 		$f=$this->login_model->user_get_dict_name($i);
  		$data['f']=$f;
		// Load views$
		$this->load->view('header');
		$this->load->view('user_dictionary_update',$data);
		// $this->load->view('footer');
	}
	


	public function dict_update() {
		$title = $this->input->post('title');
		$id = $this->input->post('user_id');
		$side_menu = $this->input->post('side_menu');
		$thead = $this->input->post('thead');
		$buttons = $this->input->post('buttons');
	
		$thead_imploded = is_array($thead) ? implode(',', $thead) : '';
		$buttons_imploded = is_array($buttons) ? implode(',', $buttons) : '';
	
		$this->load->model('login_model');
	
		$data = array(
			'title' => $title,
			'side_menu' => $side_menu,
			'thead' => $thead_imploded,
			'buttons' => $buttons_imploded
		);
	
		$this->login_model->update_page($id, $data);
	
		redirect('welcome/pages');
	}

	public function user_dict_update() {
		$title = $this->input->post('title');
		$id = $this->input->post('user_id');
		$side_menu = $this->input->post('side_menu');
		$thead = $this->input->post('thead');
		$buttons = $this->input->post('buttons');
	
		$thead_imploded = is_array($thead) ? implode(',', $thead) : '';
		$buttons_imploded = is_array($buttons) ? implode(',', $buttons) : '';
	
		$this->load->model('login_model');
	
		$data = array(
			'title' => $title,
			'side_menu' => $side_menu,
			'thead' => $thead_imploded,
			'buttons' => $buttons_imploded
		);
	
		$this->login_model->user_update_page($id, $data);
	
		redirect('welcome/pages');
	}
	
	
	public function settings()
	{
		$d=$this->login_model->color();
		$data['d']=$d;

		$this->load->view('header');
		$this->load->view('settings',$data);
		$this->load->view('footer');
	}

	public function update_theme()
	{

		$color=$this->input->post('color');
		$title=$this->input->post('page_title');
		$footer=$this->input->post('page_footer');

		$pic_name=$_FILES['fileuploadpicture']['name'];

 		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'jpg|png|pdf|gif';


	  $this->load->library('upload',$config);
	  if (!$this->upload->do_upload('logo')) {
		
		$this->login_model->update_theme($color,$title,$pic_name,$footer);

		   $msg="updated"; 

		//    print_r($msg);die();
	  } else {
		  $msg=$this->upload->display_errors();
	  }

  		redirect('welcome/settings');

	}

	// public function importExcel() {
		// 	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["excelFile"])) {
		// 		$excelFile = $_FILES["excelFile"]["tmp_name"];
		
		// 		try {
		// 			$spreadsheet = IOFactory::load($excelFile);
		// 			$worksheet = $spreadsheet->getActiveSheet();
		
		// 			$importedData = [];
		// 			foreach ($worksheet->getRowIterator() as $row) {
		// 				$rowData = [];
		// 				foreach ($row->getCellIterator() as $cell) {
		// 					$rowData[] = $cell->getValue();
		// 				}
		// 				$importedData[] = $rowData;
		// 			}
		
		// 			// Now, $importedData contains the imported Excel data
		// 			// You can use this data as needed in your application
		
		// 			// For example, you can insert the data into the database
		// 			// Assuming you have a model function to handle database insertion
		// 			$this->login_model->insertImportedData($importedData);
		
		// 			// Redirect or show a success message
		// 			redirect('welcome/export');
		// 		} catch (\Exception $e) {
		// 			echo 'Error loading Excel file: ',  $e->getMessage();
		// 		}
		// 	}
	// }

	public function remove_profile() 
	{
		$id = $this->session->userdata('person_id');
		
		$this->login_model->remove_profile($id);

		redirect('welcome/profile');
	}

	public function export() 
	{
		$data['records'] = $this->login_model->getData(); 

		
		$this->load->view('header');
		$this->load->view('export',$data);
		$this->load->view('footer');
	}

    public function excel2() {
		// Get data from the model
		$data = $this->login_model->getData();
		$spreadsheet = new Spreadsheet();
	
		$spreadsheet->getProperties()
			->setCreator('Your Name')
			->setLastModifiedBy('Your Name')
			->setTitle('Example Spreadsheet')
			->setSubject('Test')
			->setDescription('A simple example spreadsheet')
			->setKeywords('example php spreadsheet');
	
		// Add some data to the spreadsheet
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Name');
		$sheet->setCellValue('B1', 'file_name');
		$sheet->setCellValue('C1', 'email');
		$sheet->setCellValue('D1', 'role');
		$sheet->setCellValue('E1', 'access');
	
		// Check if data is available
		if ($data) {
			$row = 2; // Start from the second row
			foreach ($data as $row_data) {
				$sheet->setCellValue('A' . $row, $row_data->name);
				$sheet->setCellValue('B' . $row, $row_data->file_name);
				$sheet->setCellValue('C' . $row, $row_data->email);
				$sheet->setCellValue('D' . $row, $row_data->role);
				$sheet->setCellValue('E' . $row, $row_data->access);
				$row++;
			}
		}
	
		// Add a new worksheet for additional information
		$infoSheet = $spreadsheet->createSheet();
		$infoSheet->setTitle('Additional Info');
		$infoSheet->setCellValue('A1', 'Data from Session:');
		$infoSheet->setCellValue('A2', print_r($data, true));
	
		$filename = 'export.xlsx';
		$tempFilePath = sys_get_temp_dir() . '/' . $filename; 
		$writer = new Xlsx($spreadsheet);
		$writer->save($tempFilePath);
	
		$fileContent = file_get_contents($tempFilePath);
	
		$this->force_download($filename, $fileContent);
	}
	
	private function force_download($filename, $fileContent) {
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . strlen($fileContent));
		echo $fileContent;
		exit;
	}
	
	public function excel_view()
	{
		$this->load->view('excel_read');
	}



    public function excel_upload()
    {
            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'xls|xlsx';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;

            $this->load->library('upload', $config);

            if ( $this->upload->do_upload('pic'))
            {
                echo ('1');
                    $error = array('error' => $this->upload->display_errors());

                    $this->load->view('excel_read', $error);

					print_r($error);

            }
            else
            {
                echo ('2');

                    $data = array('upload_data' => $this->upload->data());

                   print_r($data);

                    $this->load->view('excel_read', $data);
            }
    }
	
	
	

	
	
		
	

		


}
?>