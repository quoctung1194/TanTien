<div class="modal fade" id="deleteConfirmModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    {{ __('index.confirm') }}
                </h4>
            </div>
            <div class="modal-body">
                <p>{{ __('index.confirm_delete_message') }}</p>
            </div>
            <div class="modal-footer">
                <button id="deleteYes" type="button" class="btn btn-primary"
                        data-dismiss="modal">
                    {{ __('index.confirm_yes') }}
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    {{ __('index.confirm_no') }}
                </button>
            </div>
        </div>
    </div>
</div>