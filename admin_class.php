<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = ".$username." and password = ".$password);
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function login2(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
				return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function logout2(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../index.php");
	}

	function save_user(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$password' ";
		//$data .= ", type = '$type' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set ".$data);
		}else{
			$save = $this->db->query("UPDATE users set ".$data." where id = ".$id);
		}
		if($save){
			return 1;
		}
	}

	function delete_user(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM user where id = ".$id);
		if($delete)
			return 1;
	}

	function signup(){
		extract($_POST);
		$data = " name = '$name' ";
		$data .= ", contact = '$contact' ";
		$data .= ", address = '$address' ";
		$data .= ", username = '$email' ";
		$data .= ", password = '".md5($password)."' ";
		//$data .= ", type = 3";
		$chk = $this->db->query("SELECT * FROM users where username = '$email' ")->num_rows;
		if($chk > 0){
			return 2;
			exit;
		}
			$save = $this->db->query("INSERT INTO users set ".$data);
		if($save){
			$qry = $this->db->query("SELECT * FROM users where username = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'passwors' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
			}
			return 1;
		}
	}

	function save_settings(){
		extract($_POST);
		$data = " name = '".str_replace("'","&#x2019;",$name)."' ";
		$data .= ", email = '$email' ";
		$data .= ", contact = '$contact' ";
		$data .= ", about_content = '".htmlentities(str_replace("'","&#x2019;",$about))."' ";
		if($_FILES['img']['tmp_name'] != ''){
						$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
						$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/img/'. $fname);
					$data .= ", cover_img = '$fname' ";

		}
		
		// echo "INSERT INTO system_settings set ".$data;
		$chk = $this->db->query("SELECT * FROM system_settings");
		if($chk->num_rows > 0){
			$save = $this->db->query("UPDATE system_settings set ".$data);
		}else{
			$save = $this->db->query("INSERT INTO system_settings set ".$data);
		}
		if($save){
		$query = $this->db->query("SELECT * FROM system_settings limit 1")->fetch_array();
		foreach ($query as $key => $value) {
			if(!is_numeric($key))
				$_SESSION['setting_'.$key] = $value;
		}

			return 1;
				}
	}

	
	function save_employee(){
		extract($_POST);
		$data =" firstname='$firstname' ";
		$data .=", middlename='$middlename' ";
		$data .=", lastname='$lastname' ";
		$data .=", position_id='$position_id' ";
		$data .=", department_id='$department_id' ";
		$data .=", salary='$salary' ";
		

		if(empty($id)){
			$i= 1;
			while($i == 1){
			$e_num=date('Y') .'-'. mt_rand(1,9999);
				$chk  = $this->db->query("SELECT * FROM employee where employee_no = '$e_num' ")->num_rows;
				if($chk <= 0){
					$i = 0;
				}
			}
			$data .=", employee_no='$e_num' ";

			$save = $this->db->query("INSERT INTO employee set ".$data);
		}else{
			$save = $this->db->query("UPDATE employee set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_employee(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employee where id = ".$id);
		if($delete)
			return 1;
	}
	
	function save_department(){
		extract($_POST);
		$data =" name='$name' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO department set ".$data);
		}else{
			$save = $this->db->query("UPDATE department set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_department(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM department where id = ".$id);
		if($delete)
			return 1;
	}
	function save_position(){
		extract($_POST);
		$data =" name='$name' ";
		$data .=", department_id = '$department_id' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO position set ".$data);
		}else{
			$save = $this->db->query("UPDATE position set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_position(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM position where id = ".$id);
		if($delete)
			return 1;
	}
	function save_allowances(){
		extract($_POST);
		$data =" allowance='$allowance' ";
		$data .=", description = '$description' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO allowances set ".$data);
		}else{
			$save = $this->db->query("UPDATE allowances set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_allowances(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM allowances where id = ".$id);
		if($delete)
			return 1;
	}
	function save_employee_allowance(){
		extract($_POST);
		
		foreach($allowance_id as $k =>$v){
			$data =" employee_id='$employee_id' ";
			$data .=", allowance_id = '$allowance_id[$k]' ";
			$data .=", type = '$type[$k]' ";
			$data .=", amount = '$amount[$k]' ";
			$data .=", effective_date = '$effective_date[$k]' ";
			$save[] = $this->db->query("INSERT INTO employee_allowances set ".$data);
		}

		if(isset($save))
			return 1;
	}
	function delete_employee_allowance(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employee_allowances where id = ".$id);
		if($delete)
			return 1;
	}
	function save_deductions(){
		extract($_POST);
		$data =" deduction='$deduction' ";
		$data .=", description = '$description' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO deductions set ".$data);
		}else{
			$save = $this->db->query("UPDATE deductions set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_deductions(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM deductions where id = ".$id);
		if($delete)
			return 1;
	}
	function save_employee_deduction(){
		extract($_POST);
		
		foreach($deduction_id as $k =>$v){
			$data =" employee_id='$employee_id' ";
			$data .=", deduction_id = '$deduction_id[$k]' ";
			//$data .=", type = '$type[$k]' ";
			$data .=", amount = '$amount[$k]' ";
			$data .=", effective_date = '$effective_date[$k]' ";
			$save[] = $this->db->query("INSERT INTO employee_deductions set ".$data);
		}

		if(isset($save))
			return 1;
	}
	function delete_employee_deduction(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM employee_deductions where id = ".$id);
		if($delete)
			return 1;
	}

	function save_employee_attendance(){
		extract($_POST);
		
		foreach($employee_id as $k => $v){
			$datetime_log[$k] = date("m/d/Y - h:i:s a");
			$data =" employee_id='$employee_id[$k]' ";
			$data .=", log_type = '$log_type[$k]' ";
			$data .=", datetime_log = '$datetime_log[$k]' ";
			$save[] = $this->db->query("INSERT INTO attendance set ".$data);
		}

		if(isset($save))
			return 1;
	}
	function delete_employee_attendance(){
		extract($_POST);
		$date = explode('_', $id);
		$dt = date("m/d/Y - h:i:s a", strtotime($date[1]));
 
		$delete = $this->db->query("DELETE FROM attendance where employee_id = '".$date[0]."' and date(datetime_log) ='$dt' ");
		if($delete)
			return 1;
	}
	function delete_employee_attendance_single(){
		extract($_POST);
		
 
		$delete = $this->db->query("DELETE FROM attendance where id = $id ");
		if($delete)
			return 1;
	}
	function save_payroll(){
		extract($_POST);

		//$employee = $conn->query("SELECT * FROM employee WHERE CONCAT(lastname, ', ', firstname) = '" . $_POST['employee'] . "'")->fetch_assoc();
		$employee = $_POST['employee'];
		$date_from = $_POST['date_from'];
		$date_to = $_POST['date_to'];

		$data = " employee = '$employee' ";
		$data .=", date_from ='$date_from' ";
		$data .=", date_to = '$date_to' ";
		//$data .=", type = '$type' ";

		if(empty($id)){
			$i= 1;
			while($i == 1){
			$ref_no=date('Y') .'-'. mt_rand(1,9999);
				$chk  = $this->db->query("SELECT * FROM payroll where ref_no = '$ref_no' ")->num_rows;
				if($chk <= 0){
					$i = 0;
				}
			}
			$data .=", ref_no='$ref_no' ";
			$save = $this->db->query("INSERT INTO payroll set ".$data);
		}else{
			$save = $this->db->query("UPDATE payroll set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_payroll(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM payroll where id = ".$id);
		if($delete)
			return 1;
	}
	//logical error here
	function calculate_payroll(){
		extract($_POST);
		// $am_in = "08:00";
		// $am_out = "12:00";
		// $pm_in = "13:00";
		// $pm_out = "17:00";
		//$this->db->query("DELETE FROM payroll_items where payroll_id=".$id); //inspect
		$pay = $this->db->query("SELECT * FROM payroll where id = ".$id)->fetch_array();
		$employee = $this->db->query("SELECT * FROM employee where CONCAT(lastname, ',', firstname) = " . $_POST['employee'])->fetch_array();

		$days = abs(strtotime($pay['date_to']." 23:59:59")) - strtotime($pay['date_from']." 00:00:00 -1 day") ; 
        $calc_days = floor($days / (60*60*24)); // compute no. days 
		$att=$this->db->query("SELECT * FROM attendance where datetime_log between ".$pay['date_from']." AND ".$pay['date_to']." order by datetime_log asc") or die(mysqli_error($conn));
		while($row=$att->fetch_array()){
			$date = date("M d,Y",strtotime($row['datetime_log']));
			if($row['log_type'] == 1){
				if(!isset($attendance[$row['employee_id']."_".$date]['log'][$row['log_type']]))
				$attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] = $row['datetime_log'];
			}else{
				$attendance[$row['employee_id']."_".$date]['log'][$row['log_type']] = $row['datetime_log'];
			}
		}

		$deductions = $this->db->query("SELECT * FROM employee_deductions where effective_date between ".$pay['date_from']." and ".$pay['date_to']);
		$allowances = $this->db->query("SELECT * FROM employee_allowances where effective_date between ".$pay['date_from']." and ".$pay['date_to']);
		while($row = $deductions->fetch_assoc()){
			$ded[$row['employee_id']][] = array('did'=>$row['deduction_id'],"amount"=>$row['amount']);
		} //compute deduction
		while($row = $allowances->fetch_assoc()){
			$allow[$row['employee_id']][] = array('aid'=>$row['allowance_id'],"amount"=>$row['amount']);
		} // compute allowance
		while($row[$employee]->fetch_assoc()){
			$salary = $row['salary']; 
			$min = ($salary / 7) /60; //wage per minute in a week 

			// subtract tardiness 
			for($i = 0; $i < $calc_days;$i++){
				$dd = date("Y-m-d",strtotime($pay['date_from']." +".$i." days")); 

				if(isset($attendance[$row['id']."_".$dd]['log'])) {
				$present = count($attendance[$row['id']."_".$dd]['log']); 
					
					if(isset($attendance[$row['id']."_".$dd]['log'][1]) && isset($attendance[$row['id']."_".$dd]['log'][2])){
						$att_mn = abs(strtotime($attendance[$row['id']."_".$dd]['log'][2])) - strtotime($attendance[$row['id']."_".$dd]['log'][1]); 
        				$att_mn = floor($att_mn / 60 ); // time difference in min
        				$net += ($att_mn * $min);
        				$late += (240 - $att_mn);
        				$present += .5;
					}
				}
			}

			// compute for allowance and deductions
			$ded_arr = array();
			$all_arr = array();
			if(isset($allow[$row['id']])){
				foreach ($allow[$row['id']] as $arow) {
					$all_arr[] = $arow;
					$net += $arow['amount'];
					$allow_amount += $arow['amount'];
	
				}
			}
			if(isset($ded[$row['id']])){
				foreach ($ded[$row['id']] as $drow) {
					$ded_arr[] = $drow;
					$net -= $drow['amount'];
					$ded_amount +=$drow['amount'];
				}
			}


			$absent = $calc_days - $present;  //change $dp to $calc_days
			$data = " payroll_id = '".$pay['id']."' ";
			$data .= ", employee = '$employee' ";
			$data .= ", absent = '$absent' ";
			$data .= ", present = '$present' ";
			$data .= ", late = '$late' ";
			$data .= ", salary = '$salary' ";
			$data .= ", allowance_amount = '$allow_amount' ";
			$data .= ", deduction_amount = '$ded_amount' ";
			$data .= ", allowances = '".json_encode($all_arr)."' ";
			$data .= ", deductions = '".json_encode($ded_arr)."' ";
			$data .= ", net = '$net' ";
			$save[] = $this->db->query("INSERT INTO payroll_items set ".$data);

		}
		if(isset($save)){
			$this->db->query("UPDATE payroll set status = 1 where id = ".$pay['id']);
			return 1;
		}
	}
}