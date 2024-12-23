<?php 
$records = getUserRecords();
$utype = '';
$type = $_SESSION['calendar_fd_user']['type'];
if($type == 'admin' || $type == 'owner') {
	$utype = 'on';
}
?>

<div class="col-md-12">
  <div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Attendees details</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <table class="table table-bordered">
        <tr>
          <th style="width: 10px">Sl. No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Task</th>
          <th>User Role</th>
          <th style="width: 100px">Task Status</th>
          <?php if($utype == 'on') { ?>
		  <th>Action</th>
		  <?php } ?>
        </tr>
        <?php
	  $idx = 1;
	  foreach($records as $rec) {
	  	extract($rec);
		$stat = '';
		if($status == "active") {$stat = 'success';}
		else if($status == "lock") {$stat = 'warning';}
		else if($status == "inactive") {$stat = 'warning';}
    else if($status == "completed") {$stat = 'success';}
    else if($status == "pending") {$stat = 'warning';}
    else if($status == "unlock") {$stat = 'success';}
    else if($status == "unknown") {$stat = 'danger';}
		?>
        <tr>
          <td><?php echo $idx++; ?></td>
          <td><a href="<?php echo WEB_ROOT; ?>views/?v=USER&ID=<?php echo $user_id; ?>"><?php echo strtoupper($user_name); ?></a></td>
          <td><?php echo $user_email; ?></td>
          <td><?php echo $user_phone; ?></td>
          <td><?php echo $task; ?></td>

         
          <td>
		  <i class="fa <?php echo $type == 'owner' ? 'fa-user' : 'fa-users' ; ?>" aria-hidden="true"></i>&nbsp;&nbsp;<?php echo strtoupper($type); ?></i></td>
          <td><span class="label label-<?php echo $stat; ?>"><?php echo strtoupper($status); ?></span></td>
          <?php if($utype == 'on') { ?>
		  <td><?php if($status == "active") {?>
            <a href="javascript:status('<?php echo $user_id ?>', 'inactive');">Inactive</a>&nbsp;/
			&nbsp;<a href="javascript:status('<?php echo $user_id ?>', 'unknown');">Do not exists</a>&nbsp;/&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'lock');">Account Lock</a>&nbsp;/&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'completed');">Completed</a>&nbsp;/
			&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'pending');">Pending</a>&nbsp;/
      &nbsp;
            <?php } 
      else if ($status == "lock") { ?>
    <a href="javascript:status('<?php echo $user_id ?>', 'unlock');">Unlock</a>&nbsp;&nbsp;
    <?php } 

else if ($status == "unlock") { ?>
<a href="javascript:status('<?php echo $user_id ?>', 'active');">Active</a>&nbsp;/
  <a href="javascript:status('<?php echo $user_id ?>', 'inactive');">Inactive</a>&nbsp;/
			&nbsp;<a href="javascript:status('<?php echo $user_id ?>', 'unknown');">Do not exists</a>&nbsp;/&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'lock');">Account Lock</a>&nbsp;/&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'completed');">Completed</a>&nbsp;/
			&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'pending');">Pending</a>&nbsp;/
      &nbsp;
      <?php } 

      else if ($status == "completed") { ?>
  
      <a>Completed</a>&nbsp;
      &nbsp;
      <?php } 
      else if ($status == "pending") { ?>
        <a href="javascript:status('<?php echo $user_id ?>', 'inactive');">Inactive</a>&nbsp;/
			&nbsp;<a href="javascript:status('<?php echo $user_id ?>', 'unknown');">Do not exists</a>&nbsp;/
			&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'lock');">Account Lock</a>&nbsp;/&nbsp;
      <a href="javascript:status('<?php echo $user_id ?>', 'completed');">Completed</a>&nbsp;/
			&nbsp;
        &nbsp;
  <?php } 
  else if ($status == "inactive") { ?>
    &nbsp;
    <a href="javascript:status('<?php echo $user_id ?>', 'active');">Active</a>&nbsp;/
    <a href="javascript:status('<?php echo $user_id ?>', 'unknown');">Do not exists</a>&nbsp;/
    &nbsp;
    <a href="javascript:status('<?php echo $user_id ?>', 'pending');">Pending</a>&nbsp;
    &nbsp;
    <?php } 
    else if ($status == "unknown") { ?>
      &nbsp;
      <a>Not Found</a>&nbsp;
      &nbsp;
      <?php } 

            
            //else ?>
          </td>
		  <?php }?>
        </tr>
        <?php } ?>
      </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer clearfix">
	
	<?php 
	$type = $_SESSION['calendar_fd_user']['type'];
	if($type == 'admin') {
	?>
	<button type="button" class="btn btn-info" onclick="javascript:createUserForm();"><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;Create a new User</button>
	<?php 
	}
	?>
      <!--
	<ul class="pagination pagination-sm no-margin pull-right">
      <li><a href="#">&laquo;</a></li>
      <li><a href="#">1</a></li>
      <li><a href="#">2</a></li>
      <li><a href="#">3</a></li>
      <li><a href="#">&raquo;</a></li>
    </ul>
	-->
      <?php echo generatePagination(); ?> </div>
  </div>
  <!-- /.box -->
</div>

<script language="javascript">
function createUserForm() {
	window.location.href = '<?php echo WEB_ROOT; ?>views/?v=CREATE';
  
}
function status(userId, status, task = null) {
    const taskParam = task ? `&task=${encodeURIComponent(task)}` : '';
    if (confirm(`Are you sure you want to ${status} this user?`)) {
        window.location.href = `../views/process.php?cmd=change&action=${status}&userId=${userId}${taskParam}`;
    }
}



</script>
