<!-- Delete -->
<div class="modal fade" id="delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Deleting...</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="products_delete.php">
          <input type="hidden" class="prodid" name="id">
          <div class="text-center">
            <p>DELETE PRODUCT</p>
            <h2 class="bold name"></h2>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i> Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Edit Product</b></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="products_edit.php">
          <input type="hidden" class="prodid" name="id">
          <div class="form-group">
            <label for="edit_name" class="col-sm-1 control-label">Name</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" id="edit_name" name="name">
            </div>

            <label for="edit_category" class="col-sm-1 control-label">Category</label>

            <div class="col-sm-5">
              <select class="form-control" id="edit_category" name="category">
                <option selected id="catselected"></option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label for="edit_price" class="col-sm-1 control-label">Price</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" id="edit_price" name="price" pattern="[0-9]*"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');">
            </div>
          </div>
          <p><b>Description</b></p>
          <div class="form-group">
            <div class="col-sm-12">
              <textarea id="editor2" name="description" rows="10" cols="80"></textarea>
            </div>

          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
          Update</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- add -->
<div class="modal fade" id="add">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><b>Add Stock</b></h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="products_addstock.php">
          <input type="hidden" class="prodid" name="id">
          <div class="form-group">
            <label for="product_name" class="col-sm-1 control-label">Name</label>

            <div class="col-sm-5">
              <input type="text" class="form-control" id="product_name" name="name" disabled>
            </div>
          </div>
          <div class="form-group">
            <label for="new_price" class="col-sm-2 control-label">New Price</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="new_price" name="new_price" pattern="[0-9]*"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            </div>
          </div>
          <div class="form-group">
            <label for="new_stock" class="col-sm-2 control-label">New Stock</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="new_stock" name="new_stock" pattern="[0-9]*"
                oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
            </div>
          </div>
          <div class="form-group">
            <label for="expiry_date" class="col-sm-2 control-label">Expiry Date</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
            class="fa fa-close"></i> Close</button>
        <button type="submit" class="btn btn-success btn-flat" name="add"><i class="fa fa-check-square-o"></i>
          Add Stock</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var expiryDateInput = document.getElementById('expiry_date');

    // Function to format date to YYYY-MM-DD
    function formatDate(date) {
      var day = String(date.getDate()).padStart(2, '0');
      var month = String(date.getMonth() + 1).padStart(2, '0');
      var year = date.getFullYear();
      return year + '-' + month + '-' + day;
    }

    // Set min attribute for expiry_date
    if (expiryDateInput) {
      var today = new Date();
      expiryDateInput.setAttribute('min', formatDate(today));
    }
  });
</script>