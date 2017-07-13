<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title><?php if(isset($page_title))echo $page_title; ?>MandiSoft - SabziMandi Management System</title>
        <link href="<?php echo $this->config->item('base_directory'); ?>media/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('base_directory'); ?>media/jquery-ui/jquery-ui.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('base_directory'); ?>media/css/fne_icon.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('base_directory'); ?>media/css/basic.css" rel="stylesheet">
        <script src="<?php echo $this->config->item('base_directory'); ?>media/jquery.min.js"></script>
        <script>
            var base_url = '<?php echo base_url(); ?>';
        </script>
        <style>
            @font-face {
                font-family: 'mangal';
                src:url('<?php echo base_url(); ?>media/mangal.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;
            }

             .error,.message{
                padding:5px;
                margin:auto;
                width:50%;
              }
              .error{
                background:#E13300;
                color:#eee;
              }
              .message{
                background:#5cb85c;
                color:#eee;
              }
              .only_Printable{
                  display:none;
              }
              table{
                  background:#fff;
              }
             @media print {
                .no-print {
                    display: none !important;
                      }
                a:link{
                          display:none;
                      }
                .only_Printable{
                  display:initial !important;
                }

                }
        </style>
        <script src="<?php echo $this->config->item('base_directory'); ?>media/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('base_directory'); ?>media/jquery-ui/jquery-ui.js"></script>
    </head>