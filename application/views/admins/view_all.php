<?php $this->load->view("header_common.php"); ?>
    <style>
        table, th, td {
            border: 1px solid black;
            text-align: center;
        }
    </style>
    <body>
        <?php $this->load->view("admin_menu.php"); ?>
        <div class="container" style="margin-top: 40px;">
        <h1>Admins</h1>
        <div><a href="<?php echo base_url(); ?>admins/add" class="btn btn-primary"> Add Operator</a></div>
        <table style="width:100%;">
            <tr>
                <th>username</th>
                <th>Email</th>
                <th>Phone</th>
            </tr>
            <?php foreach ($admins as $value) { ?>
                <tr>
                    <td><?php
                            echo $value->o_username;
                        ?></td>
                    <td><?php
                            echo $value->o_email;
                        ?></td>
                    <td><?php
                            echo $value->o_phone;
                        ?></td>
                </tr>
            <?php } ?> 
        </table>
        </div>
    </body>
</html>