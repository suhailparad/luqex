<!-- Modal -->
<div id="modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Manage Applications</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Application Name</label>
                    <input type="text" name="name" autofocus class="form-control" placeholder="enter application name" required />
                    <input type="hidden" name="_id" />
                </div>
                <div class="form-group">
                    <label>Application URL</label>
                    <input type="text" name="url" autofocus class="form-control" placeholder="enter application url" required />
                </div>
                <div class="form-group">
                    <label>Enabled</label>
                    <div class="switch">
                        <div class="onoffswitch">
                            <input type="checkbox" name="enableDisable" checked class="onoffswitch-checkbox" id="activate-status">
                            <label class="onoffswitch-label" for="activate-status">
                                <span class="onoffswitch-inner"></span>
                                <span class="onoffswitch-switch"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="save" class="btn btn-primary" >Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>