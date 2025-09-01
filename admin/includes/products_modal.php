<!-- Description -->
<div class="modal fade" id="description">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
                <p id="desc"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Add New Product Modal -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b>Add New Product</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="products_add.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="category" class="col-sm-3 control-label">Category</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="category" name="category_id" required>
                                <option label="Category"></option>
                                <!-- Options for categories -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subcategory" class="col-sm-3 control-label">Subcategory</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="subcategory" name="subcategory_id" required>
                                <!-- Options will be populated by getSubCategory() -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-3 control-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="price" name="price" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="photo" class="col-sm-3 control-label">Photo</label>
                        <div class="col-sm-9">
                            <input type="file" id="photo" name="photo">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description" class="col-sm-3 control-label">Description</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="description" name="description" rows="4"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantity" class="col-sm-3 control-label">Quantity</label>
                        <div class="col-sm-9">
                            <input type="number" class="form-control" id="quantity" name="quantity" pattern="[0-9]*"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="expiration_date" class="col-sm-3 control-label">Expiration Date</label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="expiration_date" name="expiration_date"
                                required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal">
                    <i class="fa fa-close"></i> Close
                </button>
                <button type="submit" class="btn btn-primary btn-flat" name="add">
                    <i class="fa fa-save"></i> Save
                </button>
            </div>
            </form>
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
                <h4 class="modal-title"><b><span class="name"></span></b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="products_photo.php" enctype="multipart/form-data">
                    <input type="hidden" class="prodid" name="id">
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
                <button type="submit" class="btn btn-success btn-flat" name="upload"><i
                        class="fa fa-check-square-o"></i> Update</button>
                </form>
            </div>
        </div>
    </div>
</div>