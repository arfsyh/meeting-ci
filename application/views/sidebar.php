<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


<aside class="col-sm-2 ">
    <div class="card">
        <article class="card-group-item>">
            <div class="card-body">
				<label class="col-sm-12">
				  <span class="form-check-label"><a href="<?php echo site_url('Coba');?>" class="btn btn-success  col-sm-12"> Create Event</a></span>
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

