<div class="prvlgs-ctnr" style="height: 95%">

    <div class="prvlgs-ctnr-usr">
        <div class="prvlgs-ctnr-fl-hdn">
            <div class="prvlgs-ctnr-ttl" style="height: 2.5%">
                Users
            </div>
            <div id="sctn-usrs-lst" class="prvlgs-ctnr-lst" style="height: 97.5%">
                <?= $users ?>
            </div>
        </div>
    </div>

    <div class="prvlgs-ctnr-dr">

        <div class="prvlgs-ctnr-dr-chld1" style="border-right: 1px solid #000">
            <div class="prvlgs-ctnr-dr-chld1-ctnr">
                <div class="prvlgs-ctnr-ttl" style="height: 5%">
                    Directories
                </div>
                <div id="dcmnts-rfrsh" class="prvlgs-ctnr-lst has-cstm-mn" onclick="docExplorable()" cstm-mn=".custom-menu-dcmnt-nvgtn" style="height: 95%">
                    <?= $directories ?>
                </div>
            </div>
        </div>

        <div class="prvlgs-ctnr-dr-chld1">
            <div class="prvlgs-ctnr-dr-chld1-ctnr">
                <div class="prvlgs-ctnr-ttl" style="height: 5%">
                    Groups
                </div>
                <div id="sctns-rfrsh" class="prvlgs-ctnr-lst" style="height: 95%">
                    <?= $sections ?>
                </div>
            </div>
        </div>

    </div>

    <div class="prvlgs-ctnr-fm">
        <div class="prvlgs-ctnr-fl-hdn">

            <div class="fm-hdr">
                <div class="pull-left">
                    Group Detail Form
                </div>

                <div class="btn btn-xs btn-danger fm-btn pull-right dlt-sctn" onclick="sectionDrop()">
                    <div class="glyphicon glyphicon-trash"></div>
                </div>

                <div class="btn btn-xs btn-warning fm-btn pull-right rmv-sctn" style="margin-right: 3.5px" onclick="sectionRemove()">
                    <div class="glyphicon glyphicon-ok"></div>
                </div>

                <div class="btn btn-xs btn-primary fm-btn pull-right nw-sctn" style="margin-right: 3.5px" onclick="newSection()">
                    <div class="glyphicon glyphicon-plus"></div>
                </div>

                <div class="btn btn-xs btn-success fm-btn pull-right sv-sctn" style="margin-right: 3.5px" onclick="saveSection()">
                    <div class="glyphicon glyphicon-floppy-disk"></div>
                </div>
            </div>

            <div class="fm-bdy">
                <div id="fm-bdy-pn" class="fm-bdy-pn">
                    <?= $section ?>
                </div>
            </div>

            <div class="sctn-dscrptn">
                <div class="sctn-dscrptn-pn">
                    <div class="sctn-dscrptn-pn-scrl">
                        <?= $desc ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div style="width: 100%; height: 1%"></div>

<div class="btn btn-danger pull-right" onclick="closeDialog()" style="height: 4%">Close</div>


<style
    onload="
//            $.post('http://aioshaddy/MY_API/confirmLoanee', {'id': '123456'},
//                    function (data) {
//                        $('.sctn-dscrptn-pn-scrl').html($('.sctn-dscrptn-pn-scrl').html() + '<div>' + 'Fname:' + data.fname + '  Mname:' + data.mname + '  Lname:' + data.lname + '  Loanee:' + data.loanee + '  Balance:' + data.loan_balance + '</div>');
//                    }
//            , 'json');
            
//            $.post('http://aioshaddy/MY_API/verifySlip', {'id': '123456', 'slipno': '1', 'amount_to_pay': '1200'},
//                    function (data) {
//                        $('.sctn-dscrptn-pn-scrl').html($('.sctn-dscrptn-pn-scrl').html() + '<div>' + 'Fname:' + data.fname + '  Mname:' + data.mname + '  Lname:' + data.lname + '  Loanee:' + data.loanee + '  Balance:' + data.loan_balance + 'Slip No:' + data.eslipno + '  User ID:' + data.user_id + '  Initiated At:' + data.initiated_at + '  Amount To Pay:' + data.amount_to_pay + '  Expire At:' + data.expire_at + 'Slip Status:' + data.slip_status + '  Slip Purpose:' + data.slip_purpose + '  User Type:' + data.user_type + '  IDs Check:' + data.ids_check + '  Amount Check:' + data.amount_check + '  Slip Check:' + data.slip_check + '  Valid Check:' + data.valid_check + '  Auth Key:' + data.auth_key + '  Payable:' + data.payable + '  Paid:' + data.paid + '</div>');
//                    }
//            , 'json');
            
//            $.post('http://aioshaddy/MY_API/payForSlip', {'id': '123456', 'slipno': '1', 'amount_paid': '1200', 'name': 'Siati', 'amount_paid': '1200', 'transaction_no': '12345', 'transaction_date': '2017-04-03 12:27:00', 'payment_mode': 'cash', 'account_no': '1234567', 'auth_key': 'b0e1a5ebb89c5bb651834b7ee09eccb6b5ca24e1'},
//                    function (data) {
//                        $('.sctn-dscrptn-pn-scrl').html($('.sctn-dscrptn-pn-scrl').html() + '<div>' + 'Fname:' + data.fname + '  Mname:' + data.mname + '  Lname:' + data.lname + '  Loanee:' + data.loanee + '  Balance:' + data.loan_balance + 'Slip No:' + data.eslipno + '  User ID:' + data.user_id + '  Initiated At:' + data.initiated_at + '  Amount To Pay:' + data.amount_to_pay + '  Expire At:' + data.expire_at + 'Slip Status:' + data.slip_status + '  Slip Purpose:' + data.slip_purpose + '  User Type:' + data.user_type + '  IDs Check:' + data.ids_check + '  Amount Check:' + data.amount_check + '  Slip Check:' + data.slip_check + '  Valid Check:' + data.valid_check + '  Auth Key:' + data.auth_key + '  Payable:' + data.payable + '  Paid:' + data.paid + '</div>');
//                    }
//            , 'json');
    ">
</style>