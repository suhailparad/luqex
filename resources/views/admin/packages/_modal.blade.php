<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Manage Package</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Package Name</label>
                    <input type="text" name="name" autofocus class="form-control" placeholder="enter package name" required />
                    <input type="hidden" name="_id" />
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="5" placeholder="enter package description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" placeholder="enter package price" name="price" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save" class="btn btn-primary" >Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>