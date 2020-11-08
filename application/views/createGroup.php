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
        <form class="form-horizontal" role="form" action="<?php echo site_url('Group/create') ?>" method="POST">
                        <div class="card">
                            <div class="card-header"><h3>Group Info</h3></div>
                            <div class="card-body">

                            <?php foreach($last as $l){?><input type="hidden" name="GroupId" value="<?= $l['group_id']+1;?>"/><?php }  ?>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Group Name</label>
                    
                    <div class="col-sm-10">
                        <input type="text" id="group" name="group" placeholder="Group Name" class="form-control"  autofocus required> 
                    </div>
                    
                </div>
                	
            <input type="hidden" id="numbRows" value="0"> 
                <div class="form-group" >
                    <label for="firstName" class="col-sm-2 control-label">Members</label>
                    <div class="col-sm-10">
                        <div id="row_dinamis">
                        <div class="row form-group">
                            <div class="col-sm-5">
                                <input type="text" id="name[]" name="name[]" placeholder="Member Name" class="form-control" autofocus>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" id="email[]" name="email[]" placeholder="Member Email" class="form-control" autofocus>
                            </div>
                            <div class="col-sm-2"><button type="button" onclick="addrow()" class="btn btn-success">Tambah</button></div>
                        </div>
                        </div>
                    </div>   
                </div>
                <div class="form-group">
                    <span class="col-sm-2"></span>
                    
                    <span class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <a href="<?php echo site_url('calendar') ?>" class="btn btn-light">cancle</a>
                        </span>
                    </div>
        </div> 
        </div>
        </form>
        </div>

<script type="text/javascript">
function addrow()
    {
        var no = parseInt($('#numbRows').val());
        var html='';
        
        $('#numbRows').val(no+1);
        
        html +='<div class="row form-group" id="rowContent'+ $('#numbRows').val()+'">';
             html +='<div class="col-md-5">';
                html +='<input type="text" id="name[]" name="name[]" placeholder="Member Name" class="form-control" autofocus>';
            html +='</div>';
            html +='<div class="col-md-5">';
                html +='<input type="text" id="email[]" name="email[]" placeholder="Member Email" class="form-control" autofocus>';
            html +='</div>';
            html +='<div class="col-md-2"> <button type="button" onclick="removeRow('+$('#numbRows').val()+')" class="btn btn-danger">Hapus</button></div>';
        html +='</div>';
 
        $('#row_dinamis').append(html);

    } 
    

 function removeRow(no)
    {
        var cek = parseInt($('#numbRows').val());
        if (cek != 0) {
            $('#numbRows').val(cek - 1);
        }
        $('#rowContent' + no).remove();
    } 
</script>  
</body>
</html>