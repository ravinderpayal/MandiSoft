<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view("header_common.php"); ?>
    <style>
        table, th, td {
            text-align: center;       
        }
    </style>
    <body>
        <?php $this->load->view("admin_menu.php"); ?>
        <div class="container" style="margin-top: 40px;">
        <h1>Update Report</h1>
        <form action="<?php echo base_url(); ?>reports/update/<?php echo $report_id ?>" method="post">
            <table id="container">
                <tr>
                    <th>Test Name</th>
                    <th>Value</th>
                </tr>
                <?php foreach ($report as $value) { ?>
                <tr>
                    <td><input type="text" name="test[<?php echo $value->id; ?>][name]"  value="<?php echo $value->test_name; ?>" required class="form-control"/></td>
                    <td><input type="number" name="test[<?php echo $value->id; ?>][measurement]" step="any" value="<?php echo $value->test_value; ?>" required class="form-control"/></td>
                </tr>
                <?php } ?>
            </table>
            
            <div style="margin-top: 42px;"><input type="submit" value="Update Report" class="btn btn-primary"/></div>
        </form>
        
        </div>
    </body>
</html>
