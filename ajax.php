<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == "save_settings"){
	$save = $crud->save_settings();
	if($save)
		echo $save;
}
if($action == "save_employee"){
	$save = $crud->save_employee();
	if($save)
		echo $save;
}
if($action == "delete_employee"){
	$save = $crud->delete_employee();
	if($save)
		echo $save;
}
if($action == "save_department"){
	$save = $crud->save_department();
	if($save)
		echo $save;
}
if($action == "delete_department"){
	$save = $crud->delete_department();
	if($save)
		echo $save;
}
if($action == "save_position"){
	$save = $crud->save_position();
	if($save)
		echo $save;
}
if($action == "delete_position"){
	$save = $crud->delete_position();
	if($save)
		echo $save;
}
if($action == "save_allowances"){
	$save = $crud->save_allowances();
	if($save)
		echo $save;
}
if($action == "delete_allowances"){
	$save = $crud->delete_allowances();
	if($save)
		echo $save;
}

if($action == "save_employee_allowance"){
	$save = $crud->save_employee_allowance();
	if($save)
		echo $save;
}
if($action == "delete_employee_allowance"){
	$save = $crud->delete_employee_allowance();
	if($save)
		echo $save;
}
if($action == "save_deductions"){
	$save = $crud->save_deductions();
	if($save)
		echo $save;
}
if($action == "delete_deductions"){
	$save = $crud->delete_deductions();
	if($save)
		echo $save;
}
if($action == "save_employee_deduction"){
	$save = $crud->save_employee_deduction();
	if($save)
		echo $save;
}
if($action == "delete_employee_deduction"){
	$save = $crud->delete_employee_deduction();
	if($save)
		echo $save;
}

if($action == "save_employee_attendance"){
	$save = $crud->save_employee_attendance();
	if($save)
		echo $save;
}
if($action == "delete_employee_attendance"){
	$save = $crud->delete_employee_attendance();
	if($save)
		echo $save;
}
if($action == "delete_employee_attendance_single"){
	$save = $crud->delete_employee_attendance_single();
	if($save)
		echo $save;
}
if($action == "save_payroll"){
	$save = $crud->save_payroll();
	if($save)
		echo $save;
}
if($action == "delete_payroll"){
	$save = $crud->delete_payroll();
	if($save)
		echo $save;
}
if($action == "calculate_payroll"){
	$save = $crud->calculate_payroll();
	if($save)
		echo $save;
}
// Check if the action parameter is set
if (isset($_GET['action'])) {
	$action = $_GET['action'];
	// Handle the save_employee action
	if ($action == 'save_employee') {
		// Insert the form data into the database
		$fname = $_POST['firstname'];
		$mname = $_POST['middlename'];
		$lname = $_POST['lastname'];
		$department = $_POST['department_id'];
		$position = $_POST['position_id'];
		$salary = $_POST['salary'];
		// Perform database insert operation
		$qry = $conn->query("INSERT INTO employee (firstname, middlename, lastname, department_id, position_id, salary) VALUES ($fname, $mname, $lname, $department, $position, $salary)");
		echo 1;
	}
}
?>
