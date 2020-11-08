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
                    <a href="<?php echo base_url('Event/id/'.$gn['meeting_id']);?>" class="list-group-item"><?= $gn['meeting_name']?></a>

                <?php  } }?>
                </div>
            </div>
        </article>
        <article class="card-group-item>">
            <header class="card-header"><h6 class="title">This Weeks Meeting</h6></header>
            <div class="filter-content">
            <div class="list-group list-group-flush"><?php if($jumweek==0){ ?>
                <a class="list-group-item">No Meeting This Week</a><?php }else{ foreach($meeting_week as $gn){?>
                    <a  href="<?php echo base_url('Event/id/'.$gn['meeting_id']);?>" class="list-group-item"><?= $gn['meeting_name']?></a>

                <?php  } }?>
                </div>
            </div>
        </article>
    </div>
</aside>


        <div class="container">
        <form class="form-horizontal" action="<?= site_url('Event/Update');?>" method="POST" role="form">
                        <div class="card">
                            <div class="card-header"><h3>Edit Event</h3></div>
                            <div class="card-body">
            
                            <?php foreach($meetings as $q){ ?>
                                <input type="hidden" name="mi" value="<?= $q['meeting_id'] ?>"/>
            
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Title</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-title" name="event-title" value="<?= $q['meeting_name']; ?> " placeholder="Meeting Name" class="form-control" autofocus autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="lastName" class="col-sm-2 control-label">Group</label>
                    <div class="col-sm-10">
                    <select id="prodi_name" name="prodi_name" class="form-control form-control-lg" >
                    <option value="" >--Select Group--</option>
                    <?php foreach($group_name as $row):
                        if($q['group_id']==$row['group_id']){ ?>
                        
                        <option value="<?php echo $row['group_id'];?>" selected><?php echo $row['group_name'];?></option>
                        <?php }else{
                    ?><option value="<?php echo $row['group_id'];?>" ><?php echo $row['group_name'];?></option>
                    <?php } endforeach;?>
                    </select>
                    </div>
                </div>
                <div class="form-group " id="att" >
                
                
                                
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Place </label>
                    <div class="col-sm-10">
                    <input type="text" id="place" name="place" value="<?= $q['meeting_place']; ?>" placeholder="Alternatif Place" class="form-control" autofocus autocomplete="off" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Start Time</label>
                    <div class="col-sm-10">
                    <input type="text" id="event-start-time" name= "event-start-time" placeholder="Meeting Start Time" value="<?= $tanggal." ".$q['meeting_start']; ?>" autocomplete="off" class="form-control" required/>
                    </div>
                </div> 
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">End Time</label>
                    <div class="col-sm-10">
                        <input type="text" id="event-end-time" name= "event-end-time" placeholder="Meeting End Time" class="form-control" value="<?= $tanggal." ".$q['meeting_end']; ?>" autofocus autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="firstName" class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10">
                        <input type="textarea" name="event-description" placeholder="Meeting Description" class="form-control" autofocus>
                    </div>
                </div>
                    <?php } ?>
                <div class="form-group">
                    <div class="col-sm-10 float-right">
                    <button type="submit" class="btn btn-primary "  >Update</button>
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

            setProdi();


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
                        html += '<label for="lastName" class="col-sm-2 control-label">Attendess</label><div class="col-sm-10"><table id="example" class="display" style="width:100%"><thead><tr><th>Member Name</th><th>Member Email</th><th><input type="checkbox" id="select_all"/> Selecct All</th></tr></thead><tbody>'
                                    
                        var i;
                        for(i=0; i<data.length; i++){
                            html += '<tr><td>'+data[i].member_name+'</td><td >'+data[i].member_email+'</td><td><input class="checkbox" type="checkbox" name="email[]" value="'+data[i].member_email+'"></td></tr>';
                        }
                        html +='</tbody></table></div>'}
                        $('#att').html(html);
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
 
                    }
                });
                return false;
            }); 
           
             
        });
        

        function setProdi(){
            <?php foreach($meetings as $q): ?>var a = '<?php echo $q['group_id'];?>'<?php endforeach; ?>;
            var id=$('#prodi_name').val();
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
                        html += '<label for="lastName" class="col-sm-2 control-label">Attendess</label><div class="col-sm-10"><table id="example" class="display" style="width:100%"><thead><tr><th>Member Name</th><th>Member Email</th><th><input type="checkbox" id="select_all"/> Selecct All</th></tr></thead><tbody>'
                                    
                        var i;
                        for(i=0; i<data.length; i++){
                            var j=0;
                            for(j;j< a.length;j++){
                                if(data[i].member_id==a[j]){
                                    html += '<tr><td>'+data[i].member_name+'</td><td >'+data[i].member_email+'</td><td><input class="checkbox" type="checkbox" name="email[]" value="'+data[i].member_email+'" checked></td></tr>';
                        
                                }else{
                                    html += '<tr><td>'+data[i].member_name+'</td><td >'+data[i].member_email+'</td><td><input class="checkbox" type="checkbox" name="email[]" value="'+data[i].member_email+'"></td></tr>';
                        
                                }
                            }
                            }
                        html +='</tbody></table></div>'}
                        $('#att').html(html);
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
 
                    }
                });
                return false;
        }
    </script>
        
    <script type="text/javascript">
                jQuery('#event-start-time, #event-end-time ').datetimepicker({
                formatDate:'Y.m.d',
                minDate:0,
                step: 15,
                disabledDates:['2020.08.20','2020.08.21','2020.10.28','2020.10.29','2020.10.30','2020.11.14','2020.12.24','2020.12.25','2020.12.28','2020.12.29','2020.12.31','2021.01.01', '2021.02.12','2021.03.11','2021.03.14','2021.04.02', '2021.04.04','2021.05.01','2021.05.13', '2021.05.14','2021.05.26','2021.06.01', '2021.07.20','2021.08.10', '2021.08.17','2021.10.19','2021.11.04', '2021.12.24','2021.12.25', '2021.12.31'],
                disabledWeekDays:[0],
                timepicker:true});
                $("#event-type").on('change', function(e) {
                    if($(this).val() == 'ALL-DAY') {
                        $("#event-date").show();
                        $("#event-start-time, #event-end-time").hide();
                    }					
                    else {
                        $("#event-date").hide(); 
                        $("#event-start-time, #event-end-time").show();
                    }
                });
    </script>


</body>
</html>