<style>
	nav {
    background-color: #faa81b;
  }
</style>

<nav class="navbar navbar-light fixed-top" style="padding: 5; min-height: 3.5rem;">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  		
  		</div>
      <div class="col-md-4 float-left text-light pt-2">
        <h3><b>Payroll Management System</b></h3>
      </div>
	  	<div class="col-md-2 float-right text-light pt-2" style="font-size: larger;">
	  		<a href="ajax.php?action=logout" class="text-light"><?php echo $_SESSION['login_name'] ?> <i class="fa fa-power-off"> </i></a>
	    </div>
    </div>
  </div>
  
</nav>