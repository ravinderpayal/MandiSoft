<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view("header_common.php"); ?>
    <body>
        <style>
            th,td{padding:5px;}
        </style>
     <?php $this->load->view("admin_menu.php"); ?>
        <div class="container">
            <canvas id="myChart" style=" width:90%;height:60%;" width="1100" height="500"></canvas>
<script src="<?php echo  $this->config->item('base_directory'); ?>media/dist/Chart.bundle.js"></script>
<script>     var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        var randomScalingFactor = function() {
            return (Math.random() > 0.5 ? 1.0 : -1.0) * Math.round(Math.random() * 100);
        };
        var randomColorFactor = function() {
            return Math.round(Math.random() * 255);
        };
        var randomColor = function() {
            return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',.7)';
        };

        var ChartData = {
            labels:[ <?php echo $daywiseSaledates; ?>],
            datasets: [{
                label: 'Sales',
                backgroundColor: "rgba(220,20,20,0.4)",
                data:[ <?php echo $daywiseSaleAmount; ?>]
            }, {
                label: 'Collection',
                backgroundColor: "rgba(51,187,25,0.5)",
                data:[ <?php echo $daywisePaymentAmount; ?>]
            }]

        };

        window.onload = function() {
            var ctx = document.getElementById("myChart").getContext("2d");
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: ChartData,
                options: {
                    // Elements options apply to all of the options unless overridden in a dataset
                    // In this case, we are setting the border of each bar to be 2px wide and green
                    elements: {
                        rectangle: {
                            borderWidth: 2,
                            borderColor: 'rgb(0, 255, 0)',
                            borderSkipped: 'bottom'
                        }
                    },
                    responsive: false,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Report'
                    }
                }
            });

        };</script>            <?php
           /* $this->load->view("sale/sale_nav");*/
            $this->load->view("reports/sale_reports");
            $this->load->view("reports/payment_reports");
            $this->load->view("reports/defaulters");
            ?>
            
       </div>
    </body>
</html>