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
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/plugins/datepick/jquery.datetimepicker.css'?>" >
        <script src="<?php echo base_url().'assets/plugins/datepick/jquery.js'?>"></script>
        <script src="<?php echo base_url().'assets/plugins/datepick/build/jquery.datetimepicker.full.min.js'?>"></script>

</head>
<body>
<nav class="navbar navbar-default">
      <div class="container-fluid">
         
          <center>
              <h1> Agenda Rapat Program Studi </h1>
          </center>
      </div>
    </nav> 

 

<aside class="col-sm-2 ">
    <div class="card">
        <article class="card-group-item>">
            <div class="card-body">
				<label class="col-sm-12">
				  <span class="form-check-label"><a href="<?php echo site_url('calendar');?>" class="btn btn-success  col-sm-12"> Calendar</a></span>
				</label>
            </div>
        </article>
        <article class="card-group-item>">
            <header class="card-header"><h6 class="title">Todays Meeting</h6></header>
            <div class="filter-content">
                <div class="list-group list-group-flush"><?php if($jum==0){ ?>
                <a class="list-group-item">No Meeting Today</a><?php }else{ foreach($meeting_now as $gn){?>
                    <a href="<?php echo site_url('Event/id/'.$gn['meeting_id']);?>" class="list-group-item"><?= $gn['meeting_name']?></a>

                <?php  } }?>
                </div>
            </div>
        </article>
        <article class="card-group-item>">
            <header class="card-header"><h6 class="title">This Weeks Meeting</h6></header>
            <div class="filter-content">
            <div class="list-group list-group-flush"><?php if($jumweek==0){ ?>
                <a class="list-group-item">No Meeting This Week</a><?php }else{ foreach($meeting_week as $gn){?>
                    <a  href="<?php echo site_url('Event/id/'.$gn['meeting_id']);?>" class="list-group-item"><?= $gn['meeting_name']?></a>

                <?php  } }?>
                </div>
            </div>
        </article>
    </div>
</aside>
        <div class="container">
        <div class="form-horizontal" >
                        <div class="card">
                            <div class="card-header"><h3>Event Detail</h3></div>
                            <div class="card-body">
            
  
            <div class="row">
                <div class="col-lg-6">
                <?php foreach($meetings as $q){ ?>     
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php echo $q['meeting_name']; ?>" id="event-title" placeholder="Meeting Name" class="form-control"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName" class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                    <?php foreach($group_name as $p){ if($q['group_id']==$p['group_id']){ ?>
                        <input type="text" value="<?php echo $p['group_name']; ?>" id="group" placeholder="Alternatif Place" class="form-control"  readonly>
                    <?php }} ?>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Place </label>
                    <div class="col-sm-10">
                        <input type="text" id="place" value="<?php echo $q['meeting_place']; ?>"  placeholder="Alternatif Place" class="form-control"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Meeting Date</label>
                    <div class="col-sm-10">
                    <input type="text" id="event-start-time" value="<?php echo $q['meeting_date']; ?>" name= "event-start-time" placeholder="Meeting Start Time" autocomplete="off" class="form-control" readonly/>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Start Time</label>
                    <div class="col-sm-10">
                    <input type="text" id="event-start-time" value="<?php echo $q['meeting_start']; ?>" name= "event-start-time" placeholder="Meeting Start Time" autocomplete="off" class="form-control" readonly/>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">End Time</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-end-time" value="<?php echo $q['meeting_end']; ?>" name= "event-end-time" placeholder="Meeting End Time" class="form-control"  readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="textarea" name="event-description" placeholder="Meeting Description" class="form-control"  readonly> 
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-10 float-right">
                    <a  class="btn btn-primary " href="<?php echo site_url('Event/editEvent/'.$q['meeting_id']);?>" >Edit</a>
                    <a id="cancle" class="btn btn-danger" href="<?php echo site_url('Event/Delete/'.$q['meeting_id']);?>">Delete</a>
                    </div>
                </div>
                <?php } ?>
            </div>
                <div class="col-lg-6">
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Attendess</label>
                    <div class="col-sm-10">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th style="width:10%;">No</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($att as $a){ ?>
                                <tr>
                                <td></td>
                                <td><?= $a['member_name'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                
                    </div>
                </div>
                </div>
            </div>
                        </div>
                        
                        </div>

                
                    </div>
                    

                    </div> <!-- /form -->
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