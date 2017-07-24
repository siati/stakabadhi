<?php /* @var $this yii\web\View */ ?>
<?php /* @var $navigation mixed */ ?>
<?php /* @var $storeLevels mixed */ ?>
<?php /* @var $levelDetails array */ ?>

<?php

use yii\web\View;
use yii\bootstrap\ButtonDropdown;
use common\models\StoreLevels;
use common\models\FilePermissions;
use common\models\User;

$user = Yii::$app->user->identity->id;

$is_admin = Yii::$app->user->identity->userStillHasRights([User::USER_SUPER_ADMIN, User::USER_ADMIN]);

foreach ($levels as $level => $detail)
    $items[] = ['label' => $detail, 'url' => '#', 'options' => ['lvl' => $level, 'style' => 'width: 100%; font-weight: bold; float: right', 'actn' => strtolower($levelDetails[$level][0]), 'cls' => 'crt-lvl']];
?>

<?php $read = FilePermissions::read; ?>
<?php $write = FilePermissions::write; ?>
<?php $deny = FilePermissions::deny; ?>

<div class="files-default-index">

    <div class="files-left-pn">
        <div class="files-left-pn-pn">
            <div class="files-left-pn-pn-new">
                <?=
                ButtonDropdown::widget([
                    'label' => 'New',
                    'containerOptions' => ['class' => 'btn btn-success', 'style' => 'width: 100%; padding: 0'],
                    'options' => ['class' => 'btn btn-success', 'style' => 'width: 100%; border: none; font-weight: bold'],
                    'dropdown' => [
                        'items' => $items
                    ]
                ])
                ?>
            </div>

            <div class="files-left-pn-pn-lvls">
                <?= $storeLevels ?>
            </div>

            <div class="files-left-pn-pn-srch">
                <div class="input-group" style="margin-top: 0">
                    <input id="storelevel-srch" class="form-control" style="background-color: inherit" type="text">
                    <span class="input-group-addon">
                        <i class="glyphicon glyphicon-search"></i>
                    </span>
                </div>
            </div>

        </div>
    </div>

    <div class="files-ctnt">
        <div class="files-ctnt-pn">

            <div class="files-ctnt-pn-lst">

            </div>

            <div class="files-ctnt-pn-tl has-cstm-mn"  cstm-mn=".custom-menu-strg-unts">

            </div>

        </div>
    </div>

    <div class="files-right-pn">
        <div class="files-right-pn-pn">
            <div class="files-prpt-pn-sub" style="height: 35%">
                <div class="files-right-pn-pn-sub-1"></div>
            </div>
            <div class="files-prpt-pn-sub" style="height: 22.5%">
                <div class="files-right-pn-pn-sub-2"></div>
            </div>
            <div class="files-prpt-pn-sub" style="height: 12.5%">
                <div class="files-right-pn-pn-sub-3"></div>
            </div>
            <?= $branding ?>
        </div>
    </div>

    <!-- floating sliding menu div starts here -->
    <div id="slider-float-doc-div">
        <div id="sidebar-float-doc-div" onclick="open_panel()">
            <div class="btn btn-lg btn-default" style="border-radius: 200%">
                <div class="glyphicon glyphicon-menu-left"></div>
            </div>
        </div>

        <div id="header-float-doc-div">
            <div class="btn btn-lg btn-primary glyphicon glyphicon-search" onclick="docSearchFormOpen()" title="Search Files"></div>
            <div class="btn btn-lg btn-primary glyphicon glyphicon-picture" onclick="slideImages()" title="Slide Items"></div>
        </div>
    </div>
    <!-- floating sliding menu div ends here -->

</div>

<div id="str-lvl-fm" hidden="hidden"></div>
<div id="str-fm" hidden="hidden"></div>


<!-- custom context menu for storage units -->
<ul class="custom-menu custom-menu-strg-unts">
    <li class="custom-sub-menu strg-unts-opn div1" rgt="<?= $read ?>" onclick="openStorage($(this).parent().attr('lvl'), $(this).parent().attr('str-id'))">Open</li>
    <li class="custom-sub-menu strg-unts-edt div1" rgt="<?= $write ?>" onclick="storage2($(this).parent().attr('lvl'), $(this).parent().attr('str-id'))">Edit</li>
    <li class="custom-sub-menu strg-unts-dlt div1" rgt="<?= $write ?>" onclick="deleteStorage($(this).parent().attr('lvl'), $(this).parent().attr('str-id'), $(this).parent().attr('dlt-actn'))">Delete</li>
    <li class="custom-sub-menu divider" no="div1"></li>
    <li class="custom-sub-menu strg-unts-mv div2" rgt="<?= $write ?>" onclick="moveStorages($(this).parent().attr('lvl'), $(this).parent().attr('str-id'), $(this).parent().attr('mv-actn'))">Move</li>
    <li class="custom-sub-menu strg-unts-rgts div2" rgt="<?= $write ?>" onclick="filePermission($(this).parent().attr('lvl'), $(this).parent().attr('str-id'))">Privileges</li>
    <li class="custom-sub-menu divider" no="div2"></li>
    <li class="custom-sub-menu custom-menu-wait has-cstm-mn strg-unts-new div3" rgt="<?= $write ?>" cstm-mn=".custom-menu-new-strg-unts" onclick="newStorageToShow()">New</li>
    <li class="custom-sub-menu divider" no="div3"></li>
    <li class="custom-sub-menu strg-unts-rfsh" rgt="<?= $read ?>" onclick="refreshFiles()">Refresh</li>
    <li class="custom-sub-menu strg-unts-slct" rgt="<?= $write ?>">Select</li>
</ul>
<!-- custom context menu for storage units -->

<!-- custom context menu for new storage units -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-new-strg-unts" rgt="<?= $write ?>">
    <li class="custom-sub-menu new-strg-unts-str" lvl="<?= $storeLevel = StoreLevels::stores ?>"><?= StoreLevels::returnLevel($storeLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-cprtmt" lvl="<?= $compartmentLevel = StoreLevels::compartments ?>"><?= StoreLevels::returnLevel($compartmentLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-sb-cprtmt" lvl="<?= $subcompartmentLevel = StoreLevels::subcompartments ?>"><?= StoreLevels::returnLevel($subcompartmentLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-sb-sb-cprtmt" lvl="<?= $subsubcompartmentLevel = StoreLevels::subsubcompartments ?>"><?= StoreLevels::returnLevel($subsubcompartmentLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-shlf" lvl="<?= $shelfLevel = StoreLevels::shelves ?>"><?= StoreLevels::returnLevel($shelfLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-drwr" lvl="<?= $drawerLevel = StoreLevels::drawers ?>"><?= StoreLevels::returnLevel($drawerLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-btch" lvl="<?= $batchLevel = StoreLevels::batches ?>"><?= StoreLevels::returnLevel($batchLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-fldr" lvl="<?= $folderLevel = StoreLevels::folders ?>"><?= StoreLevels::returnLevel($folderLevel)->name ?></li>
    <li class="custom-sub-menu new-strg-unts-fl" lvl="<?= $fileLevel = StoreLevels::files ?>"><?= StoreLevels::returnLevel($fileLevel)->name ?></li>
</ul>
<!-- custom context menu for new storage units -->

<!-- custom context menu for selected file items -->
<ul class="custom-menu custom-menu-fl-optns" rgt="<?= $write ?>">
    <li class="custom-sub-menu fl-optns-mv div4">Move</li>
    <li class="custom-sub-menu fl-optns-rgts div4">Privileges</li>
    <li class="custom-sub-menu fl-optns-dlt div4">Delete</li>
    <li class="custom-sub-menu divider" no="div4"></li>
    <li class="custom-sub-menu fl-optns-pst div5">Paste</li>
    <li class="custom-sub-menu divider" no="div5"></li>
    <li class="custom-sub-menu fl-optns-slct-all">Select All</li>
    <li class="custom-sub-menu fl-optns-cntn">Continue Selecting</li>
    <li class="custom-sub-menu fl-optns-slct-qt">Quit Selecting</li>
</ul>
<!-- custom context menu for selected file items -->

<?php $read_rights = FilePermissions::read_rights ?>
<?php $write_rights = FilePermissions::write_rights; ?>
<?php $deny_rights = FilePermissions::deny_rights ?>

<?php
$this->registerJs(
        "
            function levelName(lvl, fm) {
                $.post('files/section-name', $('#' + fm).serialize(),
                    function (name) {
                        $('.files-left-pn-pn-new [lvl=' + lvl + '] a, .files-ctnt-pn [lvl=' + lvl + '] .files-ctnt-pn-lst-hd strong, .custom-menu-new-strg-unts [lvl=' + lvl + ']').text(name);
                    }
                );
            }
            
            function dynamicStorages(lvl, id, val) {
                if (lvl * 1 < $folderLevel * 1) {
                    $.post('files/dynamic-storages', {'level': lvl = lvl * 1 + 1, 'id': id, 'value': val, 'prompt': 1},
                        function (optns) {
                            $('#storelevel-' + lvl).html(optns).trigger('valuechanged').change();

                            highlightStorageOnList(lvl * 1 - 1, id);

                            if ($('.files-ctnt-pn [lvl=' + lvl + ']').length)
                                $('#storelevel-' + lvl).parent().find('.input-group-addon').click();
                        }
                    );
                } else
                    $.post('files/the-files', {'folder': id},
                        function (files) {
                            highlightStorageOnList(lvl, id);
                            $('.files-ctnt-pn-tl').html(files).trigger('contentchanged').trigger('contentchangednofile');
                        }
                    );
            }
            
            function customStoreNavigator(elmnt) {
                for (lvl = $storeLevel * 1; lvl <= (maxLvl = elmnt.attr('str-lvl') * 1); lvl++)
                    effectCustomStoreNavigator(lvl === $fileLevel ? $('.files-ctnt-pn-tl [fl-hd=' + (lvl === maxLvl ? elmnt.attr('str-id') : elmnt.attr('str-lvl-' + lvl)) + ']') : $('#storelevel-' + lvl), lvl, elmnt.attr('str-lvl-' + (lvl * 1 - 1)) ? elmnt.attr('str-lvl-' + (lvl * 1 - 1)) : '', lvl === maxLvl ? elmnt.attr('str-id') : elmnt.attr('str-lvl-' + lvl), lvl === maxLvl, elmnt.attr('str-id'));
            }
            
            function effectCustomStoreNavigator(elmnt, lvl, id, val, ctn, fl_id) {
                $.post('files/dynamic-storages', {'level': lvl, 'id': id, 'value': val, 'prompt': 1},
                    function (optns) {
                        if (ctn) {
                        
                            if (lvl * 1 > $folderLevel * 1) {
                                
                                highlightStorageOnList($folderLevel, $('#storelevel-$folderLevel').val());
                                    
                                storageProperties($folderLevel, $('#storelevel-$folderLevel').val());
                                
                                if (elmnt.length)
                                    selectThisFileItem(elmnt);
                                else {
                                    
                                    $('#storelevel-$folderLevel').change().parent().find('.input-group-addon').click();
                                    
                                    $.post('files/the-files', {'folder': $('#storelevel-$folderLevel').val()},
                                        function (files) {
                                            $('.files-ctnt-pn-tl').html(files);
                                            selectThisFileItem($('.files-ctnt-pn-tl [fl-hd=' + val + ']'));
                                        }
                                    );
                                }
                            } else
                            if (ctn) {
                                elmnt.html(optns).val(val).change().parent().find('.input-group-addon').click();

                                storageProperties(lvl, val);
                            }
                            
                        } else
                            elmnt.html(optns).val(val);
                    }
                );
            }
            
            function dynamicStorages2(lvl, id, val, prmpt, elmnt_id, rppl) {
                $.post('files/dynamic-storages', {'level': lvl, 'id': id, 'value': val, 'prompt': prmpt},
                    function (optns) {
                        rppl ? $('#' + elmnt_id).html(optns).change() : $('#' + elmnt_id).html(optns);
                    }
                );
            }
            
            function populateListDiv(elmnt) {
                divs = '<div class=files-ctnt-pn-lst-hd><strong>' + $('#storelevels-' + elmnt.attr('lvl') + '-name').val() + '</strong></div><div class=files-ctnt-pn-lst-bdy cstm-mn=.custom-menu-strg-unts>';
                        
                elmnt.find('option').each(
                    function () {
                        if ($(this).attr('value') * 1 > 0)
                            divs =  divs + '<div class=has-cstm-mn str-id=' + $(this).attr('value') + ' rgt=$deny>' + $(this).text() + '</div>';
                    }
                );
                
                divs = divs + '</div>';
                            
                $('.files-ctnt-pn-lst').html(divs).attr('lvl', elmnt.attr('lvl')).find('.files-ctnt-pn-lst-bdy').addClass('has-cstm-mn').find('div').each(
                    function () {
                        $(this).attr('onclick', 'selectedListId($(this))').attr('cstm-mn', '.custom-menu-strg-unts')
                        .addClass($(this).attr('str-id') * 1 === $('#storelevel-' + $('.files-ctnt-pn-lst').attr('lvl')).val() * 1 ? 'lst-slctd' : '');
                        
                        $(this).hasClass('lst-slctd') && !$('.files-right-pn-pn-sub-1 table').length ? storageProperties(elmnt.attr('lvl'), $(this).attr('str-id')) : '';
                        
                        storageItemPerm($('.files-ctnt-pn-lst').attr('lvl'), $(this).attr('str-id'), '$user', $(this), 'rgt');
                    }
                );
            }
            
            function storageItemPerm(level, id, user, elmnt, attr) {
                $.post('files/user-storage-permission', {'level': level, 'id': id, 'user': user},
                    function (rgt) {
                        elmnt.attr(attr, rgt);
                    }
                );
            }
            
            function selectedListId(elmnt) {
                $('.custom-menu-strg-unts').attr('lvl', lvl = $('.files-ctnt-pn-lst').attr('lvl')).attr('str-id', elmnt.attr('str-id')).attr('mv-actn', 'move-' + $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn')).attr('dlt-actn', 'delete-' + $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn'));
            }
            
            function selectedFileItem(elmnt) {
                selectThisFileItem(elmnt);
                $('.custom-menu-strg-unts').attr('lvl', lvl = $fileLevel).attr('str-id', id = elmnt.attr('fl-hd')).attr('mv-actn', 'move-' + $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn')).attr('dlt-actn', 'delete-' + $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn'));
            }
            
            function highlightStorageOnList(lvl, val) {
                if ($('.files-ctnt-pn [lvl=' + lvl + ']').length) {
                    $('.files-ctnt-pn [lvl=' + lvl + ']').parent().find('.files-ctnt-pn-lst-bdy .lst-slctd').removeClass('lst-slctd');
                    val * 1 > 0 ? $('.files-ctnt-pn [lvl=' + lvl + ']').parent().find('[str-id=' + val + ']').addClass('lst-slctd') : '';
                }
            }
            
            function listBodyOptions() {
                $('.custom-menu-strg-unts').find('li').each(
                    function () {
                        $(this).hasClass('strg-unts-new') || $(this).hasClass('strg-unts-rfsh') ? $(this).show() : $(this).hide();
                    }
                );
            }
            
            function storeLevelItemOptions() {
                $('.custom-menu-strg-unts li').show();
                $('.custom-menu-strg-unts .strg-unts-slct').hide();
            }
            
            function checkItemRights(item) {
                rgt = item.hasClass('fl-hd-pn-img') ? (item.parent().parent().attr('rgt')) : (item.parent().hasClass('files-ctnt-pn-lst-bdy') ? (item.attr('rgt')) : ($is_admin > 0 ? '$write' : '$read'));
                
                $(document).find('.custom-menu').each(
                    function () {
                        $(this).attr('rgt') ? rightsOnItem($(this), rgt) :
                            $(this).find('.custom-sub-menu').each(
                                function () {
                                    rightsOnItem($(this), rgt);
                                }
                            );
                    }
                );
            }
            
            function rightsOnItem(optn, rgt) {
                $is_admin === 0 && ((rgt !== '$read' && rgt !== '$write') || (rgt === '$read' && optn.attr('rgt') === '$write')) ? optn.hide() : '';
            }
            
            function filesPaneOptions() {
                $('.custom-menu-strg-unts').find('li').each(
                    function () {
                        $(this).hasClass('strg-unts-new') || $(this).hasClass('strg-unts-rfsh') || $(this).hasClass('strg-unts-slct') ? $(this).show() : $(this).hide();
                    }
                );
            }
            
            function filesPaneItemOptions() {
                $('.custom-menu-strg-unts li').show();
                $('.custom-menu-strg-unts .strg-unts-opn').hide();
            }
            
            function openStorage(lvl, id) {
                $('#storelevel-' + lvl).val(id).change();
                storageProperties(lvl, id);
            }
            
            function refreshFiles() {
                $('.files-ctnt-pn-lst-bdy .lst-slctd').click();
                $('.custom-menu-strg-unts .strg-unts-opn').click();
            }
            
            function storeLevelPossibleValue(elmnt) {
                if (elmnt.val() === '' || elmnt.val() === null)
                    elmnt.find('option').each(
                        function () {
                            if ((elmnt.val() === '' || elmnt.val() === null) && $(this).val() !== '' && $(this).val() !== null) {
                                elmnt.val($(this).val());
                                $(this).attr('selected', 'selected');
                            } else
                                $(this).attr('selected', null);
                        }
                    );
            }
            
            function newStorageToShow() {
                for (lvl = $folderLevel * 1; lvl >= $storeLevel * 1; lvl--)
                    $('#storelevel-' + lvl).val() * 1 > 0 ? $('.files-left-pn-pn-new [lvl=' + (lvl + 1) + '], .custom-menu-new-strg-unts [lvl=' + (lvl + 1) + ']').show() : $('.files-left-pn-pn-new [lvl=' + (lvl + 1) + '], .custom-menu-new-strg-unts [lvl=' + (lvl + 1) + ']').hide();
            }
            
            function storage(title, actn, post) {
                yiiModal(title, 'files/' + actn, post, $('.files-ctnt').width() * 0.5, $('.files-default-index').height() * 0.55);
            }
            
            function storage2(lvl, id) {
                storage(lvl * 1 < $fileLevel * 1 ? $('.files-ctnt-pn-lst-hd').text() : 'Files', $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn'), updateStoragePostItems(lvl, id));
                $('#str-lvl-fm').text(lvl);
                $('#str-fm').text(id);
            }
            
            function storage3(lvl) {
                $.post('files/' + $('.files-left-pn-pn-new [lvl=' + lvl + ']').attr('actn'), newStoragePostItems(lvl),
                    function (form) {
                        $('#yii-modal-cnt').html(form);
                        $('#str-fm').text(null);
                    }
                );
            }
            
            function saveStorage(form_id) {
                post = $('#' + form_id).serializeArray();

                post.push({name: 'sbmt', value: ''});
                
                $.post($('#' + form_id).attr('action'), post,
                    function (form) {
                        $('#yii-modal-cnt').html(form);
                        if ((lvl = $('#str-lvl-fm').text() * 1 - 1) < $folderLevel * 1) {
                            dynamicStorages(lvl, $('#storelevel-' + lvl).length ?  $('#storelevel-' + lvl).val() : '', $('#storelevel-' + (lvl * 1 + 1)).val());
                            $('.files-ctnt-pn-lst').attr('lvl') * 1 === $('#str-lvl-fm').text() * 1 && $('.files-ctnt-pn-lst-bdy [str-id=' + $('#str-fm').text() + ']').hasClass('lst-slctd') ? storageProperties($('#str-lvl-fm').text(), $('#str-fm').text()) : '';
                        } else {
                            $('#storelevel-' + lvl).change();
                        }
                    }
                );
            }
            
            function moveStorages(lvl, id, actn) {
                lvl * 1 > $storeLevel * 1 ? yiiModal('Move Items', 'files/' + actn, updateStoragePostItems(lvl, id), $('.files-ctnt').width() * 0.5, $('.files-default-index').height() * 0.775) : '';
            }
            
            function moveStorage(form_id, lvl) {
                post = $('#' + form_id).serializeArray();

                post.push({name: 'sbmt', value: ''});
                
                $.post($('#' + form_id).attr('action'), post,
                    function (moved) {
                        $('#storelevel-' + lvl).change().parent().find('.input-group-addon').click();
                        storageProperties(lvl, $('#storelevel-' + lvl).val());
                    }
                );
            }
            
            function deleteStorage(lvl, id, actn) {
                swal(
                        {
                            title: 'Delete This Item?',
                            text: '<h3>Items that have content will not be deleted</h3>',
                            type: 'warning',
                            html: true,
                            showCancelButton: true,
                            confirmButtonColor: '#dd6b55',
                            confirmButtonText: 'Proceed',
                            cancelButtonText: 'Cancel',
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            allowEscapeKey: true,
                            allowOutsideClick: true
                        },
                        function (ok) {
                            ok ?
                                $.post('files/' + actn, updateStoragePostItems(lvl, id),
                                    function (dltd) {
                                        if (dltd) {
                                            customErrorSwal('Completed', '<h3>Item Deleted Successfully</h3>', 2000, 'success');
                                            lvl * 1 < $fileLevel * 1 ? dynamicStorages(lvl * 1 - 1, $('#storelevel-' + (lvl * 1 - 1)).length ?  $('#storelevel-' + (lvl * 1 - 1)).val() : '', $('#storelevel-' + lvl).val()) : $('#storelevel-' + (lvl * 1 - 1)).change();
                                        } else
                                            customErrorSwal('Not Done', '<h3>Item could not be deleted!</h3>', 2000, 'error');
                                    }
                                ):
                                swal.close();
                        }
                );            
            }
            
            function filePermission(lvl, lvl_id) {
                yiiModal('<small style=font-size:18px>Permissions: ' + (lvl * 1 < $fileLevel * 1 ? $('.files-ctnt-pn-lst-bdy [str-id=' + id + ']').text() : $('.files-ctnt-pn-tl [fl-hd=' + id + '] .fl-hd-pn-nm').text()) + '</small>', 'files/file-permission', {'FilePermissions[store_level]': lvl, 'FilePermissions[store_id]': lvl_id}, $('.files-ctnt').width() * 0.4, $('.files-default-index').height());
            }
            
            function rotatePermissionButton(btn, rtt, sbmt) {
                newText = rtt ? (btn.text() == '$write' ? ('$read') : (btn.text() == '$read' ? '$deny' : '$write')) : (btn.text());

                prpts = permissionButton(newText);

                btn.removeClass('btn-success').removeClass('btn-info').removeClass('btn-default').addClass('btn-' + prpts[1]).text(newText);
                
                sbmt ? saveFilePermission(btn.parents('table').attr('prm-id'), btn.parents('table').attr('str-lvl'), btn.parents('table').attr('str-id'), btn.parents('tr').attr('usr-id'), btn, prpts) : '';
            }
            
            function permissionButton(text) {
                return {
                    0: (text === '$write' ? ('$write_rights') : (text === '$read' ? '$read_rights' : '$deny_rights')),
                    1: (text === '$write' ? ('success') : (text === '$read' ? 'info' : 'default'))
                };
            }
            
            function saveFilePermission(id, lvl, lvl_id, usr, btn, atrbts) {
                $.post('files/file-permission',
                    {
                        'FilePermissions[id]': id,
                        'FilePermissions[store_level]': lvl,
                        'FilePermissions[store_id]': lvl_id,
                        'user': usr,
                        'attribute': atrbts[0],
                    },
                    function (prmsn) {
                        btn.text(prmsn[0]);
                        rotatePermissionButton(btn, false, false);
                        prpts = permissionButton(prmsn[1]);
                        btn.parents('tr').find('td span').removeClass('btn-success').removeClass('btn-info').removeClass('btn-default').addClass('btn-' + prpts[1]);
                        userWritePermissions($user);
                        lvl * 1 === $fileLevel * 1 ? $('[fl-hd=' + lvl_id + ']').attr('rgt', prmsn[0]) : $('.files-ctnt-pn [lvl=' + lvl + '] .files-ctnt-pn-lst-bdy [str-id=' + lvl_id + ']').attr('rgt', prmsn[0]);
                    }
                );
            }
            
            function storageProperties(lvl, id) {
                $.post('files/file-properties', {'level': lvl, 'id': id},
                    function (prpts) {
                        $('.files-right-pn-pn-sub-1').html(prpts);
                    }
                );
            }
            
            function fileProperties(id) {
                $.post('files/file-properties', {'level': '$fileLevel', 'id': id},
                    function (prpts) {
                        $('.files-right-pn-pn-sub-3').html(prpts);
                    }
                );
            }
            
            function selectThisFileItem(elmnt) {
                $('.files-ctnt-pn-tl').find('.fl-hd .fl-slctd').removeClass('fl-slctd');
                elmnt.find('.fl-hd-pn').addClass('fl-slctd');
                fileProperties(elmnt.attr('fl-hd'));
            }
            
            function userWritePermissions(user) {
                $.post('files/storage-write-rights', {'user': user},
                    function (perms) {
                        $('.files-right-pn-pn-sub-2').html(perms);
                    }
                );
            }
                
            function manageCustomMenuBorders() {
                $(document).find('.custom-menu .divider').each(
                    function () {
                        show = false;

                        $(this).parent().find('.' + $(this).attr('no')).each(
                            function () {
                                $(this).is(':visible') ? show = true : '';
                            }
                        );

                        show ? $(this).show() : $(this).hide();
                    }
                );
            }
            
            function open_panel() {
                slideIt();
                $('#sidebar-float-doc-div').attr('onclick', 'close_panel()').find('.glyphicon-menu-left').removeClass('glyphicon-menu-left').addClass('glyphicon-menu-right');
            }

            function slideIt() {
                var slidingDiv = document.getElementById('slider-float-doc-div');
                var stopPosition = 0;

                if (parseInt(slidingDiv.style.right) < stopPosition) {
                    slidingDiv.style.right = parseInt(slidingDiv.style.right) + 2 + 'px';
                    setTimeout(slideIt, 1);
                }
            }

            function close_panel() {
                slideIn();
                $('#sidebar-float-doc-div').attr('onclick', 'open_panel()').find('.glyphicon-menu-right').removeClass('glyphicon-menu-right').addClass('glyphicon-menu-left');
            }

            function slideIn() {
                var slidingDiv = document.getElementById('slider-float-doc-div');
                var stopPosition = $('#header-float-doc-div').width() * -1;

                if (parseInt(slidingDiv.style.right) > stopPosition) {
                    slidingDiv.style.right = parseInt(slidingDiv.style.right) - 2 + 'px';
                    setTimeout(slideIn, 1);
                }
            }
            
            function slideImages() {
                yiiModal('Slide Images', '../institution/sections/slide-images', {}, $('.files-ctnt').width() * 0.75, $('.files-default-index').height());
            }

            function refreshSlideImages(actv) {
                $.post('../institution/sections/slide-images-panes', {'actv': actv},
                    function (images) {
                        $('#the-sld-imgs').html(images);
                    }
                )
            }

            function toggleAttributeVisible(attrib, elmnt) {
                $('#slideimages-' + attrib + '_visible').val(elmnt.hasClass('glyphicon-eye-open') ? '0' : '1');
                elmnt.hasClass('glyphicon-eye-open') ?
                    elmnt.removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close') :
                    elmnt.removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
            }

            function toggleImageNameVisible(elmnt) {
                toggleAttributeVisible('name', elmnt);
            }

            function toggleImageCaptionVisible(elmnt) {
                toggleAttributeVisible('caption', elmnt);
            }

            function fitSlideImage() {
                $('#img-chg-pic').attr('width', $('#img-chg-pic-pn').parent().width() + 'px');

                $('#img-chg-pic-pn').height() > $('#img-chg-pic-pn').parent().parent().height() ? $('#img-chg-pic').attr('width', null).attr('height', $('#img-chg-pic-pn').parent().height() + 'px') : '';

                $('#img-chg-pic').css('max-height', $('#img-chg-pic-pn').parent().height() - 2 + 'px').css('max-width', $('#img-chg-pic-pn').parent().width() - 2 + 'px');

                $('#img-chg').hide();

                $('#img-chg-pic-pn').show();
            }

            function previewSlideImage(input) {
                readURL(input, '#img-chg-pic');

                fitSlideImage();
            }

            function imageOntoForm(id) {
                $.post('../institution/sections/update-slide-image', {'SlideImages[id]': id},
                    function (form) {
                        $('#sld-img-fm').html(form);
                    }
                )
            }

            function ifRefreshImages(active, always) {
                (always || active * 1 > 0) && $('#imgs-inactv').is(':visible') ? $('#imgs-actv').click() : '';
                (always || active * 1 < 1) && $('#imgs-actv').is(':visible') ? $('#imgs-inactv').click() : '';
            }

            function imageActiveButtonChecked(active) {
                active = active * 1 > 0;
                $('#sld-img-chk').removeClass(active ? 'btn-info' : 'btn-success').addClass(active ? 'btn-success' : 'btn-info').find(active ? '.glyphicon-unchecked' : '.glyphicon-check').removeClass(active ? 'glyphicon-unchecked' : 'glyphicon-check').addClass(active ? 'glyphicon-check' : 'glyphicon-unchecked').parent().find('span').text(active ? ' Active' : ' Inactive');
            }

            function activeSlideImage() {
                if ($('#slideimages-id').val() * 1 > 0)
                    $.post('../institution/sections/active-slide-image', {'SlideImages[id]': $('#slideimages-id').val(), 'SlideImages[active]': $('#sld-img-chk').hasClass('btn-success') ? '0' : '1'},
                        function (active) {
                            ifRefreshImages($('#slideimages-active').val(), true);
                            $('#slideimages-active').val(active);
                            imageActiveButtonChecked(active);
                        }
                    )
            }

            function deleteSlideImage() {
                if ($('#slideimages-id').val() * 1 > 0)
                    $.post('../institution/sections/delete-slide-image', {'SlideImages[id]': $('#slideimages-id').val()},
                        function (deleted) {
                            ifRefreshImages($('#slideimages-active').val(), false);
                            imageOntoForm(null);
                        }
                    )
            }

            function saveSlideImage() {

                customAjaxLoader('Saving', 'Please wait while image is uploading...');

                var fd = new FormData();
                fd.append('SlideImages[id]', $('#slideimages-id').val());
                fd.append('SlideImages[active]', $('#slideimages-active').val());
                fd.append('SlideImages[name]', $('#slideimages-name').val());
                fd.append('SlideImages[name_visible]', $('#slideimages-name_visible').val());
                fd.append('SlideImages[caption]', $('#slideimages-caption').val());
                fd.append('SlideImages[caption_visible]', $('#slideimages-caption_visible').val());
                fd.append('SlideImages[url_to]', $('#slideimages-url_to').val());
                $('#slideimages-id').val() * 1 > 0 ? '' : fd.append('SlideImages[location]', document.getElementById('slideimages-location').files[0]);
                fd.append('sbmt', '');

                $.ajax(
                    {
                        contentType:false,
                        processData: false,
                        async: false,
                        cache: false,
                        type: 'post',
                        url: '../institution/sections/update-slide-image',
                        data: fd,
                        success: function (saved) {
                            if (saved) {
                                $('#sld-img-fm').html(saved);

                                ifRefreshImages($('#slideimages-active').val(), false);
                            }
                        },
                    }
                );

                swal.close();
            }
            
            function newStoragePostItems(lvl) {
                if (lvl * 1 === $fileLevel * 1)
                    return {'Files[store]': $('#storelevel-$storeLevel').val(), 'Files[compartment]': $('#storelevel-$compartmentLevel').val(), 'Files[sub_compartment]': $('#storelevel-$subcompartmentLevel').val(), 'Files[sub_sub_compartment]': $('#storelevel-$subsubcompartmentLevel').val(), 'Files[shelf]': $('#storelevel-$shelfLevel').val(), 'Files[drawer]': $('#storelevel-$drawerLevel').val(), 'Files[batch]': $('#storelevel-$batchLevel').val(), 'Files[folder]': $('#storelevel-$folderLevel').val()};
                        
                if (lvl * 1 === $folderLevel * 1)
                    return {'Folders[store]': $('#storelevel-$storeLevel').val(), 'Folders[compartment]': $('#storelevel-$compartmentLevel').val(), 'Folders[sub_compartment]': $('#storelevel-$subcompartmentLevel').val(), 'Folders[sub_sub_compartment]': $('#storelevel-$subsubcompartmentLevel').val(), 'Folders[shelf]': $('#storelevel-$shelfLevel').val(), 'Folders[drawer]': $('#storelevel-$drawerLevel').val(), 'Folders[batch]': $('#storelevel-$batchLevel').val()};

                if (lvl * 1 === $batchLevel * 1)
                    return {'Batches[store]': $('#storelevel-$storeLevel').val(), 'Batches[compartment]': $('#storelevel-$compartmentLevel').val(), 'Batches[sub_compartment]': $('#storelevel-$subcompartmentLevel').val(), 'Batches[sub_sub_compartment]': $('#storelevel-$subsubcompartmentLevel').val(), 'Batches[shelf]': $('#storelevel-$shelfLevel').val(), 'Batches[drawer]': $('#storelevel-$drawerLevel').val()};

                if (lvl * 1 === $drawerLevel * 1)
                    return {'Drawers[store]': $('#storelevel-$storeLevel').val(), 'Drawers[compartment]': $('#storelevel-$compartmentLevel').val(), 'Drawers[sub_compartment]': $('#storelevel-$subcompartmentLevel').val(), 'Drawers[sub_sub_compartment]': $('#storelevel-$subsubcompartmentLevel').val(), 'Drawers[shelf]': $('#storelevel-$shelfLevel').val()};

                if (lvl * 1 === $shelfLevel * 1)
                    return {'Shelves[store]': $('#storelevel-$storeLevel').val(), 'Shelves[compartment]': $('#storelevel-$compartmentLevel').val(), 'Shelves[sub_compartment]': $('#storelevel-$subcompartmentLevel').val(), 'Shelves[sub_sub_compartment]': $('#storelevel-$subsubcompartmentLevel').val()};

                if (lvl * 1 === $subsubcompartmentLevel * 1)
                    return {'SubSubCompartments[store]': $('#storelevel-$storeLevel').val(), 'SubSubCompartments[compartment]': $('#storelevel-$compartmentLevel').val(), 'SubSubCompartments[sub_compartment]': $('#storelevel-$subcompartmentLevel').val()};

                if (lvl * 1 === $subcompartmentLevel * 1)
                    return {'SubCompartments[store]': $('#storelevel-$storeLevel').val(), 'SubCompartments[compartment]': $('#storelevel-$compartmentLevel').val()};

                if (lvl * 1 === $compartmentLevel * 1)
                    return {'Compartments[store]': $('#storelevel-$storeLevel').val()};
                
                return {};
            }
            
            function updateStoragePostItems(lvl, id) {
                if (lvl * 1 === $fileLevel * 1)
                    return {'Files[id]': id};
                        
                if (lvl * 1 === $folderLevel * 1)
                    return {'Folders[id]': id};

                if (lvl * 1 === $batchLevel * 1)
                    return {'Batches[id]': id};

                if (lvl * 1 === $drawerLevel * 1)
                    return {'Drawers[id]': id};

                if (lvl * 1 === $shelfLevel * 1)
                    return {'Shelves[id]': id};

                if (lvl * 1 === $subsubcompartmentLevel * 1)
                    return {'SubSubCompartments[id]': id};

                if (lvl * 1 === $subcompartmentLevel * 1)
                    return {'SubCompartments[id]': id};

                if (lvl * 1 === $compartmentLevel * 1)
                    return {'Compartments[id]': id};

                if (lvl * 1 === $storeLevel * 1)
                    return {'Stores[id]': id};
                
                return {};
            }
            
        "
        , View::POS_HEAD
);
?>

<?php
$this->registerJs(
        "
            /* auto select one file from the file items */
                $('.files-ctnt-pn-tl').bind('contentchanged',
                    function () {
                        $('.fl-slctd').length ? '' :
                            $(this).find('.fl-hd').each(
                                function () {
                                    $('.fl-slctd').length ? '' : selectThisFileItem($(this));
                                }
                            );
                    }
                );
            /* auto select one file from the file items */
            
            /* auto select one file from the file items */
                $('.files-ctnt-pn-tl').bind('contentchangednofile',
                    function () {
                        $('.fl-slctd').length ? '' : fileProperties('');
                    }
                );
            /* auto select one file from the file items */
            
            /* auto save rename of section */
                $('.files-default-index .form-group input').change(
                    function () {
                        levelName($(this).attr('lvl'), $(this).attr('fm-id'))
                    }
                );
            /* auto save rename of section */
            
            /* trigger store level population */
                $('.files-left-pn-pn-lvls select').change(
                    function (event) {
                        dynamicStorages(lvl = $(this).attr('lvl'), id = $(this).val(), $('#storelevel-' + (lvl * 1 + 1)).length ? $('#storelevel-' + (lvl * 1 + 1)).val() : '');
                        if ($(this).is(':focus')) {
                            populateListDiv($(this));
                            storageProperties(lvl, id);
                        }
                    }
                );
                
                $('#storelevel-' + $storeLevel).change();
            /* trigger store level population */
            
            /* trigger storage list population */
                $('.files-left-pn-pn-lvls .input-group .input-group-addon').click(
                    function () {
                        populateListDiv(elmnt = $(this).parent().find('select'));
                        
                        if ($(this).is(':hover')) {
                            dynamicStorages(lvl = elmnt.attr('lvl'), id = elmnt.val(), $('#storelevel-' + (lvl * 1 + 1)).length ? $('#storelevel-' + (lvl * 1 + 1)).val() : '');
                            storageProperties(lvl, id);
                        }
                    }
                );
                
                $('#storelevel-$folderLevel').parent().find('.input-group-addon').click();
            /* trigger storage list population */
            
            /* populate items user has full rights over */
                userWritePermissions($user);
            /* populate items user has full rights over */
            
            /* advanced store level change handling */
                $('.files-left-pn-pn-lvls select').bind('valuechanged',
                    function () {
                        storeLevelPossibleValue($(this));
                    }
                );
            /* advanced store level change handling */
            
            /* show new storage options where parent has value */
                $('.files-left-pn-pn-new .btn-group').click(
                    function () {
                        newStorageToShow();
                    }
                );
            /* show new storage options where parent has value */
            
            /* actions for creating store elements */
                $('[cls=crt-lvl]').click(
                    function (event) {
                        event.stopPropagation();
                        storage($('.files-left-pn-pn-new [lvl=' + $(this).attr('lvl') + '] a').text(), $(this).attr('actn'), newStoragePostItems($(this).attr('lvl')));
                        $('#str-lvl-fm').text($(this).attr('lvl'));
                        $('#str-fm').text(null);
                        return false;
                    }
                );
                
                $('.custom-menu-new-strg-unts li').click(
                    function () {
                        $('.files-left-pn-pn-new [lvl=' + $(this).attr('lvl') + ']').click();
                    }
                );
            /* actions for creating store elements */
            
            /* manage custom menu on file tiles pane */
                $('.files-ctnt-pn-tl').click(
                    function (event) {
                        $(event.target).hasClass('files-ctnt-pn-tl') ? filesPaneOptions() : filesPaneItemOptions();
                    }
                );
            /* manage custom menu on file tiles pane */
            
            /* manage custom menu on store level list pane */
                $('.files-ctnt-pn-lst').click(
                    function(event) {
                        $(event.target).hasClass('files-ctnt-pn-lst-bdy') ? listBodyOptions() : storeLevelItemOptions();
                    }
                );
            /* manage custom menu on store level list pane */
            
            /* manage custom menus by user rights to item */
                $('.files-ctnt-pn').click(
                    function (event) {
                        checkItemRights($(event.target));
                    }
                );
            /* manage custom menus by user rights to item */
            
            /* put the right and left arrows middle for the carousel */
                $('.carousel-control').css('padding-top', ($('.carousel-control').height() - 20) / 2 + 'px'); //20 is the font size for $('.carousel-control').text()
            /* put the right and left arrows middle for the carousel */
            
            /* align floating menu div appropriately */
                $('#header-float-doc-div').css('top', ($('.files-default-index').height() - $('#header-float-doc-div').height()) / 2 + 'px').css('right', 0);
                $('#sidebar-float-doc-div').css('top', ($('.files-default-index').height() - $('#sidebar-float-doc-div').height()) / 2 + 'px').css('right', $('#sidebar-float-doc-div').width() + 'px');
                $('#slider-float-doc-div').css('right', $('#header-float-doc-div').width() * -1 + 'px');
            /* align floating menu div appropriately */
            
            /* on mouse leave floating menu, hide it */
                $('#header-float-doc-div').on('mouseleave',
                    function () {
                        $('#sidebar-float-doc-div').click();
                    }
                );
            /* on mouse leave floating menu, hide it */
        "
        , View::POS_READY
);
?>