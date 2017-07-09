<div class="snd-doc-mdl-cntnts pull-left">

    <div class="snd-doc-mdl-cntnts-lst">
        <div class="snd-doc-mdl-cntnts-lst-pn" id="mailing-contacts-list">
            <?= $mailing_contacts ?>
        </div>
    </div>

    <div class="snd-doc-mdl-cntnts-fm">
        <div class="snd-doc-mdl-cntnts-fm-pn" id="contact-form">
            <?= $mailing_contact_form ?>
        </div>
    </div>

</div>

<div class="snd-doc-mdl-snd pull-right">
    <div class="snd-doc-mdl-snd-fm">
        <div class="snd-doc-mdl-snd-fm-pn" id="document-mailing-form">
            <?= $document_mailing_form ?>
        </div>

        <div class="snd-doc-mdl-snd-btns">
            <div class="btn btn-primary pull-left" onclick="doSendFiles()"><i class="glyphicon glyphicon-send"> </i> Send</div>
            <div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div>
        </div>
    </div>
</div>