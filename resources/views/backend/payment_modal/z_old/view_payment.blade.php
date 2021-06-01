<div class="modal fade" id="account-show" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"> <i class="fa fa-plus-circle"></i> View Bank
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h4>

            </div>

            <div class="modal-body" id="show-modal-body">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>
@push('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function showData(id){
        $.ajax({
            url: 'account/' + id,
            type: 'GET',
            success: function(response){
                if(response.payment_method.method && response.payment_method.method != ""){
                    $("#show-modal-body").append(`
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Payment Method: <span> ${response.payment_method.method} </span> </label>
                            </div>
                        </div>
                    `);
                }

                if(response.bank && response.bank != ""){
                    $("#show-modal-body").append(`
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Bank Name: <span> ${response.bank.name} </span> </label>
                            </div>
                        </div>
                    `);
                }
                if(response.account_name && response.account_name != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Account Name: <span> ${response.account_name} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.account_no && response.account_no != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Account No: <span> ${response.account_no} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.opening_amount && response.opening_amount != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Opening Amount: <span> ${response.opening_amount} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.contract_person && response.contract_person != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Contract Person: <span> ${response.contract_person} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.contract_phone && response.contract_phone != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Contract Phone: <span> ${response.contract_phone} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.address && response.address != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Address: <span> ${response.address} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.card_holder && response.card_holder != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Card Holder: <span> ${response.card_holder} </span> </label>
                    </div>
                </div>
                `);
                }
                if(response.card_type && response.card_type != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Card Type: <span> ${response.card_type} </span> </label>
                    </div>
                </div>
                `);
                }

                if(response.card_date && response.card_date != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Card Expire Date: <span> ${response.card_expire_date} </span> </label>
                    </div>
                </div>
                `);
                }

                if(response.security_type && response.security_type != ""){
                $("#show-modal-body").append(`
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Security Type: <span> ${response.security_type} </span> </label>
                    </div>
                </div>
                `);
                }

                $('#account-show').modal('show');
            },
        });
    }

</script>
@endpush