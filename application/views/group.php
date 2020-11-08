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
                    
                            <?php foreach($group as $g):?>
                                <label for="firstName" class="control-label "><h3><?= $g['group_name']; ?>&nbsp;<i class="fas fa-edit" data-toggle="modal" data-target="#edit<?= $g['group_id'] ?>"></i>&nbsp; <i class="fas fa-trash-alt" data-toggle="modal" data-target="#Delgruop<?= $g['group_id'] ?>"></i></h3>
                            
                            </label>

                            <!-- Modal Del Group -->
                            <div class="modal fade" id="Delgruop<?= $g['group_id'] ?>" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    
                                                    <h4 class="modal-title">Delete Member</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="<?php echo site_url('Group/Delgroup') ?>" method="POST">
                                                    
                                                            <div class="form-group" >
                                                                <div class="col-sm-12">

                                                                    <input type="hidden" name="GroupId" value="<?= $g['group_id']; ?>"/>
                                                           
                                                                
                                                                     <p> Anda yakin ingin menghapus Group <b><?= $g['group_name'] ?></b> ?</p>
                                                                     </div>
                                                            </div>   
                                                            

                                                    </div>
                                                    <div class="modal-footer">
                                                    <button class="btn btn-danger">Delete</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>



                                            <!-- Modal Edit Name Group -->
                                        <div class="modal fade" id="edit<?= $g['group_id'] ?>" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="<?php echo site_url('Group/EditGroupName') ?>" method="POST">
                                                    
                                                            <div class="form-group" >
                                                                <div class="col-sm-12">

                                                                    <input type="hidden" name="GroupId" value="<?= $g['group_id']; ?>"/>
                                                           
                                                                
                                                                     <input type="text" name="name" id="name" class="form-control" value="<?= $g['group_name']; ?>" required/>
                                                                     </div>
                                                            </div>   
                                                            

                                                    </div>
                                                    <div class="modal-footer">
                                                    <button class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>


                            <?php endforeach; ?>
                            <div class="container">
                            <label class=" control-label col-sm-2">
                            <a href="<?php ?>" class="btn btn-success  col-sm-12" data-toggle="modal" data-target="#exampleModal"> Add Member</a>
                            </label>
                            <form class="form-horizontal" role="form">
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
                                    <td><a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#Edit<?= $m['member_id'] ?>">Edit</a><span>&nbsp;</span><a data-toggle="modal" data-target="#Delete<?= $m['member_id'] ?>" class="btn btn-danger btn-sm">Delete</a></td>
                                </tr>

                                <!-- Modal Edit -->
                                <div class="modal fade" id="Edit<?= $m['member_id'] ?>" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Member</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        
                                    <form action="<?php echo site_url('Group/Editmember') ?>" method="POST">
                                    <input type="hidden" value="<?= $m['member_id'] ?>" name="id">
                                    <?php foreach($group as $g):?>
                                    <input type="hidden" value=<?= $g['group_id'] ?> name="GroupId">
                                    <?php endforeach; ?>

                                                <div class="form-group" >
                                                    <div class="col-sm-12">
                                                        <div class="row form-group">
                                                            <div class="col-sm-6">
                                                                <input type="text" id="editname" name="editname" value="<?= $m['member_name'] ?>" placeholder="Member Name" class="form-control" autofocus autocomplete="off" required>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input type="text" id="editemail" name="editemail" value="<?= $m['member_email'] ?>" placeholder="Member Email" class="form-control" autofocus autocomplete="off" required>
                                                            </div>
                                                    
                                                        </div>
                                                        </div>
                                                    </div>   
                                                

                                        </div>
                                        <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                </form>
                                    </div>
                                    </div>
                                </div>



                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="Delete<?= $m['member_id'] ?>" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    
                                                    <h4 class="modal-title">Delete Member</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                    <form action="<?php echo site_url('Group/Delete') ?>" method="POST">
                                                    
                                                            <div class="form-group" >
                                                                <div class="col-sm-12">

                                                                <?php foreach($group as $g):?>
                                                                    <input type="hidden" name="GroupId" value="<?= $g['group_id']; ?>"/>
                                                                <?php endforeach; ?>
                                                                <input type="hidden" name="memberID" value="<?= $m['member_id'] ?>">
                                                                     <p> Anda yakin ingin menghapus <b><?= $m['member_name'] ?></b> dari Group ?</p>
                                                                     </div>
                                                            </div>   
                                                            

                                                    </div>
                                                    <div class="modal-footer">
                                                    <button class="btn btn-danger">Delete</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                    </form>
                                                </div>
                                                </div>
                                            </div>






                                <?php endforeach; ?>
                            </tbody>
                            </table>
                            </div>
                            </form>
                    
             
                    
                </div>
                
        </div> <!-- ./container -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Member</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <form action="<?php echo site_url('Group/AddMember') ?>" method="POST">
                                        <?php foreach($group as $g):?>
                                            <input type="hidden" name="GroupId" value="<?= $g['group_id']; ?>"/>
                                        <?php endforeach; ?>
                                        <input type="hidden" id="numbRows" value="0"> 
                                                    <div class="form-group" >
                                                        <div class="col-sm-12">
                                                            <div id="row_dinamis">
                                                            <div class="row form-group">
                                                                <div class="col-sm-5">
                                                                    <input type="text" id="name[]" name="name[]" placeholder="Member Name" class="form-control" autofocus required autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <input type="text" id="email[]" name="email[]" placeholder="Member Email" class="form-control" autofocus required autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-2"><button type="button" onclick="addrow()" class="btn btn-success">Tambah</button></div>
                                                            </div>
                                                            </div>
                                                        </div>   
                                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary" id="add" name="add">Add</button>
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                        
                                        </form>
                                    </div>
                                    </div>
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