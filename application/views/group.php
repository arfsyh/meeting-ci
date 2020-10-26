<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8" />
        <title>Create Event</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/style.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/font-awesome/css/font-awesome.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/fullcalendar/fullcalendar.css'; ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css'; ?>">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

</head>
<body>
<nav class="navbar navbar-default">
      <div class="container-fluid">
         
          <center>
              <h1> Agenda Rapat Program Studi </h1>
          </center>
      </div>
    </nav> 

    <?php $this->load->view('sbgroup') ?>
        <div class="container">
        <form class="form-horizontal" role="form">
                        <div class="card">
                            <div class="card-header"><h3>Group Info</h3></div>
                            <div class="card-body">
                    
                            <?php foreach($group as $g):?>
                    <label for="firstName" class="control-label"><h3><?= $g['group_name']; ?></h3></label>
                            <?php endforeach; ?>

                            <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Member Name</th>
                                <th>Member Email</th>
                                <th>Action</th>

                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($member as $m): ?>
                                <tr>
                                    <td></td>
                                    <td><?= $m['member_name'] ?></td>
                                    <td><?= $m['member_email'] ?></td>
                                    <td></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                    
             
                    
                </div>
                
        </div> <!-- ./container -->
   
</body>
</html>