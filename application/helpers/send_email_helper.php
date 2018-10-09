<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();

function sendMail($receiver, $subject, $message)
{
	global $CI;
    $config = Array(
	  'protocol' => 'smtp',
	  'smtp_host' => 'ssl://smtp.googlemail.com',
	  'smtp_port' => 465,
	  'smtp_user' => 'chandimalfdo91@gmail.com', // change it to yours
	  'smtp_pass' => '23noapte91', // change it to yours
	  'mailtype' => 'html',
	  'charset' => 'iso-8859-1',
	  'wordwrap' => TRUE
	);

	$CI->load->library('email');
	$CI->email->initialize($config);
	$CI->email->set_newline("\r\n");
	$CI->email->from('chandimalfdo91@gmail.com'); // change it to yours
	$CI->email->to($receiver);// change it to yours
	$CI->email->subject($subject);
	$CI->email->message($message);
	if($CI->email->send())
	{
		return true;
	}
	else
	{
		return $CI->email->print_debugger();
	}
}


function admin_pass_reset($to, $activation_code, $fname)
{
	$subject = "Password Reset";
	
	$message = "<p>Dear {$fname},</p>
	<p>Please click below link to confirm your email and use the following temporary password to signin to your account. Once you signup you can change your password.</p>
				
	<a href='".base_url()."auth/resetView/{$activation_code}'>Reset Password</a>
				
	<p>Kind Regards,</p>
	<p>SMC IT Team</p>";
	
	return sendMail($to, $subject, $message);
}

function send_new_admin_email($to, $fname, $temp_pass)
{
	$subject = "What Would You Do Contest Admin Account Invitation";
	
	$message = "<p>Dear {$fname},</p>
	<p>You are been added as a admin approver in What Would You Do Contest. Please use below login details to log in to your account.</p>
	
	<p><b>EMAIL : {$to}</b></p>
	<p><b>TEMPORARY PASSWORD : {$temp_pass}</b></p>
				
	<a href='".base_url()."auth/admin_login'>Login</a>
				
	<p>Kind Regards,</p>
	<p>iID Team</p>";
	
	return sendMail($to, $subject, $message);
}

function registrationMail($data)
{
	global $CI;
	$subject = "Student Management System";
	$message = $CI->load->view('email/registration', $data, true);
	return sendMail($data['email'], $subject, $message);
}
