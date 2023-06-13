<style>
    table {
        width: 80%;
        border-collapse: collapse;
        border: 1px solid black;
        margin-left: 5rem;
    }

    tr,td,th{
        padding-left: 5;
        border: 1px solid black;
    }

    .text-center {
        text-align: center;
    }
</style>
<?php include('db_connect.php') ?>
<?php
$pay = $conn->query("SELECT * FROM payroll where id = " . $_GET['id'])->fetch_array();
// $pt = array(1=>"Monhtly",2=>"Semi-Monthly");
?>
<div>
    <h2 class="text-center">Payroll -
        <?php echo $pay['ref_no'] ?>
    </h2>
    <hr>
</div>
<table>
    <thead>
        <?php
        $payroll = $conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no,e.salary FROM payroll_items p inner join employee e on e.id = p.employee_id ") or die(mysqli_error());
        while ($row = $payroll->fetch_array()) {
            ?>
            <tr>
                <th> Employee ID</th>
                <td>
                    <?php echo $row['employee_no'] ?>
                </td>
            </tr>
            <tr>
                <th> Employee Name</th>
                <td>
                    <?php echo ucwords($row['ename']) ?>
                </td>
            </tr>
            <tr>
                <th> Weekly Salary</th>
                <td>
                    <?php echo number_format($row['salary'], 2) ?>
                </td>
            </tr>
            <tr>
                <th> Absent</th>
                <td>
                    <?php echo $row['absent'] ?>
                </td>
            </tr>

            <tr>
                <th> Tardy/Undertime(mins)</th>
                <td>
                    <?php echo $row['late'] ?>
                </td>
            </tr>

            <tr>
                <th>Total Allowance</th>
                <td>
                    <?php echo number_format($row['allowance_amount'], 2) ?>
                </td>
            </tr>

            <tr>
                <th> Total Deduction</th>
                <td>
                    <?php echo number_format($row['deduction_amount'], 2) ?>
                </td>
            </tr>

            <tr>
                <th> Net Pay</th>
                <td>
                    <?php echo " " . number_format($row['net'], 2) ?>
                </td>
            </tr>
        </thead>
        <?php
        }
        ?>
    </tbody>
</table>