<!-- Add -->
<div class="modal fade" id="profile">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Veterinarian Profile</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="profile_edit.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-9">
              <input type="password" class="form-control" id="password" name="password"
                value="<?php echo $user['password']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">Firstname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname"
                value="<?php echo $user['firstname']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Lastname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname"
                value="<?php echo $user['lastname']; ?>">
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Profile</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" value="<?php echo $user['profile']; ?>">
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label for="curr_password" class="col-sm-3 control-label">Current Password:</label>

            <div class="col-sm-9">
              <input type="password" class="form-control" id="curr_password" name="curr_password"
                placeholder="input current password to save changes" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
          Save</button>
        </form>
      </div>
    </div>
  </div>
</div>