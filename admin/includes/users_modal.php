<!-- Add -->
<div class="modal fade" id="addnew">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Add New User</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="users_add.php" enctype="multipart/form-data">
          <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>

            <div class="col-sm-9">
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>

            <div class="col-sm-9">
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
          </div>
          <div class="form-group">
            <label for="firstname" class="col-sm-3 control-label">Firstname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="lastname" class="col-sm-3 control-label">Lastname</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
          </div>
          <div class="form-group">
            <label for="address" class="col-sm-3 control-label">Address</label>

            <div class="col-sm-9">
              <textarea class="form-control" id="address" name="address"></textarea>
            </div>
          </div>
          <div class="form-group">
            <label for="contact" class="col-sm-3 control-label">Contact Info</label>

            <div class="col-sm-9">
              <input type="text" class="form-control" id="contact" name="contact">
            </div>
          </div>
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Photo</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" value="<?php echo $user['profile']; ?>">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i> Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Approve -->
<div class="modal fade" id="approve">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Confirmation</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to approve this user?</p>
        <form id="approveForm" action="users_approve.php" method="POST">
          <input type="hidden" id="approveUserId" name="id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cancel</button>
        <button type="submit" class="btn btn-success btn-flat" form="approveForm" name="approve"><i
            class="fa fa-check-square-o"></i> Approve</button>
      </div>
    </div>
  </div>
</div>


<!-- Deny -->
<div class="modal fade" id="denied">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Confirmation</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to block this user?</p>
        <form id="denyForm" action="users_deny.php" method="POST">
          <input type="hidden" id="denyUserId" name="id"> <!-- Ensure this input is inside the form -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Cancel</button>
        <button type="submit" class="btn btn-danger btn-flat" form="denyForm" name="deny"><i class="fa fa-ban"></i>
          Block</button> <!-- Specify form attribute -->
      </div>
    </div>
  </div>
</div>



<!-- Update Photo -->
<div class="modal fade" id="edit_photo">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b><span class="fullname"></span></b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="users_photo.php" enctype="multipart/form-data">
          <input type="hidden" class="userid" name="id">
          <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Photo</label>

            <div class="col-sm-9">
              <input type="file" id="photo" name="photo" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="upload"><i class="fa fa-check-square-o"></i>
          Update</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Activate -->
<div class="modal fade" id="activate">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Activating...</b></h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="users_activate.php">
          <input type="hidden" class="userid" name="id">
          <div class="text-center">
            <p>ACTIVATE USER</p>
            <h2 class="bold fullname"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="activate"><i class="fa fa-check"></i>
          Activate</button>
        </form>
      </div>
    </div>
  </div>
</div>