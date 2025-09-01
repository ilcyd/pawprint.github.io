<!-- Add New Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Add New Subcategory</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="subcategory_add.php">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Subcategory Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category_id" class="col-sm-3 control-label">Main Category</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="category_id" name="category_id" required>
                                <?php
                                $sql = "SELECT * FROM category";
                                $query = $conn->query($sql);
                                while ($catrow = $query->fetch_assoc()) {
                                    echo "
                                        <option value='" . $catrow['id'] . "'>" . $catrow['name'] . "</option>
                                    ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="add">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Edit Subcategory</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="subcategory_edit.php">
                    <input type="hidden" class="subcatid" name="id">
                    <div class="form-group">
                        <label for="edit_name" class="col-sm-3 control-label">Subcategory Name</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_category_id" class="col-sm-3 control-label">Main Category</label>

                        <div class="col-sm-9">
                            <select class="form-control" id="edit_category_id" name="category_id" required>
                                <?php
                                $sql = "SELECT * FROM category";
                                $query = $conn->query($sql);
                                while ($catrow = $query->fetch_assoc()) {
                                    echo "
                                        <option value='" . $catrow['id'] . "'>" . $catrow['name'] . "</option>
                                    ";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="edit">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Deleting Subcategory...</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="subcategory_delete.php">
                    <input type="hidden" class="subcatid" name="id">
                    <div class="text-center">
                        <p>DELETE SUBCATEGORY</p>
                        <h2 class="bold subcatname"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>