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

    <?php $this->load->view('sidebar') ?>
        <div class="container">
        <form class="form-horizontal" role="form">
                        <div class="card">
                            <div class="card-header"><h3>Create New Event</h3></div>
                            <div class="card-body">
            
       
            
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-title" placeholder="Meeting Name" class="form-control" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName" class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                    <select id="prodi_name" name="prodi_name" class="form-control form-control-lg" onchange="cek(this.value)">
                    <option value="" selected>--Select Group--</option>
                    <?php foreach($group_name as $row):?>
                        <option value="<?php echo $row['group_id'];?>"><?php echo $row['group_name'];?></option>
                        <?php endforeach;?>
                    </select>
                    </div>
                </div>
                <div class="form-group " id="att" >
                
                
                                
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Place </label>
                    <div class="col-sm-10">
                        <select id="event-place" class="form-control form-control-lg" name= "event-place" onchange="place(this.value)">
                            <option value="" selected>--Take Place--</option>
                            <option value="Ruang Prodi Teknik Informatika">Ruang Prodi Teknik Informatika</option>
                            <option value="Ruang Prodi Teknik kimia">Ruang Prodi Teknik Kimia</option>
                            <option value="Ruang Prodi Teknik Elektro">Ruang Prodi Teknik Elektro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Other Place</label>
                    <div class="col-sm-10">
                        <input type="text" id="other" placeholder="Alternatif Place" class="form-control" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Start Time</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-start-time" name= "event-start-time" placeholder="Meeting Start Time" class="form-control" autofocus>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">End Time</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-end-time" name= "event-end-time" placeholder="Meeting Start Time" class="form-control" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="textarea" name="event-description" placeholder="Meeting Description" class="form-control" autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 float-right">
                    <button type="submit" class="btn btn-primary "  >Create</button>
                    <a id="cancle" class="btn btn-light" href="<?php echo base_url();?>">Cancle</a>
                    </div>
                </div>
                        </div>
                        
                        </div>
                
                    </div>
                    
                    
            </form> <!-- /form -->
        </div> <!-- ./container -->
    <script type="text/javascript">
        $(document).ready(function(){
 
            $('#prodi_name').change(function(){ 
                var id=$(this).val();
                $.ajax({
                    url : "<?php echo site_url('CreateEvent/getattendess');?>",
                    method : "POST",
                    data : {id: id},
                    async : true,
                    dataType : 'json',
                    success: function(data){
                         
                        
                        var html = '';
                        if (data=="") {
                            html='';
                        }else{
                        html += '<label for="lastName" class="col-sm-2 control-label">Attendess</label><div class="col-sm-10"><table id="example" class="display" style="width:100%"><thead><tr><th>Member Name</th><th>Member Email</th><th>Select All<input type="checkbox" id="checkAll"></th></tr></thead><tbody>'
                                    
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<tr><td name="nama[]">'+data[i].member_name+'</td><td name="email[]">'+data[i].member_email+'</td><td><input type="checkbox" name="member[]" id="member[]" value="'+data[i].member_email+'"></td></tr>';
                        }
                        html +='</tbody></table></div>'}
                        $('#att').html(html);
 
                    }
                });
                return false;
            }); 
            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
             
        });
    </script>
</body>
</html>