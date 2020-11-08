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
        
                        <div class="card">
                            <div class="card-header"><h3>Group Info</h3></div>
                            <div class="card-body">

            <form class="form-horizontal" role="form" action="<?php echo site_url('Group/MargeSave') ?>" method="POST">   
            <?php foreach($last as $l){?><input type="hidden" name="GroupId" value="<?= $l['group_id']+1;?>"/><?php }  ?>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Group Name</label>
                    <div class="col-sm-10">
                        <input type="text" id="gnm" name="gnm" placeholder="Group Name" class="form-control" Value="<?= $name?>" autofocus required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Members</label>
                    <div class="col-sm-10">
                            

                            <table class="table">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th>Member Name</th>
                                <th>Member Email</th>
                                <th><input type="checkbox" id="select_all"/> Selecct All</th>

                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach($kosong as $m): ?>
                                <tr>
                                    <td></td>
                                    <td><?= $m['member_name'] ?></td>
                                    <td><?= $m['member_email'] ?></td>
                                    <td><input class="checkbox" type="checkbox" name="check[]" value="<?= $m['member_id'] ?>"></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            </table>
                    </div>
             
                    
                </div>
                <div class="form-group">
                <div class="col-sm-10 float-right">
                        <button type="submit" class="btn btn-primary "  >Marge</button>
                        <a id="cancle" class="btn btn-light" href="<?php echo base_url();?>">Cancle</a>
                    </div>
                
                </div>


                </div>
                        </div>
                </form>
        </div> <!-- ./container -->



        <script type="text/javascript">
        var select_all = document.getElementById("select_all"); //select all checkbox
        var checkboxes = document.getElementsByClassName("checkbox"); //checkbox items

        //select all checkboxes
        select_all.addEventListener("change", function(e){
            for (i = 0; i < checkboxes.length; i++) { 
                checkboxes[i].checked = select_all.checked;
            }
        });


        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
                //uncheck "select all", if one of the listed checkbox item is unchecked
                if(this.checked == false){
                    select_all.checked = false;
                }
                //check "select all" if all checkbox items are checked
                if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
                    select_all.checked = true;
                }
            });
        }
        </script>
   
</body>
</html>