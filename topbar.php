<style>
	nav {
    background-color: #faa81b;
  }
</style>

<nav class="navbar navbar-light fixed-top" style="padding: 0; min-height: 3.5rem;">
  <div class="container-fluid mt-3 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  		
  		</div>
      <div class="col-md-4 float-left text-light">
        <h4><b>Payroll Management System</b></h4>
      </div>
	  	<div class="col-md-2 float-right text-light">
	  		<a href="ajax.php?action=logout" class="text-light"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"></i></a>
	    </div>
    </div>
  </div>
  
</nav>