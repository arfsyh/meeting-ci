<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


<aside class="col-sm-2">
    <div class="card">
        <article class="card-group-item>">
            <div class="card-body">
            <label class="col-sm-12">
				  <span class="form-check-label"><a href="<?php echo site_url('calendar');?>" class="btn btn-success  col-sm-12"> Calendar</a></span>
				</label>
            <label class="col-sm-12">
				  <span class="form-check-label"><a href="<?php echo site_url('group');?>" class="btn btn-primary  col-sm-12"> Create Group</a></span>
				</label>
                <label class="col-sm-12">
				  <span class="form-check-label"><a class="btn btn-light col-sm-12" data-toggle="modal" data-target="#Marge"> Marge Group</a></span>
				</label>
            </div>
        </article>
        <br>
        <article class="card-group-item>">
            <header class="card-header"><h6 class="title">Group List</h6></header>
            <div class="filter-content">
                <div class="list-group list-group-flush">
                    <?php foreach($group_name as $gn):?>
                    <a href="<?php echo site_url('Group/id/'.$gn['group_id'].'');?>" class="list-group-item"><?= $gn['group_name']?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </article>
    </div>

</aside>

            <div class="modal fade" id="Marge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Marge Group</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        
                                        <form action="<?php echo site_url('Group/marge') ?>" method="POST">
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">Group Name</label>
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Group Name">
                                            </div>
                                            <div class="form-group">
                                                <label for="formGroupExampleInput">Select to Marge</label></div>
                                            <?php foreach($group_name as $gn):?>
                                            <div class="form-group">
                                                <label for="firstName" class="col-sm-1 control-label"><input class="form-check-input float-right" type="checkbox" value="<?= $gn['group_id']?>" id="gm[]" name="gm[]"></label>
                                                <div class="col-sm-11">
                                                <label class="form-check-label" for="defaultCheck1">
                                                        <?= $gn['group_name']?>
                                                        </label>
                                                     </div>
                                                </div> 
                                                <?php endforeach ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" name="mg" id="mg" class="btn btn-primary">Marge</button>
                                        
                                        </form>
                                    </div>
                                    </div>
                                </div>
            </div>

<script type="text/javascript">

$('#mg').click(function() {
                checked = $("input[type=checkbox]:checked").length;

                if(!checked) {
                    alert("You must check at least one checkbox.");
                    return false;
                }

            });
</script>