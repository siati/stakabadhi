<?php /* @var $contacts common\models\DocumentsMailingsContacts */ ?>

<?php $i = 0 ?>

<table id="contacts-table">
    <?php foreach ($contacts as $contact): ?>
        <tr class="ctnct-id" ctnct-id="<?= $contact->id ?>">
            <td class="td-right"><?= ++$i ?>.</td>

            <td class="ctnct-id-td td-left">
                <table>
                    <tr>
                        <td class="td-left ctnct-nm" onclick="contactToForm($(this).parents('.ctnct-id'))" title="<?= $contact->email ?>" style="width: 82.5%"><?= $contact->names ?></td>

                        <td style="width: 17.5%">
                            <table>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-send ctnct-add" onclick="selectContact($(this).parents('.ctnct-id'))" title="Add To Recipients"></span>
                                    </td>
                                    <td>
                                        <span class="glyphicon glyphicon-plus-sign ctnct-new" onclick="contactFormValues(null, null, null, null)" title="New Contact"></span>
                                    </td>
                                    <td>
                                        <span class="glyphicon glyphicon-remove-sign ctnct-drp" onclick="deleteContact($(this).parents('.ctnct-id').attr('ctnct-id'))" title="Delete This Contact"></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>

            <td class="ctnct-dscrptn" hidden="hidden"><?= $contact->description ?></td>
        </tr>
    <?php endforeach; ?>
</table>