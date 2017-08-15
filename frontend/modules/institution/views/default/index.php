<?php /* @var $this yii\web\View */ ?>
<?php /* @var $navigation mixed */ ?>

<?php

use yii\web\View;
use common\models\Documents;

$file_copy = Documents::file_copy;
$file_move = Documents::file_move
?>

<div class="institution-default-index">
    <div class="inst-nvgtn">
        <div class="inst-nvgtn-pn">
            <?= $navigation ?>
        </div>
    </div>

    <div class="inst-ctnt">
        <div class="inst-ctnt-pn">
            <?= $files_and_folders ?>
        </div>
    </div>

    <div class="inst-prpt">
        <div class="inst-prpt-pn">
            <?= $properties ?>
            <?= $privileges ?>
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
            <div class="btn btn-lg btn-primary glyphicon glyphicon-king" onclick="documentPrivelegesModal()" title="Document Privileges"></div>
            <div class="btn btn-lg btn-primary glyphicon glyphicon-picture" onclick="slideImages()" title="Slide Items"></div>
            <div class="btn btn-lg btn-primary glyphicon glyphicon-barcode" onclick="graphs()" title="Graphs"></div>
        </div>
    </div>
    <!-- floating sliding menu div ends here -->

</div>

<div id="clp-brd" hidden="hidden"></div>

<div id="clp-brd-cmd" hidden="hidden"></div>

<div id="clp-brd-pst" hidden="hidden"></div>

<input id="documents-filename" name="Documents[filename]" elmnt="" type="file" multiple="multiple" style="display: none">

<div id="clk-drg-slct" hidden="hidden"></div>

<!-- custom context menu for navigation folder nodes -->
<ul class="custom-menu custom-menu-nav-fldr-nds">
    <li class="custom-sub-menu custom-sub-menu-title" fldr="" fl="" md="">Directory Options:</li>
    <li class="custom-sub-menu fl-dwnld div1" rgt="rd" onclick="exploreOrOpen($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'), $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'))">Open / Download</li>
    <li class="custom-sub-menu custom-menu-wait has-cstm-mn opn-updt div1" rgt="wrt" cstm-mn=".custom-menu-opn-updt">Lock For Update</li>
    <li class="custom-sub-menu unlk-file div1" rgt="wrt" onclick="unlockFile2($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'))">Cancel Update</li>
    <li class="custom-sub-menu doc-rplc div1" rgt="wrt" onclick="bookFile($('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl')).attr('dcl'))">Update File</li>
    <li class="custom-sub-menu doc-vrsn div1" rgt="wrt"  onclick="loadVersions()">Document Versions</li>
    <li class="custom-sub-menu fl-dwnld-zpd div1" rgt="alt" onclick="zipAndExport2($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'), $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'))">Download In Zipped Folder</li>
    <li class="custom-sub-menu divider" no="div1"></li>
    <li class="custom-sub-menu add-fldr div2" rgt="alt" onclick="createFolderFromNode($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'))">New Folder</li>
    <li class="custom-sub-menu add-file div2" rgt="alt" onclick="bookFile(null)">Upload Files</li>
    <li class="custom-sub-menu dir-rfrs div2" rgt="rd" onclick="dirRefresh()">Refresh</li>
    <li class="custom-sub-menu divider" no="div2"></li>
    <li class="custom-sub-menu slct-optns div3" rgt="alt" onclick="commenceSelect()">Select</li>
    <li class="custom-sub-menu cp-dcmnt custom-menu-wait has-cstm-mn div3" rgt="alt" cstm-mn=".custom-menu-slct-optns" onclick="commenceCopyOrMove('<?= $file_copy ?>')">Copy</li>
    <li class="custom-sub-menu mv-dcmnt custom-menu-wait has-cstm-mn div3" rgt="alt" cstm-mn=".custom-menu-slct-optns" onclick="commenceCopyOrMove('<?= $file_move ?>')">Move</li>
    <li class="custom-sub-menu fl-dplct div3" rgt="alt" onclick="duplicateFile()">Duplicate</li>
    <li class="custom-sub-menu divider" no="div3"></li>
    <li class="custom-sub-menu snd-dcmt div4" rgt="alt" onclick="sendFiles($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'), $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'))">Send</li>
    <li class="custom-sub-menu psh-dcmt div4" rgt="alt" onclick="pushFile($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'))">Push</li>
    <li class="custom-sub-menu divider" no="div4"></li>
    <li class="custom-sub-menu doc-arcv" rgt="alt" onclick="archiveFile()">Archive</li>
    <li class="custom-sub-menu dcmt-dlt" rgt="alt" onclick="recycleFile()">Recycle</li>
    <li class="custom-sub-menu doc-rstr" rgt="alt" onclick="restoreArchivedFile()">Restore</li>
    <li class="custom-sub-menu custom-menu-wait has-cstm-mn doc-rstr2" rgt="alt" cstm-mn=".custom-menu-rstr-rcycl">Restore</li>
    <li class="custom-sub-menu dcmt-drp" rgt="alt" onclick="dropFile()">Drop</li>
    <li class="custom-sub-menu custom-menu-wait has-cstm-mn glyphicon glyphicon-option-vertical slct-mbl-optns" rgt="alt" cstm-mn=".custom-menu-slct-optns" onclick="$(this).parent().hide()"  onmouseout="$(this).parent().hide()"></li>
</ul>
<!-- custom context menu for navigation folder nodes -->

<!-- custom context menu for file open for update -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-opn-updt" rgt="wrt">
    <li class="custom-sub-menu opn-updt-vsbl" rgt="wrt" onclick="openForUpdate($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'), $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'), '<?= Documents::FILE_VISIBLE_DURING_UPDATE ?>')">Visible to others</li>
    <li class="custom-sub-menu opn-updt-invsbl" rgt="wrt" onclick="openForUpdate($('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'), $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl'), '<?= Documents::FILE_NOT_VISIBLE_DURING_UPDATE ?>')">Not visible to others</li>
</ul>
<!-- custom context menu for file open for update -->

<!-- custom context menu for file restore from recycle -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-rstr-rcycl" rgt="alt">
    <li class="custom-sub-menu rstr-to-dcmt" rgt="alt" onclick="restoreRecycledFile('<?= $avl = Documents::FILE_STATUS_AVAILABLE ?>')">To Documents</li>
    <li class="custom-sub-menu rstr-to-arcv" rgt="alt" onclick="restoreRecycledFile('<?= $arc = Documents::FILE_STATUS_ARCHIVED ?>')">To Archives</li>
</ul>
<!-- custom context menu for file restore from recycle -->

<!-- custom context menu for item select -->
<ul class="custom-menu custom-menu-slct-optns" rgt="alt">
    <li class="custom-sub-menu slct-all-fls div5" rgt="alt" onclick="selectAllFiles()">Select All Files</li>
    <li class="custom-sub-menu slct-all-drs div5" rgt="alt" onclick="selectAllFolders()">Select All Folders</li>
    <li class="custom-sub-menu slct-all-ffs div5" rgt="alt" onclick="selectAllFilesAndFolders()">Select All Files and Folders</li>
    <li class="custom-sub-menu divider" no="div5"></li>
    <li class="custom-sub-menu fl-dwnld-clk div6" rgt="alt" onclick="exploreOrOpen2($('#clk-drg-slct').text())">Explore</li>
    <li class="custom-sub-menu fl-dwnld-zip div6" rgt="alt" onclick="zipAndExport()">Download In Zipped Folder</li>
    <li class="custom-sub-menu divider" no="div6"></li>
    <li class="custom-sub-menu fl-dplct-clk div7" rgt="alt" onclick="duplicateFiles()">Duplicate</li>
    <li class="custom-sub-menu cp-dcmnt-clk div7" rgt="alt" onclick="toCopyOrMove('<?= $file_copy ?>')">Copy</li>
    <li class="custom-sub-menu mv-dcmnt-clk div7" rgt="alt" onclick="toCopyOrMove('<?= $file_move ?>')">Move</li>
    <li class="custom-sub-menu pst-dcmt div7" rgt="alt" onclick="doPaste()">Paste</li>
    <li class="custom-sub-menu slct-cntn div7" rgt="alt">Continue Selecting</li>
    <li class="custom-sub-menu ccl-slct div7" rgt="alt" onclick="cancelSelect()">Quit Selecting</li>
    <li class="custom-sub-menu divider" no="div7"></li>
    <li class="custom-sub-menu snd-dcmt-clk div8" rgt="alt" onclick="sendFiles2()">Send</li>
    <li class="custom-sub-menu divider" no="div8"></li>
    <li class="custom-sub-menu doc-arcv-clk div9" rgt="alt" onclick="archiveFiles()">Archive</li>
    <li class="custom-sub-menu dcmt-dlt-clk div9" rgt="alt" onclick="recycleFiles()">Recycle</li>
    <li class="custom-sub-menu doc-rstr-clk div9" rgt="alt" onclick="restoreArchivedFiles()">Restore</li>
    <li class="custom-sub-menu doc-rstr2-clk-doc div9" rgt="alt" onclick="restoreRecycledFiles('<?= $avl ?>')">Restore To Documents</li>
    <li class="custom-sub-menu doc-rstr2-clk-arc div9" rgt="alt" onclick="restoreRecycledFiles('<?= $arc ?>')">Restore To Archives</li>
    <li class="custom-sub-menu dcmt-drp-clk div9" rgt="alt" onclick="dropFiles()">Drop</li>
    <li class="custom-sub-menu divider" no="div9"></li>
    <li class="custom-sub-menu unslct-all-fls" rgt="alt" onclick="unselectAllFiles()">Unselect All Files</li>
    <li class="custom-sub-menu unslct-all-drs" rgt="alt" onclick="unselectAllFolders()">Unselect All Folders</li>
    <li class="custom-sub-menu unslct-all-ffs" rgt="alt" onclick="unselectAllFilesAndFolders()">Unselect All Files and Folders</li>
</ul>
<!-- custom context menu for item select -->

<!-- custom context menu for document explore during privilege setting -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-dcmnt-nvgtn" rgt="alt">
    <li class="custom-sub-menu dcmnt-nvgtn-up" rgt="alt" onclick="documentPrivilegeExplore('up')">Up One Level</li>
    <li class="custom-sub-menu dcmnt-nvgtn-opn" rgt="alt" onclick="documentPrivilegeExplore('opn')">Explore</li>
</ul>
<!-- custom context menu for document explore during privilege setting -->

<!-- custom context menu for section document rights -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-dcmnt-rgts" rgt="alt">
    <li class="custom-sub-menu dcmnt-rgts-rd" rgt="alt" onclick="sectionDocumentRight('<?= $readDoc = Documents::file_read ?>')">Read</li>
    <li class="custom-sub-menu dcmnt-rgts-wrt" rgt="alt" onclick="sectionDocumentRight('<?= $writeDoc = Documents::file_write ?>')">Write</li>
    <li class="custom-sub-menu dcmnt-rgts-alt" rgt="alt" onclick="sectionDocumentRight('<?= $alterDoc = Documents::file_alter ?>')">Alter</li>
    <li class="custom-sub-menu dcmnt-rgts-rmv" rgt="alt" onclick="sectionDocumentRight('<?= $denyDoc = Documents::file_deny ?>')">Deny</li>
</ul>
<!-- custom context menu for section document rights -->

<!-- custom context menu for user section rights -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-sctn-rgts" rgt="alt">
    <li class="custom-sub-menu sctn-rgts-rd" rgt="alt" onclick="userSectionRight('<?= $otherUser = Documents::make_other_user ?>')">Read</li>
    <li class="custom-sub-menu sctn-rgts-wrt" rgt="alt" onclick="userSectionRight('<?= $subAdminUser = Documents::make_sub_admin ?>')">Write</li>
    <li class="custom-sub-menu sctn-rgts-alt" rgt="alt" onclick="userSectionRight('<?= $adminUser = Documents::make_admin ?>')">Alter</li>
    <li class="custom-sub-menu sctn-rgts-rmv" rgt="alt" onclick="userSectionRight('<?= $removedUser = Documents::remove_user ?>')">Remove</li>
</ul>
<!-- custom context menu for user section rights -->

<!-- custom context menu for version files -->
<ul class="custom-menu custom-menu-auto-hide custom-menu-vrsn-fls" rgt="wrt">
    <li class="custom-sub-menu vrsn-dtl" rgt="wrt"></li>
    <li class="custom-sub-menu vrsn-rvt" onclick="revertToVersion()" rgt="alt">Revert</li>
    <li class="custom-sub-menu vrsn-opn" onclick="downloadVersion()" rgt="wrt">Download</li>
    <li class="custom-sub-menu vrsn-dlt" onclick="deleteVersion()" rgt="alt">Delete</li>
</ul>
<!-- custom context menu for version files -->

<?php $min_level = Documents::min_sub_root_document_level ?>
<?php $min_client_doc_level = Documents::min_client_document_level ?>
<?php $default_status = Documents::FILE_STATUS_AVAILABLE ?>
<?php $status_archive = Documents::FILE_STATUS_ARCHIVED ?>
<?php $status_recycle = Documents::FILE_STATUS_DELETED ?>
<?php $file_not_in_db = Documents::file_not_in_db ?>
<?php $file_not_exists = Documents::file_not_exists ?>
<?php $file_destination_not_in_db = Documents::file_destination_not_in_db ?>
<?php $file_destination_not_exists = Documents::file_destination_not_exists ?>
<?php $file_not_reach_server = Documents::file_upload_not_reach_server ?>
<?php $already_open_for_update = Documents::is_opened_for_update ?>
<?php $not_open_for_update = Documents::is_not_opened_for_update ?>
<?php $user = Yii::$app->user->identity->id ?>
<?php $true = Documents::FILE_CAN_BE_UPDATED ?>
<?php $false = Documents::FILE_CAN_NOT_BE_UPDATED ?>
<?php $section_active = Documents::section_active ?>
<?php $section_not_active = Documents::section_not_active ?>
<?php $profile = common\models\Profiles::returnProfile(Yii::$app->user->identity->profile)->profile ?>
<?php $admin = \common\models\User::USER_ADMIN ?>
<?php $detail_delimiter = common\models\DocumentsMailings::detail_delimiter ?>
<?php $connection_failed = \common\models\DocumentsMailings::connection_failed ?>

<?php
$this->registerJs(
        "
                function orderFilesDispled(mylist, selector, order) {
                    var listitems = mylist.children(selector).get();

                    listitems.sort(
                        function(a, b) {
                            return $(a).find(order).text().toUpperCase().localeCompare($(b).find(order).text().toUpperCase());
                        }
                    );

                    $.each(listitems, function(idx, itm) { mylist.append(itm); });
                }
                
                function highlightTheSelected() {
                    if ($('#clp-brd').text() !== null && $('#clp-brd').text() !== '') {
                        items = $('#clp-brd').text().split(',');
                        
                        for (var i = 0; i < items.length; i++)
                            $('[dcl=' + items[i] + ']').addClass('is-slctd');
                    }
                }

                function dirRefresh() {
                    $('.u-ia').find('.nvgtn-fldr-ctnr-glyph-rgt').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                    $('.u-ia').find('.nvgtn-fldr-ctnr-glyph-rgt').click();
                }
                
                function loadDirectory(filename, status, level, slctd) {
                    if (status !== '' && status !== null)
                        $.post('sections/load-directory', {'filename': filename, 'status': status, 'level': level},
                                function (content) {
                                    $('.inst-ctnt-pn').html(content).trigger('contentchanged');
                                    chosenFile(slctd) ? documentProperties(filename, status, level) : '';
                                }
                        )
                }
                
                function reloadNavigation(filename, status, level, slctd) {
                    if (status !== '' && status !== null)
                        $.post('sections/reload-navigation', {'filename': filename, 'status': status},
                                function (content) {
                                    html = $('.inst-nvgtn-pn').html();
                                    
                                    if ($('.inst-nvgtn-pn').html(content).find('.u-ia').length)
                                        loadDirectory(filename, status, level * 1 + 1, slctd);
                                    else {
                                        $('.inst-nvgtn-pn').html(html);
                                        customErrorSwal('Well,', 'Document exploration reached the end', 2000, 'info');
                                    }
                                }
                        )
                }
                
                function reloadNavigation2(docRow, lessLevel) {
                    reloadNavigation(docRow.attr('dok-fldr'), docRow.attr('dok-stts'), docRow.attr('dok-lvl') * 1 - lessLevel * 1, docRow.attr('dok-id'));
                }
                
                function reloadNavigation3(docRow) {
                    reloadNavigation(docRow.attr('fldr'), docRow.attr('stts'), docRow.attr('lvl'), docRow.attr('doc'));
                }
                
                function chosenFile(slctd) {
                    elmnt = $('[dcl=' + slctd + ']');
                    
                    if (elmnt.length) {
                        elmnt.addClass('is-hgltd');
                        $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr', $('.u-ia').attr('id')).attr('fl', elmnt.attr('id'));
                        documentProperties($('.u-ia').attr('nm') + '/' + elmnt.attr('nm'), $('.u-ia').attr('stts'), $('.u-ia').attr('lvl') * 1 + 1);
                        return false;
                    }
                    
                    return true;
                }
                
                function documentProperties(filename, status, level) {
                    $.post('sections/document-properties', {'filename': filename, 'status': status, 'level': level},
                            function (properties) {
                                $('.inst-prpt-pn-sub-prpty-dtls').html(properties);
                            }
                    )
                }
                
                function createFolder(id, dir, name, folderLevel, stts, folder, refresh) {
                
                    var fd = new FormData();
                    fd.append('Documents[id]', id);
                    fd.append('Documents[directory]', dir);
                    fd.append('Documents[name]', name);
                    fd.append('Documents[file_level]', folderLevel * 1 + 1);
                    fd.append('Documents[status]', stts);
                    fd.append('folder', folder);

                    $.ajax(
                        {
                            contentType:false,
                            processData: false,
                            async: false,
                            cache: false,
                            type: 'post',
                            url: 'sections/make-directory',
                            data: fd,
                            success: function (created) {
                                refresh.click();
                                customErrorSwal(created ? 'Completed' : 'Directory was not created', created ? ('<h3>Folder created successfully</h3>') : ('<p>Their might be an unrenamed New Folder</p>'), created ? 2000 : 600000, created ? 'success' : 'error');
                            },
                            error : function () {
                                customErrorSwal('An Error Occured', 'An internal server error was encountered', 2000, 'error');
                            }
                        }
                    );
                }
                
                function createFolderFromNode(id) {
                    node = $('#' + id);

                    node.find('.nvgtn-fldr-ctnr-glyph-rgt').removeClass('glyphicon-minus').addClass('glyphicon-plus');

                    createFolder(null, node.attr('cld'), 'New Folder', node.attr('lvl'), node.attr('stts'), node.attr('nm'), node.find('.nvgtn-fldr-ctnr-glyph-rgt'));
                }

                function handleNewFileUpload(id, dir, files, folderLevel, stts, folder, refresh) {
                
                    var uploadStatus = '';
                    
                    customAjaxLoader('File Upload', 'Please wait while files upload...');
                    
                    for (var i = 0; i < files.length; i++) {
                        var fd = new FormData();
                        fd.append('Documents[id]', id);
                        fd.append('Documents[directory]', dir);
                        fd.append('Documents[name]', files[i].name);
                        fd.append('Documents[filename]', files[i]);
                        fd.append('Documents[file_level]', folderLevel * 1 + 1);
                        fd.append('Documents[status]', stts);
                        fd.append('folder', folder);
                        var filename = files[i].name;
                        
                        $.ajax(
                            {
                                contentType:false,
                                processData: false,
                                async: false,
                                cache: false,
                                type: 'post',
                                url: 'sections/upload-files',
                                data: fd,
                                success: function (uploaded) {
                                    uploaded ? ('') : (uploadStatus = uploadStatus + '<p>' + filename + '</p>');
                                },
                            }
                        );
                    }

                    ok =  uploadStatus === '' || uploadStatus === null;
                    
                    refresh.click();

                    customErrorSwal(ok ? 'Completed' : 'Partial Upload', ok ? ('<h3>Files uploading completed successfully</h3>') : ('<h3>The following files were not uploaded:</h3>' + uploadStatus), ok ? 2000 : 600000, ok ? 'success' : 'error');
                }
                
                function reloadOpenedForUpdate() {
                    $.post('sections/opened-for-update', {},
                        function(opnd) {
                            $('#opnf-4-updt').html(opnd);
                        }
                    );
                }
                
                function documentsUserHasRightTo() {
                    $.post('sections/documents-user-has-right-to', {},
                        function(rght2) {
                            $('#usa-as-rgt-to').html(rght2);
                        }
                    );
                }

                function handleFileUpdate(id, files, stts, folder, refresh) {
                
                    var uploadStatus = '';

                    customAjaxLoader('Document Update', 'Please wait while document updates...');

                    for (var i = 0; i < files.length; i++) {
                        var fd = new FormData();
                        fd.append('Documents[id]', id);
                        fd.append('Documents[filename]', files[i]);
                        fd.append('status', stts);
                        fd.append('folder', folder);
                        var filename = files[i].name;
                        
                        $.ajax(
                            {
                                contentType:false,
                                processData: false,
                                async: false,
                                cache: false,
                                type: 'post',
                                url: 'sections/update-file',
                                data: fd,
                                success: function (uploaded) {
                                    if (uploaded === '$file_not_in_db')
                                        customErrorSwal('Not In Database', 'File Not Found In The Database', '1200', 'error');
                                    else
                                    if (uploaded === '$file_not_exists')
                                        fileNotFound($('#' + filename).attr('title'));
                                    else
                                    if (uploaded === '$file_not_reach_server')
                                        customErrorSwal('Failed', 'File was not uploaded.<br/><br/>Please retry', '1200', 'error');
                                    else
                                    if (uploaded === '$not_open_for_update')
                                        customErrorSwal('Declined', 'The original file is not open for update', '1200', 'error');
                                    else {
                                        reloadOpenedForUpdate();
                                        customErrorSwal('Sucessful', 'File update complete', '1200', 'success');
                                        refresh.click();
                                    }
                                },
                            }
                        );
                        
                        return false;
                    }
                }
                
                function fileDownloadHere(id, status, title) {
                    $.post('sections/open-file', {'id': id, 'status': status},
                        function (url) {
                            if (url === '$file_not_in_db')
                                customErrorSwal('Not In Database', 'File Not Found In The Database', '1200', 'error');
                            else
                            if (url === '$file_not_exists')
                                fileNotFound(title);
                            else {
                                popWindow(url, title);
                                $.post('sections/drop-exported-file', {'link': url}, function () {});
                                swal.close();
                            }
                        }
                    );
                }
                
                function exploreOrOpen(dir, fl) {
                    if (fl !== null && fl !== '') {
                        customAjaxLoader('File Download', 'Please wait while we work on this...');
                        fileDownloadHere($('#' + fl).attr('dcl'), $('#' + dir).attr('stts'), $('#' + fl).attr('title'));
                    } else {
                        $('#' + dir).find('.nvgtn-fldr-ctnr-glyph-rgt').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                        $('#' + dir).find('.nvgtn-fldr-ctnr-glyph-rgt').click();
                    }
                }
                
                function exploreOrOpen2(dir) {
                    if (dir !== '' && dir !== null && (prnt = $('#' + dir)))
                        reloadNavigation(prnt.attr('nm'), prnt.attr('stts'), prnt.attr('lvl'), null);
                }
                
                function downloadFileToUpdate (docRow) {
                    fileDownloadHere(docRow.attr('dok-id'), docRow.attr('dok-stts'), docRow.attr('doc-name'));
                }
                
                function doZipAndExport(ids, status) {
                    customAjaxLoader('File Download', 'Please wait while we work on this...');
                        
                    $.post('sections/zip-and-export', {ids: ids, status: status},
                        function (url) {
                            if (url === '' || url === null)
                                customErrorSwal('Oh Sorry,', 'There were no files to export', '2000', 'info');
                            else {
                                popWindow(url, 'Zipped Folder');
                                $.post('sections/drop-exported-file', {'link': url}, function () {});
                                cancelSelect();
                                swal.close();
                            }
                        }
                    );
                }
                
                function zipAndExport() {
                    if ($('#clp-brd').text() !== null && $('#clp-brd').text() !== '')
                        doZipAndExport($('#clp-brd').text(), $('.u-ia').attr('stts'));
                }
                
                function zipAndExport2(dir, fl) {
                    doZipAndExport($('#' + ((is_fl = fl !== null && fl !== '') ? fl : dir)).attr(is_fl ? 'dcl' : 'cld'), $('.u-ia').attr('stts'));
                }
                
                function doSendFiles() {
                    customAjaxLoader('Sending Files', 'Please wait while we work on this...');
                    
                    post = $('#form-send-documents').serializeArray();
                    
                    post.push({name: 'sbmt', value: ''}, {name: 'status', value: $('.u-ia').attr('stts')});
                        
                    $.post('sections/send-files', post,
                        function (sent) {
                            if (sent === null || sent === '' || sent === '$connection_failed' || $.isNumeric(sent)) {
                                sent === null || sent === '' || sent === '$connection_failed' ? '' : $('#documentsmailings-id').val(sent);
                                customErrorSwal((notConnect = sent === null || sent === '$connection_failed') ? 'Connection Failed' : 'Done', notConnect ? 'We could not connect to your email host service<br/><br/>Check that you have adequate internet access' : 'Your documents have been sent', '10000', notConnect ? 'info' : 'success');
                            } else {
                                $('#document-mailing-form').html(sent);
                                swal.close();
                            }
                        }
                    );
                }
                
                function pushFile(id) {
                    customAjaxLoader('Sending Files', 'Please wait while we work on this...');
                    
                    $.post('sections/push-files', {'id': $('#' + id).attr('dcl')},
                        function (pushed) {
                            alert(pushed);
                            swal.close();
                        }
                    );
                }
                
                function contactFormValues(id, name, email, dscrptn) {
                    $('#documentsmailingscontacts-id').val(id);
                    $('#documentsmailingscontacts-email').val(email);
                    $('#documentsmailingscontacts-description').val(dscrptn);
                    $('#documentsmailingscontacts-names').val(name).focus();
                }
                
                function contactToForm(contactRow) {
                    contactFormValues(contactRow.attr('ctnct-id'), contactRow.find('.ctnct-nm').text(), contactRow.find('.ctnct-nm').attr('title'), contactRow.find('.ctnct-dscrptn').text());
                }
                
                function markSelectedRecipients() {
                    contacts = $('#documentsmailings-to').val();
                    contacts = contacts + (contacts !== '' && newContacts !== null && (val = $('#documentsmailings-cc').val()) !== '' && val !== null  ? ',' : '') + $('#documentsmailings-cc').val();
                    contacts = contacts + (contacts !== '' && newContacts !== null && (val = $('#documentsmailings-bcc').val()) !== '' && val !== null  ? ',' : '') + $('#documentsmailings-bcc').val();

                    contacts = contacts.split(',');

                    $('#contacts-table').find('.ctnct-id').each(
                        function () {
                            if (!$(this).hasClass('ctnct-slctd'))
                                for (var i = 0; i < contacts.length; i++) {
                                    contactDetail = contacts[i].split('$detail_delimiter');
                                    
                                    if ($(this).find('.ctnct-nm').text() === contactDetail[0] || $(this).find('.ctnct-nm').attr('title') === contactDetail[1])
                                        $(this).addClass('ctnct-slctd').find('.glyphicon-send').css('color', '#0a0');
                                }
                        }
                    );
                }
                
                function updateSelectedRecipient(name, email) {
                    lowerName = name.toLowerCase();
                    lowerEmail = email.toLowerCase();
                    
                    fields = [$('#documentsmailings-to'), $('#documentsmailings-cc'), $('#documentsmailings-bcc')];
                    
                    for (var i = 0; i < fields.length; i++)
                        if (fields[i].val() !== '' && fields[i] !== null) {
                            contacts = fields[i].val().split(',');
                            
                            newContacts = '';
                            
                            for (var j = 0; j < contacts.length; j++) {
                                contactDetail = contacts[j].split('$detail_delimiter');
                                
                                zero = contactDetail[0].toLowerCase();
                                one = contactDetail[1].toLowerCase();
                                
                                if (lowerName === zero || lowerName === one || lowerEmail === zero || lowerEmail === one)
                                    newContacts = newContacts + (newContacts === '' || newContacts === null ? '' : ',') + name + '$detail_delimiter' + email;
                                else
                                    newContacts = newContacts + (newContacts === '' || newContacts === null ? '' : ',') + contactDetail[0] + '$detail_delimiter' + contactDetail[1];
                            }
                            
                            fields[i].val(newContacts);
                        }
                }
                
                function mailingContacts() {
                    $.post('sections/mailing-contacts', {},
                        function (contacts) {
                            $('#mailing-contacts-list').html(contacts);
                            markSelectedRecipients();
                        }
                    );
                }
                
                function saveContactDetail() {
                    $.post('sections/mailing-contact', $('#form-documents-mail-contacts').serialize(),
                        function (saved) {
                            $('#contact-form').html(saved);
                            updateSelectedRecipient($('#documentsmailingscontacts-names').val(), $('#documentsmailingscontacts-email').val());
                            mailingContacts();
                        }
                    );
                }
                
                function isNotSelected(name, email, attr) {
                    name = name.toLowerCase();
                    email = email.toLowerCase();
                    
                    fields = [$('#documentsmailings-to'), $('#documentsmailings-cc'), $('#documentsmailings-bcc')];

                    for (var i = 0; i < fields.length; i++)
                        if (fields[i].attr('id') !== $('#documentsmailings-' + attr).attr('id') && fields[i].val() !== '' && fields[i] !== null) {
                            contacts = fields[i].val().split(',');
                            
                            for (var j = 0; j < contacts.length; j++) {
                                contactDetail = contacts[j].split('$detail_delimiter');
                                
                                zero = contactDetail[0].toLowerCase();
                                one = contactDetail[1].toLowerCase();
                                
                                if (name === zero || name === one || email === zero || email === one)
                                    return false;
                            }
                        }
                        
                    return true;
                }
                
                function selectedContacts() {
                    selected = '';
                    
                    $('#contacts-table').find('.ctnct-slctd').each(
                        function () {
                            if (isNotSelected($(this).find('.ctnct-nm').text(), $(this).find('.ctnct-nm').attr('title'), $('#to-cc-bcc').html()))
                                selected = selected + (selected === '' || selected === null ? '' : ',') + $(this).find('.ctnct-nm').text() + '$detail_delimiter' + $(this).find('.ctnct-nm').attr('title');
                        }
                    );
                    
                    $('#documentsmailings-' + $('#to-cc-bcc').html()).val(selected).focus();
                }
                
                function unselectContact(name, email) {
                    name = name.toLowerCase();
                    email = email.toLowerCase();
                    
                    fields = [$('#documentsmailings-to'), $('#documentsmailings-cc'), $('#documentsmailings-bcc')];
                    
                    for (var i = 0; i < fields.length; i++)
                        if (fields[i].val() !== '' && fields[i] !== null) {
                            contacts = fields[i].val().split(',');
                            
                            newContacts = '';
                            
                            for (var j = 0; j < contacts.length; j++) {
                                contactDetail = contacts[j].split('$detail_delimiter');
                                
                                zero = contactDetail[0].toLowerCase();
                                one = contactDetail[1].toLowerCase();
                                
                                if (name !== zero && name !== one && email !== zero && email !== one)
                                    newContacts = newContacts + (newContacts === '' || newContacts === null ? '' : ',') + contactDetail[0] + '$detail_delimiter' + contactDetail[1];
                            }
                            
                            fields[i].val(newContacts);
                        }
                }

                function selectContact(contactRow) {
                    if (contactRow.hasClass('ctnct-slctd')) {
                        contactRow.removeClass('ctnct-slctd').find('.glyphicon-send').css('color', '#f8d486');
                        unselectContact(contactRow.find('.ctnct-nm').text(), contactRow.find('.ctnct-nm').attr('title'));
                    } else
                        contactRow.addClass('ctnct-slctd').find('.glyphicon-send').css('color', '#0a0');
                    
                    selectedContacts();
                }
                
                function deleteContact(id) {
                    $.post('sections/delete-contact', {'id': id},
                        function (deleted) {
                            deleted * 1 > 0 ? mailingContacts() : '';
                        }
                    );
                }
                
                function sendFiles(dir, fl) {
                    yiiModal('Send Documents As Email Attachment', 'sections/document-mailing-modal', {'ids': $('#' + ((is_fl = fl !== null && fl !== '') ? fl : dir)).attr(is_fl ? 'dcl' : 'cld'), 'status': $('.u-ia').attr('stts')}, $('.inst-ctnt').width(), $('.institution-default-index').height());
                }
                
                function sendFiles2 () {
                    if ($('#clp-brd').text() !== null && $('#clp-brd').text() !== '')
                        yiiModal('Send Documents As Email Attachment', 'sections/document-mailing-modal', {'ids' : $('#clp-brd').text(), 'status': $('.u-ia').attr('stts')}, $('.inst-ctnt').width(), $('.institution-default-index').height());
                }
                
                function openForUpdate(dir, fl, vsbl) {
                    $.post('sections/open-file-for-update',
                        {
                            id: $('#' + fl).attr('dcl'),
                            status: $('#' + dir).attr('stts'),
                            'Documents[visible_to_others_during_update]': vsbl,
                            'Documents[opened_for_update_by]': '$user'
                        },
                        function (url) {
                            customAjaxLoader('File Download', 'Please wait while we work on this...');
                            
                            if (url === '$file_not_in_db')
                                customErrorSwal('Not In Database', 'File Not Found In The Database', '1200', 'error');
                            else
                            if (url === '$file_not_exists')
                                fileNotFound($('#' + fl).attr('title'));
                            else
                            if (url === '$already_open_for_update')
                                customErrorSwal('Declined', 'This file is already opened for update by another user', '1200', 'error');
                            else {
                                popWindow(url, $('#' + fl).attr('title'));
                                $.post('sections/drop-exported-file', {'link': url}, function () {});
                                dirRefresh();
                                reloadOpenedForUpdate();
                                swal.close();
                            }
                        }
                    );
                }
                
                function doFileUnlock(id, status, name, refresh) {
                    $.post('sections/unlock-file', {'Documents[id]': id, 'status': status},
                        function (url) {
                            customAjaxLoader('File Download', 'Please wait while we work on this...');
                            
                            if (url === '$file_not_in_db')
                                customErrorSwal('Not In Database', 'File Not Found In The Database', '1200', 'error');
                            else
                            if (url === '$file_not_exists')
                                fileNotFound(name);
                            else {
                                refresh && status === $('.u-ia').attr('stts') ? dirRefresh() : '';
                                reloadOpenedForUpdate();
                                swal.close();
                            }
                        }
                    );
                }
                
                function unlockFile(docRow) {
                    doFileUnlock(docRow.attr('dok-id'), docRow.attr('dok-stts'), docRow.attr('dok-name'), docRow.attr('dok-fldr') === $('.u-ia').attr('nm'));
                }
                
                function unlockFile2(id) {
                    id === '' || id === null ? '' : doFileUnlock(id = $('#' + id).attr('dcl'), $('.u-ia').attr('stts'), $('#' + id).attr('title'), true);
                }
                
                function moveOrCopy(froms, to, status, cpMv, url, prop, new_status) {
                    pending = [];

                    for (var i = 0; i < froms.length; i++) {
                        from = froms[i]
                        
                        $.post(url, {'from': from , 'to': to, 'status': status, 'copy_or_move': cpMv, new_status : new_status},
                            function (cpMved) {
                                if (cpMved === '1')
                                    $('[' + prop + '=' + from + ']').removeClass('is-slctd');
                                else
                                    pending[pending.length] = from;
                            }
                        );
                    }
                    
                    done = pending.length === 0;
                    
                    $('#clp-brd').html(pending.join(','));
                    
                    reloadOpenedForUpdate();
                    
                    documentsUserHasRightTo();

                    customErrorSwal(done ? 'Completed' : 'Partial File ' + (cpMv === '$file_copy' ? 'Copy' : 'Move'), done ? ('<h3>Files ' + (cpMv === '$file_copy' ? 'Copied' : 'Moved') + ' successfully</h3>') : ('<h3>The action failed on the selected files</h3>'), 2000, done ? 'success' : 'error');
                    
                    return done;
                }
                
                function fileUpdatability(item, attrib) {
                    if (item.attr('stts') && item.attr('stts') !== '' && item.attr('stts') !== null && item.attr('cdl') && item.attr('cdl') !== '' && item.attr('cdl') !== null) {
                        $.post('sections/file-updatability', {'id' : item.attr('cdl'), 'status': item.attr('stts'), attribute: attrib, value: item.hasClass('btn-success') ? '$false' : '$true'},
                            function (updated) {
                                if (updated) {
                                    item.removeClass((hasSuccess = item.hasClass('btn-success')) ? 'btn-success' : 'btn-warning').addClass(hasSuccess ? 'btn-warning' : 'btn-success').text(hasSuccess ? 'No' : 'Yes');
                                    
                                    to_check = $('[dcl=' + item.attr('cdl') + ']');
                                    
                                    cls = attrib === 'can_be_updated' ? ('can-updt') : (attrib === 'can_be_moved' ? 'can-mv' : 'can-dlt');
                                    
                                    hasSuccess ? (to_check.removeClass(cls)) : (cls !== 'can-updt' || to_check.hasClass('file-in-ctnt-pn') ? to_check.addClass(cls) : '');
                                    
                                    attrib === 'can_be_updated' ? reloadOpenedForUpdate() : '';
                                }
                            }
                        );
                    }
                }
                
                function changeNameOfFile(item) {
                    $.post('sections/change-name-of-file', {'id': item.attr('cdl'), 'status': item.attr('stts'), 'name': item.text()},
                        function (renamed) {
                            if (renamed) {
                                item.text(renamed);
                                
                                $('[dcl=' + item.attr('cdl') + ']').attr('title', renamed);
                                $('[dcl=' + item.attr('cdl') + '] .fldr-in-ctnt-pn-ttl').text(renamed);
                                $('[dcl=' + item.attr('cdl') + '] .file-in-ctnt-pn-ttl').text(renamed);
                                
                                $('[cld=' + item.attr('cdl') + ']').attr('title', renamed);
                                $('[cld=' + item.attr('cdl') + '] .nvgtn-fldr-ctnr-nm-txt').text(renamed);
                                $('[dok-id=' + item.attr('cdl') + ']').attr('title', renamed).attr('dok-name', renamed).find('.dok-nm').text(renamed.substr(0, $('[dcl=' + item.attr('cdl') + ']').hasClass('fldr-in-ctnt-pn') ? 49 : 29));
                                
                                item.css('border', 'none');
                            } else
                                item.css('border', '1px solid #f00');
                        }
                    );
                }
                
                function moveOrCopyInit(froms, to, status, cpMv, url, prop, refresh, new_status) {
                    if (moveOrCopy(froms, to, status, cpMv, url, prop, new_status)) {
                        refresh.removeClass('glyphicon-minus').addClass('glyphicon-plus').click();
                        cancelSelect();
                    }
                }
                
                function doPaste() {
                    moveOrCopyInit($('#clp-brd').text().split(','), $('#clp-brd-pst').text(), $('[cld=' + $('#clp-brd-pst').text() + ']').attr('stts'), $('#clp-brd-cmd').text(), 'sections/copy-or-move-file', 'dcl', $('[cld=' + $('#clp-brd-pst').text() + ']').find('.nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function doDropFile(ids, prop, refresh) {
                    pending = [];

                    for (var i = 0; i < ids.length; i++) {
                        id = ids[i]
                        
                        $.post('sections/drop-file', {'id': id},
                            function (dropped) {
                                if (dropped === '1')
                                    $('[' + prop + '=' + id + ']').removeClass('is-slctd');
                                else
                                    pending[pending.length] = id;
                            }
                        );
                    }
                    
                    done = pending.length === 0;
                    
                    $('#clp-brd').html(pending.join(','));
                    
                    reloadOpenedForUpdate();
                    
                    documentsUserHasRightTo();

                    customErrorSwal(done ? 'Completed' : 'Partial File Deletion', done ? ('<h3>Files deleted successfully</h3>') : ('<h3>The action failed on the selected files</h3>'), 2000, done ? 'success' : 'error');
                    
                    return done;
                }
                
                function dropFileInit (ids, prop, refresh) {
                    if (doDropFile(ids, prop, refresh)) {
                        refresh.removeClass('glyphicon-minus').addClass('glyphicon-plus').click();
                        cancelSelect();
                    }
                }
                
                function duplicateFile() {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    moveOrCopyInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], null, $('.u-ia').attr('stts'), '$file_copy', 'sections/duplicate-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function duplicateFiles() {
                    moveOrCopyInit($('#clp-brd').text().split(','), null, $('.u-ia').attr('stts'), '$file_copy', 'sections/duplicate-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function archiveFile() {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    moveOrCopyInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], null, $('.u-ia').attr('stts'), '$file_move', 'sections/archive-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function archiveFiles() {
                    moveOrCopyInit($('#clp-brd').text().split(','), null, $('.u-ia').attr('stts'), '$file_move', 'sections/archive-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function restoreArchivedFile() {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    moveOrCopyInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], null, $('.u-ia').attr('stts'), '$file_move', 'sections/restore-archived-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function recycleFile() {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    moveOrCopyInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], null, $('.u-ia').attr('stts'), '$file_move', 'sections/recycle-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function recycleFiles() {
                    moveOrCopyInit($('#clp-brd').text().split(','), null, $('.u-ia').attr('stts'), '$file_move', 'sections/recycle-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function restoreArchivedFiles() {
                    moveOrCopyInit($('#clp-brd').text().split(','), null, $('.u-ia').attr('stts'), '$file_move', 'sections/restore-archived-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), null);
                }
                
                function restoreRecycledFile(new_status) {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    moveOrCopyInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], null, $('.u-ia').attr('stts'), '$file_move', 'sections/restore-recycled-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), new_status);
                }
                
                function restoreRecycledFiles(new_status) {
                    moveOrCopyInit($('#clp-brd').text().split(','), null, $('.u-ia').attr('stts'), '$file_move', 'sections/restore-recycled-file', 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'), new_status);
                }
                
                function dropFile() {
                    slct = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title');
                    
                    is_dir = slct.attr('fl') === null || slct.attr('fl') === '';
                    
                    dcmnt = $('#' + (is_dir ? slct.attr('fldr') : slct.attr('fl')));
                    
                    dropFileInit([(is_dir ? dcmnt.attr('cld') : dcmnt.attr('dcl'))], 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'));
                }
                
                function dropFiles() {
                    dropFileInit($('#clp-brd').text().split(','), 'dcl', $('.u-ia .nvgtn-fldr-ctnr-glyph-rgt'));
                }
                
                function bookFile(dcmnt) {
                    $('#documents-filename').attr('dcmnt', dcmnt);
                    $('#documents-filename').click();
                }
                
                function bookFile2(docRow) {
                    $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr', $('.u-ia').attr('id'));
                    bookFile(docRow.attr('dok-id'));
                    $('#documents-filename').attr('dok-fldr', docRow.attr('dok-fldr'));
                    $('#documents-filename').attr('dok-stts', docRow.attr('dok-stts'));
                    
                }
                
                function selectTheDocument(elmnt) {
                    if (elmnt.hasClass('fldr-in-ctnt-pn') || elmnt.hasClass('file-in-ctnt-pn'))
                        elmnt.hasClass('is-slctd') ? elmnt.removeClass('is-slctd').trigger('selecteditems') : elmnt.removeClass('is-hgltd').addClass('is-slctd').trigger('selecteditems');
                    else
                    if (elmnt.parent().hasClass('fldr-in-ctnt-pn') || elmnt.parent().hasClass('file-in-ctnt-pn'))
                        elmnt.parent().hasClass('is-slctd') ? elmnt.parent().removeClass('is-slctd').trigger('selecteditems') : elmnt.parent().removeClass('is-hgltd').addClass('is-slctd').trigger('selecteditems');
                }
                
                function commenceSelect() {
                    if ($('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr')).attr('cld') && $('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr')).attr('cld') !== null && $('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr')).attr('cld') !== '') {

                        $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('md', 'slctn');

                        selectTheDocument(
                            $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl') !== null && $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl') !== '' ?
                                $('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl')) :
                                $('[dcl=' + $('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr')).attr('cld') + ']')
                        );
                        
                        $('.fl-dwnld-clk').hide();
                        
                    }
                }
                
                function toCopyOrMove(actn) {
                    $('#clp-brd-cmd').html(actn);
                }
                
                function commenceCopyOrMove(actn) {
                    toCopyOrMove(actn);
                    commenceSelect();
                    $('.custom-menu-nav-fldr-nds').hide();
                }
                
                function selectAllFolders() {
                    $('.fldr-in-ctnt-pn').addClass('is-slctd').trigger('selecteditems');
                }
                
                function selectAllFiles() {
                    $('.file-in-ctnt-pn').addClass('is-slctd').trigger('selecteditems');
                }
                
                function selectAllFilesAndFolders() {
                    selectAllFiles();
                    selectAllFolders();
                }
                
                function unselectAllFolders() {
                    $('.fldr-in-ctnt-pn').removeClass('is-slctd').trigger('selecteditems');
                }
                
                function unselectAllFiles() {
                    $('.file-in-ctnt-pn').removeClass('is-slctd').trigger('selecteditems');
                }
                
                function unselectAllFilesAndFolders() {
                    unselectAllFiles();
                    unselectAllFolders();
                }
                
                function finishSelecting() {
                    $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('md', null);
                    $('.custom-menu-slct-optns').hide();
                    $('.custom-menu-nav-fldr-nds').show();
                }
                
                function cancelSelect() {
                    $('.is-slctd').removeClass('is-slctd');
                    $('#clp-brd').html(null);
                    $('#clp-brd-cmd').html(null);
                    $('#clp-brd-pst').html(null);
                    finishSelecting();
                }
                
                function clipBoard() {
                    if ((clpbrdstring = $('#clp-brd').text()) !== null && clpbrdstring !== '') {
                        clpbrdvalues = clpbrdstring.split(',');

                        for (i = 0; i < clpbrdvalues.length; i++)
                            (elmnt = $('[dcl=' + clpbrdvalues[i] + ']')) && elmnt.length > 0 && !elmnt.hasClass('is-slctd') ? clpbrdvalues.splice(i, 1) : '';
                        
                        $('#clp-brd').html(clpbrdvalues.join(','));
                    }
                    
                    $(document).find('.is-slctd').each(
                        function () {
                            if (((clpbrd = $('#clp-brd').text()) === null || clpbrd === '') || $.inArray($(this).attr('dcl'), clpbrd.split(','), 0) * 1 < 0)
                                $('#clp-brd').html( (clpbrd === null || clpbrd === '' ? ('') : (clpbrd + ',')) + $(this).attr('dcl') );
                        }
                    );
                }
                
                function clickAndContextEventParent(e) {
                    if ($(e.target).hasClass('inst-ctnt-pn-dr-pn') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('file-in-ctnt-pn'))
                        prnt = $('.u-ia');
                    else
                    if ($(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn'))
                        prnt = $('[cld=' + ($(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).attr('dcl') : $(e.target).parent().attr('dcl')) + ']');
                    else
                        prnt = $(e.target).parent();
                        
                    return prnt;
                }
                
                function itemIsSelected(item_id) {
                    return $.inArray(item_id, $('#clp-brd').text() === '' || $('#clp-brd').text() === null ? [] : $('#clp-brd').text().split(',')) > -1;
                }
                
                function clickAndContextEventNavigation(e, prnt) {
                    if ($(e.target).hasClass('nvgtn-fldr-ctnr-glyph-rgt')) {

                        if (itemIsSelected(prnt.attr('cld')))
                            return false;
                            
                        if ($(e.target).hasClass('glyphicon-plus') || !$(e.target).parent().hasClass('u-ia'))
                            reloadNavigation(prnt.attr('nm'), prnt.attr('stts'), prnt.attr('lvl'), null);
                        else {
                            if (prnt.attr('yuu') !== '' && prnt.attr('yuu') !== null) {
                                yuu = $('.' + prnt.attr('yuu'));
                                reloadNavigation(yuu.attr('nm'), yuu.attr('stts'), yuu.attr('lvl'), null);
                            } else
                                reloadNavigation(null, $default_status, $min_level, null);
                        }
                        
                        if (prnt.attr('stts') !== $('.u-ia').attr('stts')) {
                            cancelSelect();
                            $('.custom-menu').hide();
                        }
                    }
                }
                
                function toggleMenu(selectMode) {
                    $('.custom-menu-nav-fldr-nds').find('li').each(
                        function () {
                            $(this).hasClass('slct-mbl-optns') ? (selectMode ? $(this).show() : $(this).hide()) : (selectMode ? $(this).hide() : $(this).show());
                        }
                    );
                }
                
                function clickAndContextEventClient(e, prnt, selectMode) {
                    $('.custom-menu-nav-fldr-nds').find('li').each(
                        function () {

                            fdmntl = (!$(this).hasClass('fl-dwnld') && !$(this).hasClass('fl-dwnld-zpd') && !$(this).hasClass('add-fldr') && !$(this).hasClass('dir-rfrs')) && (!selectMode || !$(this).hasClass('slct-mbl-optns'));

                            if ($(e.target).hasClass('nvgtn-fldr-ctnr') || $(e.target).parent().hasClass('nvgtn-fldr-ctnr'))
                                !$(this).hasClass('add-file') && fdmntl ? $(this).hide() : '';

                            if ((isItem = $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('file-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn')) || $(e.target).hasClass('inst-ctnt-pn-fl') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('inst-ctnt-pn-dr') || $(e.target).hasClass('inst-ctnt-pn-dr-pn'))
                               (prnt.attr('lvl') * 1 <= $min_level || !$(this).hasClass('add-file')) && fdmntl && !isItem ? $(this).hide() : '';
                                   
                            !isItem && $(this).hasClass('fl-dwnld-zpd') ? $(this).hide() : '';
                            
                        }
                    );
                }
                
                function actionsWithSelected (e, prnt) {
                    if ($('#clp-brd').text() !== '' && $('#clp-brd').text() !== null)
                        $('#clk-drg-slct') && $('#clk-drg-slct').text() !== null && $('#clk-drg-slct').text() !== '' && (($(e.target).hasClass('fldr-in-ctnt-pn') && !itemIsSelected($(e.target).attr('dcl'))) || ($(e.target).parent().hasClass('fldr-in-ctnt-pn') && !itemIsSelected($(e.target).parent().attr('dcl'))) || ($(e.target).hasClass('nvgtn-fldr-ctnr') && !itemIsSelected($(e.target).attr('cld'))) || (($(e.target).hasClass('nvgtn-fldr-ctnr-glyph-lft') || $(e.target).hasClass('nvgtn-fldr-ctnr-nm-txt')) && !itemIsSelected($(e.target).parent().attr('cld')))) ? $('.fl-dwnld-clk').show() : $('.fl-dwnld-clk').hide();

                    (noclip = $('#clp-brd').text() === '' || $('#clp-brd').text() === null) || $('#clp-brd-cmd').text() === '' || $('#clp-brd-cmd').text() === null || prnt.attr('lvl') * 1 <= $min_level || itemIsSelected(prnt.attr('cld')) ? $('.pst-dcmt, .fl-dwnld-zip').hide() : $('.pst-dcmt, .fl-dwnld-zip').show();
                        
                    moreActionsWithSelected(e, noclip, prnt.attr('stts'));
                }
                
                function moreActionsWithSelected(event, noclip, status) {
                    $('.custom-menu-slct-optns').find('li').each(
                        function () {
                            if ($(this).hasClass('slct-all-fls') || $(this).hasClass('slct-all-drs') || $(this).hasClass('slct-all-ffs') || $(this).hasClass('unslct-all-drs') || $(this).hasClass('unslct-all-fls') || $(this).hasClass('unslct-all-ffs') || $(this).hasClass('slct-cntn') || $(this).hasClass('ccl-slct'))
                                $(event.target).hasClass('nvgtn-fldr-ctnr') || $(event.target).parent().hasClass('nvgtn-fldr-ctnr') ? $(this).hide() : $(this).show();
                            else {
                                if (!$(this).hasClass('fl-dwnld-clk') && !$(this).hasClass('pst-dcmt') && !$(this).hasClass('.fl-dwnld-zip'))
                                    ($(event.target).hasClass('nvgtn-fldr-ctnr') || $(event.target).parent().hasClass('nvgtn-fldr-ctnr')) || (!$(this).hasClass('slct-cntn') && !$(this).hasClass('ccl-slct') && noclip) ? $(this).hide() : $(this).show();

                                if (status === '$default_status')
                                    $(this).hasClass('dcmt-dlt-clk') || $(this).hasClass('doc-rstr-clk') || $(this).hasClass('doc-rstr2-clk-doc') || $(this).hasClass('doc-rstr2-clk-arc') || $(this).hasClass('dcmt-drp-clk') ? $(this).hide() : '';
                                else
                                if (status === '$status_archive')
                                    !$(this).hasClass('dcmt-dlt-clk') && !$(this).hasClass('doc-rstr-clk') && !$(this).hasClass('slct-cntn') && !$(this).hasClass('ccl-slct') ? $(this).hide() : '';
                                else
                                    !$(this).hasClass('doc-rstr2-clk-doc') && !$(this).hasClass('doc-rstr2-clk-arc') && !$(this).hasClass('dcmt-drp-clk') && !$(this).hasClass('slct-cntn') && !$(this).hasClass('ccl-slct') ? $(this).hide() : '';
                            }
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
                
                function highlightDocument(e, prnt) {
                    if (e.which !== 3) {
                        $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).parent().hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn') ||
                        $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('inst-ctnt-pn-dr-pn') ? $('.is-hgltd').removeClass('is-hgltd') : '';
                        
                        highlighted = $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn') ? ($(e.target)) :
                                        ($(e.target).parent().hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn') ? ($(e.target).parent()) :
                                        ($(e.target).hasClass('inst-ctnt-pn-dr-pn') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('inst-ctnt-pn-dr') || $(e.target).hasClass('inst-ctnt-pn-fl') ? prnt : ''));
                        
                        if (highlighted !== '' && highlighted !== null) {
                            isFile = $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('file-in-ctnt-pn');
                            
                            (isPrnt = highlighted.hasClass('u-ia')) ? '' : highlighted.addClass('is-hgltd');
                            
                            documentProperties(prnt.attr('nm') + (isPrnt || !isFile ? '' : ('/' + highlighted.attr('nm'))), prnt.attr('stts'), prnt.attr('lvl') * 1 + (isPrnt ? 0 : 1));
                        }
                    }
                }
                
                function viewWhereRights(prnt) {
                    if (prnt.attr('prfrgt') === 'adm') {
                        if ('$profile' !== '$admin') {
                            $('.custom-sub-menu').hide();
                            $('.fl-dwnld, .dir-rfrs').show();
                        }
                    } else
                    if ('$profile' !== '$admin' && prnt.attr('prfrgt') !== '$alterDoc')
                        if (prnt.attr('prfrgt') === '$readDoc')
                            $('[rgt=wrt], [rgt=alt]').hide();
                        else
                        if (prnt.attr('prfrgt') === '$writeDoc')
                            $('[rgt=alt]').hide();
                        else
                            $('.custom-sub-menu').hide();
                }
                
                function clickAndContextEvent(e) {

                    prnt = clickAndContextEventParent(e);

                    highlightDocument(e, prnt);

                    $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr', prnt.attr('id'));

                    $('#clp-brd-pst').text(null);
                    
                    inSelectMode = $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('md') === 'slctn';

                    if ($(e.target).attr('prnt') || (inSelectMode && ($(e.target).hasClass('nvgtn-fldr-ctnr-glyph-lft') || $(e.target).hasClass('nvgtn-fldr-ctnr-nm-txt'))) || $(e.target).hasClass('inst-ctnt-pn-dr-pn') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).hasClass('file-in-ctnt-pn')) {

                        if (inSelectMode) {
                            
                            e.which === 3 ? '' : selectTheDocument($(e.target));
                            
                            $('#clk-drg-slct').text($(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn') || $(e.target).hasClass('nvgtn-fldr-ctnr-glyph-lft') || $(e.target).hasClass('nvgtn-fldr-ctnr-nm-txt')? prnt.attr('id') : '');

                            $('#clp-brd-pst').text(prnt.attr('cld'));
                            
                            clickAndContextEventNavigation(e, prnt);

                            toggleMenu(true);
                            
                            clickAndContextEventClient(e, prnt, true);

                        } else {

                            toggleMenu(false);

                            if (prnt.hasClass('nvgtn-fldr-ctnr')) {
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl', '');
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').html('Directory Options');
                                $('.custom-menu-nav-fldr-nds .fl-dwnld').html('Explore');
                                $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc, .custom-menu-nav-fldr-nds .doc-vrsn, .custom-menu-nav-fldr-nds .shr-updt, .custom-menu-nav-fldr-nds .psh-dcmt').hide();
                            } else {
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl', $(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).attr('id') : $(e.target).attr('prnt'));
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').html('File Options');
                                $('.custom-menu-nav-fldr-nds .fl-dwnld').html('Open / Download');
                                $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc, .custom-menu-nav-fldr-nds .doc-vrsn, .custom-menu-nav-fldr-nds .shr-updt, .custom-menu-nav-fldr-nds .psh-dcmt').show();
                            }

                            if (prnt.attr('stts') === '$default_status') {
                                $('.custom-menu-nav-fldr-nds .cp-dcmnt, .custom-menu-nav-fldr-nds .mv-dcmnt, .custom-menu-nav-fldr-nds .fl-dplct, .custom-menu-nav-fldr-nds .dcmt-rnm, .custom-menu-nav-fldr-nds .dcmt-shr, .custom-menu-nav-fldr-nds .psh-dcmt, .custom-menu-nav-fldr-nds .snd-dcmt, .custom-menu-nav-fldr-nds .doc-arcv').show();
                                $('.custom-menu-nav-fldr-nds .dcmt-dlt, .custom-menu-nav-fldr-nds .doc-rstr, .custom-menu-nav-fldr-nds .doc-rstr2, .custom-menu-nav-fldr-nds .dcmt-drp').hide();
                            } else {
                                $('.custom-menu-nav-fldr-nds .cp-dcmnt, .custom-menu-nav-fldr-nds .mv-dcmnt, .custom-menu-nav-fldr-nds .fl-dplct, .custom-menu-nav-fldr-nds .dcmt-rnm, .custom-menu-nav-fldr-nds .dcmt-shr, .custom-menu-nav-fldr-nds .psh-dcmt, .custom-menu-nav-fldr-nds .snd-dcmt, .custom-menu-nav-fldr-nds .doc-arcv').hide();
                                
                                if (prnt.attr('stts') === '$status_archive') {
                                    $('.custom-menu-nav-fldr-nds .doc-rstr2, .custom-menu-nav-fldr-nds .dcmt-drp').hide();
                                    $('.custom-menu-nav-fldr-nds .dcmt-dlt, .custom-menu-nav-fldr-nds .doc-rstr').show();
                                } else {
                                    $('.custom-menu-nav-fldr-nds .doc-rstr, .custom-menu-nav-fldr-nds .dcmt-dlt').hide();
                                    $('.custom-menu-nav-fldr-nds .doc-rstr2, .custom-menu-nav-fldr-nds .dcmt-drp').show();
                                }
                            }

                            if ($(e.target).hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('file-in-ctnt-pn')) {
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl', $(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).attr('id') : $(e.target).attr('prnt'));
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').html('File Options');
                                $('.custom-menu-nav-fldr-nds .fl-dwnld').html('Open / Download');
                                
                                if (prnt.attr('stts') === '$default_status') {
                                    $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc, .custom-menu-nav-fldr-nds .shr-updt, .custom-menu-nav-fldr-nds .psh-dcmt, .custom-menu-nav-fldr-nds .snd-dcmt').show();
                                    (opn_4_updt = $(e.target).hasClass('opn-4-updt') || $(e.target).parent().hasClass('opn-4-updt')) || ($(e.target).hasClass('lckd-by-usr') || $(e.target).parent().hasClass('lckd-by-usr')) ? $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .doc-arcv, .custom-menu-nav-fldr-nds .doc-dlt, .custom-menu-nav-fldr-nds .psh-dcmt').hide() : $('.custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc').hide();
                                    !$(e.target).hasClass('lckd-by-usr') && !$(e.target).parent().hasClass('lckd-by-usr') ? $('.custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc').hide() : '';
                                    ($(e.target).hasClass('has-vrsns') || $(e.target).parent().hasClass('has-vrsns')) && (!opn_4_updt || ($(e.target).hasClass('lckd-by-usr') || $(e.target).parent().hasClass('lckd-by-usr'))) ? $('.custom-menu-nav-fldr-nds .doc-vrsn').show() : $('.custom-menu-nav-fldr-nds .doc-vrsn').hide();
                                }
                            } else {
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fl', '');
                                $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').html('Directory Options');
                                $('.custom-menu-nav-fldr-nds .fl-dwnld').html('Explore');

                                $(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn') ? $('.custom-menu-nav-fldr-nds .snd-dcmt').show() : $('.custom-menu-nav-fldr-nds .snd-dcmt').hide();

                                $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .unlk-file, .custom-menu-nav-fldr-nds .doc-rplc, .custom-menu-nav-fldr-nds .doc-vrsn, .custom-menu-nav-fldr-nds .doc-vrsn, .custom-menu-nav-fldr-nds .shr-updt, .custom-menu-nav-fldr-nds .psh-dcmt').hide();
                            }
                            
                            if ((is_self = $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn')) || (is_prnt = $(e.target).parent().hasClass('file-in-ctnt-pn') || $(e.target).parent().hasClass('fldr-in-ctnt-pn'))) {
                                lmnt = is_self ? $(e.target) : $(e.target).parent();
                                
                                if (!lmnt.hasClass('can-updt'))
                                    $('.custom-menu-nav-fldr-nds .opn-updt, .custom-menu-nav-fldr-nds .doc-rplc, .custom-menu-vrsn-fls .vrsn-rvt').hide();
                                
                                if (!lmnt.hasClass('can-mv') || !lmnt.hasClass('can-dlt'))
                                    $('.custom-menu-nav-fldr-nds .doc-arcv, .custom-menu-nav-fldr-nds .dcmt-dlt, .custom-menu-nav-fldr-nds .dcmt-drp').hide();
                                
                                if (!lmnt.hasClass('can-mv'))
                                    $('.custom-menu-nav-fldr-nds .mv-dcmnt').hide();
                            }
                            
                            if ($(e.target).hasClass('add-fldr'))
                                $('.custom-menu-nav-fldr-nds .add-fldr').show();
                            else
                                $('.custom-menu-nav-fldr-nds .add-fldr').hide();

                            if ($(e.target).hasClass('dropable'))
                                $('.custom-menu-nav-fldr-nds .add-file').show();
                            else
                                $('.custom-menu-nav-fldr-nds .add-file').hide();

                            clickAndContextEventNavigation(e, prnt);
                            
                            clickAndContextEventClient(e, prnt, false);
                        }

                        actionsWithSelected(e, prnt);
                        
                        viewWhereRights(prnt);
                    }
                }
                
                function clickAndContextEventDuringSelect(event) {
                    if ($(event.target).attr('cstm-mn') && $(event.target).attr('cstm-mn') !== '' && $(event.target).attr('cstm-mn') !== null && $('.custom-sub-menu-title') && $('.custom-sub-menu-title').attr('md') && $('.custom-sub-menu-title').attr('md') === 'slctn')
                        if ($(event.target).parent().hasClass('nvgtn-fldr-ctnr') || $(event.target).parent().hasClass('inst-ctnt-pn-fl') || $(event.target).hasClass('file-in-ctnt-pn') || $(event.target).parent().hasClass('file-in-ctnt-pn') || $(event.target).parent().hasClass('inst-ctnt-pn-dr') || $(event.target).hasClass('fldr-in-ctnt-pn') || $(event.target).parent().hasClass('fldr-in-ctnt-pn') || $(event.target).hasClass('inst-ctnt-pn-fl-pn') || $(event.target).hasClass('inst-ctnt-pn-dr-pn')) {
                            $(event.target).attr('cstm-mn', '.custom-menu-slct-optns');
                            clickAndContextEvent(event);
                            customMenu(event, true);
                            $(event.target).attr('cstm-mn', '.custom-menu-nav-fldr-nds');
                        }
                }
                
                function documentPrivelegesModal() {
                    if ('$profile' === '$admin' || $('.u-ia').attr('prfrgt') === '$alterDoc') {
                        elmnt = $('.u-ia').attr('yuu') == '' || $('.u-ia').attr('yuu') == null ? $('.u-ia') : $('[jih=' + $('.u-ia').attr('yuu') + ']');
                        yiiModal('Document Privileges', 'sections/privileges-modal', {'Sections[id]': '', 'filename': elmnt.attr('nm'), 'status': elmnt.attr('stts'), 'level': elmnt.attr('lvl') * 1 + 1, 'Documents[id]': $('.u-ia').attr('cld') == '' || $('.u-ia').attr('cld') == null ? $('[yuu=' + $('.u-ia').attr('jih') + ']').attr('cld') : $('.u-ia').attr('cld')}, $('.inst-ctnt').width() * 0.75, $('.institution-default-index').height());
                    }
                }
                
                function loadSection(sctn) {
                    $.post('sections/details?section', {'Sections[id]': sctn},
                        function (result) {
                            $('#fm-bdy-pn').html(result);
                        }
                    );
                }
                
                function toggleBlockSection(sctn, actv, upToo) {
                    $('.rmv-sctn').children().removeClass(rmv = actv ? 'glyphicon-ban-circle' : 'glyphicon-ok').addClass(add = actv ? 'glyphicon-ok' : 'glyphicon-ban-circle');
                    
                    if (upToo && sctn !== '' && sctn !== null) {
                        $('[tr-sctn=' + sctn + '] .sctns-lst-td').removeClass(actv ? 'sctns-lst-td-crs' : 'sctns-lst-td-tck').addClass(actv ? 'sctns-lst-td-tck' : 'sctns-lst-td-crs');
                        $('[tr-sctn=' + sctn + '] .sctns-lst-td .sct-actv').children().removeClass(rmv).addClass(add);
                    }
                }
                
                function newSection() {
                    loadSection(null);
                    toggleBlockSection(null, true, false);
                }
                
                function reloadSections(sctn, dcmnt, updt) {
                    $.post('sections/all-sections?sections=&document=', {'Sections[active]': '', 'Documents[id]': dcmnt},
                        function (result) {
                            clickSection($('#sctns-rfrsh').html(result).find(sctn === '' || sctn === null ? '.sct-hr' : '[tr-sctn=' + sctn + '] .sctns-lst-td' ).parent().attr('tr-sctn'), false, updt);
                        }
                    );
                }
                
                function loadSectionUsers(sctn) {
                    $.post('sections/users?section=', {'Sections[id]': sctn},
                        function (result) {
                            $('#sctn-usrs-lst').html(result);
                        }
                    );
                }
                
                function saveSection() {
                    post = $('#form-sections').serializeArray();

                    post.push({name: 'sbmt', value: ''});
                    
                    sctn = $('#sections-id').val();
                    
                    $.post('sections/details?section=', post,
                        function (result) {
                            $('#fm-bdy-pn').html(result);
                            reloadSections($('#sections-id').val(), $('.doc-hr').parent().attr('tr-dcmnt'), sctn === '' || sctn === null);
                        }
                    );
                }
                
                function expireSection(sctn, actv) {
                    $.post('sections/expire-section', {'Sections[id]': sctn, 'Sections[active]': actv},
                        function (actvtd) {
                            toggleBlockSection(sctn, actvtd, true);
                        }
                    );
                }
                
                function sectionRemove() {
                    if ($('#sections-id') && (sctn = $('#sections-id').val()) !== '' && $('#sections-id').val() !== null)
                        expireSection(sctn, $('.rmv-sctn .glyphicon-ok').length ? '$section_not_active' : '$section_active');
                }
                
                function sectionDrop() {
                    if ($('#sections-id') && (sctn = $('#sections-id').val()) !== '' && sctn !== null)
                        $.post('sections/drop-section', {'Sections[id]': sctn},
                            function (drpd) {
                                drpd ? reloadSections('', $('.doc-hr').parent().attr('tr-dcmnt'), true) : '';
                            }
                        );
                }
                
                function folderToLoadFor(flnm, lvl, doc, drctn) {
                    doc = null;
                    
                    if (drctn === 'up')
                        if (lvl * 1 - 1 > '$min_client_doc_level') {
                            lvl = lvl * 1 - 2;
                            flnm = flnm.substr(0, (i = flnm.lastIndexOf('/')) < 0 ? flnm.length : i);
                            flnm = flnm.substr(0, (i = flnm.lastIndexOf('/')) < 0 ? flnm.length : i);
                        } else {
                            lvl = '$min_client_doc_level';
                            flnm = '';
                        }
                    
                    return [flnm, lvl, doc];
                }

                function loadContentFolder(flnm, stts, lvl, doc, drctn) {
                    values = folderToLoadFor(flnm, lvl, doc, drctn);
                    
                    $.post('sections/load-content-folder?documents=', {'filename': values[0], 'status': stts, 'level': values[1], 'Documents[id]': values[2]},
                        function (result) {
                            html = $('#dcmnts-rfrsh').html();
                            
                            if ($('#dcmnts-rfrsh').html(result).find('.doc-hr').length) {
                                reloadSections($('.sct-hr').parent().attr('tr-sctn'), doc = $('#dcmnts-rfrsh .doc-hr').parent().attr('tr-dcmnt'), false);
                                docDescription(doc);
                            } else {
                                $('#dcmnts-rfrsh').html(html);
                                customErrorSwal('Well,', 'Document exploration reached the end', 2000, 'info');
                            }
                        }
                    );
                }
                
                function docExplorable() {
                    $('.doc-hr').parent().attr('tr-lvl') * 1 > '$min_client_doc_level' ? $('.dcmnt-nvgtn-up').show() : $('.dcmnt-nvgtn-up').hide();
                }

                function documentPrivilegeExplore(drctn) {
                    doc = $('.doc-hr').parent();
                    loadContentFolder(doc.attr('tr-fldr'), doc.attr('tr-stts'), doc.attr('tr-lvl'), doc.attr('tr-dcmnt'), drctn);
                }

                function highlightDocList(doc, hghlght) {
                    docExplorable();

                    if (hghlght) {
                        $('.doc-hr').removeClass('doc-hr');
                        $('[tr-dcmnt=' + doc + '] .dcmts-lst-td').addClass('doc-hr');
                        docDescription(doc);
                    }
                }
                
                function clickDocList(doc) {
                    (hghlght = !$('[tr-dcmnt=' + doc + '] .dcmts-lst-td').hasClass('doc-hr')) ? reloadSections($('.sct-hr').parent().attr('tr-sctn'), doc, false) : '';
                    highlightDocList(doc, hghlght);
                }
                
                function highlightSection(sctn) {
                    $('.sct-hr').removeClass('sct-hr').removeClass('has-cstm-mn').attr('cstm-mn', null).find('.sct-nm').removeClass('has-cstm-mn').attr('cstm-mn', null);
                    $('[tr-sctn=' + sctn + '] .sctns-lst-td').addClass('sct-hr').addClass('has-cstm-mn').attr('cstm-mn', '.custom-menu-dcmnt-rgts').find('.sct-nm').addClass('has-cstm-mn').attr('cstm-mn', '.custom-menu-dcmnt-rgts');
                }

                function sectionUpdates(sctn, updt) {
                    updt ? loadSection(sctn) : '';
                    updt ? loadSectionUsers(sctn) : '';
                }

                function clickSection(sctn, upToo, loadUsers) {
                
                    notHglght = !$('[tr-sctn=' + sctn + '] .sctns-lst-td').hasClass('sct-hr');
                    
                    notEql = sctn !== $('#sections-id').val();

                    if (loadUsers || notHglght || notEql) {
                        sectionUpdates(sctn, loadUsers || (notEql && !upToo));
                        toggleBlockSection(sctn, $('[tr-sctn=' + sctn + '] .sctns-lst-td').hasClass('sctns-lst-td-tck'), false);
                        notHglght ? highlightSection(sctn) : '';
                    } else
                        upToo ? expireSection(sctn, $('[tr-sctn=' + sctn + '] .sctns-lst-td').hasClass('sctns-lst-td-tck') ? '$section_not_active' : '$section_active') : '';
                }
                
                function selectSectionUser(user) {
                    $('.custom-menu-sctn-rgts').attr('usr', user);
                    
                    $('.usr-hr').removeClass('usr-hr');
                    
                    $('[tr-usr=' + user + '] .usrs-lst-td').addClass('usr-hr');
                }
                
                function sectionDocumentRight(rgt) {
                    if (
                    $('.doc-hr').length && $('.doc-hr').parent().attr('tr-dcmnt') && (dcmnt = $('.doc-hr').parent().attr('tr-dcmnt')) !== '' && dcmnt !== null &&
                    $('.sct-hr').length && $('.sct-hr').parent().attr('tr-sctn') && (sctn = $('.sct-hr').parent().attr('tr-sctn')) !== '' && sctn !== null
                    )
                        $.post('sections/section-document-right', {'DocumentsPermissions[document]': dcmnt, 'DocumentsPermissions[section]': sctn, 'DocumentsPermissions[permission]': rgt},
                            function (right) {
                                $('.sct-hr').removeClass('$readDoc').removeClass('$writeDoc').removeClass('$alterDoc').removeClass('$denyDoc').addClass(right);
                                documentsUserHasRightTo();
                            }
                        );
                }
                
                function userSectionRight(rgt) {
                    if ($('.sct-hr').length && $('.sct-hr').parent().attr('tr-sctn') && (sctn = $('.sct-hr').parent().attr('tr-sctn')) !== '' && sctn !== null)
                        $.post('sections/user-section-right', {'Sections[id]': sctn, 'user': $('.custom-menu-sctn-rgts').attr('usr'), 'right': rgt},
                            function (right) {
                                $('.usr-hr').removeClass('$otherUser').removeClass('$adminUser').removeClass('$subAdminUser').removeClass('$removedUser').addClass(right);
                                documentsUserHasRightTo();
                            }
                        );
                }
                
                function docDescription(doc) {
                    $.post('sections/doc-description', {'Documents[id]': doc},
                        function (dscrptn) {
                            $('.sctn-dscrptn-pn-scrl').html(dscrptn);
                        }
                    )
                }
                
                function updateDocDescription() {
                    if ($('.u-ia').attr('cld') && $('.u-ia').attr('cld') !== '' && $('.u-ia').attr('cld') !== null)
                        yiiModal($('.u-ia').attr('cld') === $('.file-name-field').attr('cdl') ? $('.u-ia .nvgtn-fldr-ctnr-nm-txt').text() : $('[dcl=' + $('.file-name-field').attr('cdl') + ']').find('.file-in-ctnt-pn-ttl').text(), 'sections/update-doc-description', {'Documents[id]': $('.file-name-field').attr('cdl')}, $('.inst-ctnt').width() * 0.5, $('.institution-default-index').height() * 0.35);
                }
                
                function loadVersions() {
                    yiiModal($('[dcl=' + $('.file-name-field').attr('cdl') + ']').find('.file-in-ctnt-pn-ttl').text() + ' <small>Version History</small>', 'sections/document-versions', {'id': $('.file-name-field').attr('cdl'), 'status': $('.file-name-field').attr('stts')}, $('.inst-ctnt').width(), $('.institution-default-index').height());
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
                    yiiModal('Slide Images', 'sections/slide-images', {}, $('.inst-ctnt').width() * 0.75, $('.institution-default-index').height());
                }
                
                function graphs() {
                    yiiModal('Graphs', 'sections/graphs', {}, $('.inst-ctnt').width() * 0.75, $('.institution-default-index').height());
                }
                
                function refreshSlideImages(actv) {
                    $.post('sections/slide-images-panes', {'actv': actv},
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
                    $.post('sections/update-slide-image', {'SlideImages[id]': id},
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
                        $.post('sections/active-slide-image', {'SlideImages[id]': $('#slideimages-id').val(), 'SlideImages[active]': $('#sld-img-chk').hasClass('btn-success') ? '0' : '1'},
                            function (active) {
                                ifRefreshImages($('#slideimages-active').val(), true);
                                $('#slideimages-active').val(active);
                                imageActiveButtonChecked(active);
                            }
                        )
                }
                
                function deleteSlideImage() {
                    if ($('#slideimages-id').val() * 1 > 0)
                        $.post('sections/delete-slide-image', {'SlideImages[id]': $('#slideimages-id').val()},
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
                            url: 'sections/update-slide-image',
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
                
                function searchDocuments() {
                    if ((val = $('#srch-fld').val()) === null || val === '') {
                        $('#srch-bdy-pn-prgrs-pn').html('Waiting...');
                        $('#srch-bdy-pn-prgrs').css('display', 'none');
                        $('#srch-bdy-pn').html(null).show();
                    } else {
                        $('#srch-bdy-pn').hide();
                        
                        $('#srch-bdy-pn-prgrs-pn').html('<i>Searching for <b>' + $('#srch-fld').val() + '</b>...</i>');

                        $('#srch-bdy-pn-prgrs').css('display', 'table');

                        $.post('sections/search-documents', {'name': $('#srch-fld').val(), 'id': $('.u-ia').attr('cld')},
                            function (docs) {
                                $('#srch-fld').val(val);
                                if ($('#srch-bdy-pn').html(docs).find('.doc-srch-tr').length) {
                                    $('#srch-bdy-pn-prgrs').css('display', 'none');
                                    $('#srch-bdy-pn').show();
                                } else
                                    $('#srch-bdy-pn-prgrs-pn').html('<h4><i>~~ No Results Found ~~</i></h4>');
                            }
                        );
                    }
                }
                
                function versionWorkingOn(elmnt) {
                    $('.vrsn-dtl').attr('doc', elmnt.attr('doc')).attr('stts', $('.u-ia').attr('stts')).attr('vrsn', elmnt.attr('vrsn-hd')).attr('dt', elmnt.attr('dt')).html('<b>Author</b>: ' + elmnt.attr('aut') + '<br/><b>Type</b>: ' + elmnt.attr('typ') + '<br/><b>Size</b>: ' + elmnt.attr('sz'));
                }
                
                function revertToVersion () {
                    $.post('sections/revert-from-history', {'id': $('.vrsn-dtl').attr('doc'), 'version': $('.vrsn-dtl').attr('vrsn'), 'status': $('.vrsn-dtl').attr('stts')},
                        function (versions) {
                            $('#yii-modal-cnt').html(versions);
                            dirRefresh();
                        }
                    );
                }
                
                function downloadVersion() {
                    $.post('sections/download-document-version', {'id': $('.vrsn-dtl').attr('vrsn'), 'status': $('.vrsn-dtl').attr('stts')},
                        function (url) {
                            if (url === null || url === '')
                                customErrorSwal('Oops!', 'This file seems to have been removed', '2000', 'info');
                            else {
                                popWindow(url, $('[dcl=' + $('.vrsn-dtl').attr('doc') + ']').find('.file-in-ctnt-pn-ttl').text());
                                $.post('sections/drop-exported-file', {'link': url}, function () {});
                            }
                        }
                    );
                }
                
                function deleteVersion() {
                    swal(
                            {
                                title: 'Careful...',
                                text: '<h3>This action will also delete all prior versions</h3>',
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
                                    $.post('sections/drop-document-versions', {'id': $('.vrsn-dtl').attr('doc'), 'till': $('.vrsn-dtl').attr('dt')},
                                            function (versions) {
                                                $('#yii-modal-cnt').html(versions);
                                                dirRefresh();
                                                swal.close();
                                            }
                                    ):
                                    swal.close();
                            }
                    );
                }
                
        "
        , View::POS_HEAD
);
?>

<?php
$this->registerJs(
        "
            /* order file elements by their name */
                $('.inst-ctnt-pn').bind('contentchanged',
                    function () {
                        orderFilesDispled($(this).find('.inst-ctnt-pn-dr-pn'), '.fldr-in-ctnt-pn', '.fldr-in-ctnt-pn-ttl');
                        orderFilesDispled($(this).find('.inst-ctnt-pn-fl-pn'), '.file-in-ctnt-pn', '.file-in-ctnt-pn-ttl');
                        highlightTheSelected();
                    }
                );
            /* order file elements by their name */

            /* populate the directory content and properties pane */
                loadDirectory($('.u-ia').attr('nm'), $('.u-ia').attr('stts'), $('.u-ia').attr('lvl') * 1 + 1, null);
            /* populate the directory content and properties pane */
            
            /* browser should not take any action when files are dragged over or dropped on it */
                $(document).on('dragenter',
                        function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                        }
                );

                $(document).on('dragover',
                        function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                        }
                );

                $(document).on('drop',
                        function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                        }
                );
            /* browser should not take any action when files are dragged over or dropped on it */
            
            /* show where to or not to drop files */
                $(document).bind('dragenter dragover',
                        function (e) {
                            if ($(e.target).hasClass('dropable'))
                                if ($(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn-icn') || $(e.target).hasClass('fldr-in-ctnt-pn-ttl'))
                                    $(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).css('border', '2px dotted #0b85a1') : $(e.target).parent().css('border', '2px dotted #0b85a1');
                                else
                                if ($(e.target).hasClass('inst-ctnt-pn-fl') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('file-in-ctnt-pn-icn') || $(e.target).hasClass('file-in-ctnt-pn-ttl'))
                                    $('.inst-ctnt-pn-fl-pn').css('border', '5px dotted #0b85a1');
                                else
                                    $(e.target).parent().css('border', '2px dotted #0b85a1').css('border-radius', '15px');
                        }
                );
        
                $(document).bind('dragleave drop',
                        function (e) {
                            if ($(e.target).hasClass('dropable'))
                                if ($(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn-icn') || $(e.target).hasClass('fldr-in-ctnt-pn-ttl'))
                                    $(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).css('border', 'none') : $(e.target).parent().css('border', 'none');
                                else
                                if ($(e.target).hasClass('inst-ctnt-pn-fl') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('file-in-ctnt-pn-icn') || $(e.target).hasClass('file-in-ctnt-pn-ttl'))
                                    $('.inst-ctnt-pn-fl-pn').css('border', 'none');
                                else
                                    $(e.target).parent().css('border', 'none', 'border-radius', '6px');
                        }
                );
            /* show where to or not to drop files */

            /* drop files onto folders */
                $(document).bind('drop',
                        function (e) {
                            if ($(e.target).hasClass('dropable')) {
                                if ($(e.target).hasClass('fldr-in-ctnt-pn') || $(e.target).hasClass('fldr-in-ctnt-pn-icn') || $(e.target).hasClass('fldr-in-ctnt-pn-ttl'))
                                    prnt = $('[cld=' + ($(e.target).hasClass('fldr-in-ctnt-pn') ? $(e.target).attr('dcl') : $(e.target).parent()).attr('dcl') + ']');
                                else
                                if ($(e.target).hasClass('inst-ctnt-pn-fl') || $(e.target).hasClass('inst-ctnt-pn-fl-pn') || $(e.target).hasClass('file-in-ctnt-pn') || $(e.target).hasClass('file-in-ctnt-pn-icn') || $(e.target).hasClass('file-in-ctnt-pn-ttl'))
                                    prnt = $('.u-ia');
                                else
                                    prnt = $(e.target).parent();
                                    
                                prnt.find('.nvgtn-fldr-ctnr-glyph-rgt').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                                    
                                handleNewFileUpload(null, prnt.attr('cld'), e.originalEvent.dataTransfer.files, prnt.attr('lvl'), prnt.attr('stts'), prnt.attr('nm'), prnt.find('.nvgtn-fldr-ctnr-glyph-rgt'));
                            } else
                                customErrorSwal('Declined', '<h4>Objects dropped here do not get acted upon</h4>', 2000, 'error');
                        }
                );
            /* drop files onto folders */
            
            /* upload files from the file input element */
                $('#documents-filename').change(
                    function () {
                        prnt = $('#' + $('.custom-menu-nav-fldr-nds .custom-sub-menu-title').attr('fldr'));
                                    
                        prnt.find('.nvgtn-fldr-ctnr-glyph-rgt').removeClass('glyphicon-minus').addClass('glyphicon-plus');
                        
                        if (!$(this).attr('dcmnt') || $(this).attr('dcmnt') === null || $(this).attr('dcmnt') === '')
                            handleNewFileUpload(null, prnt.attr('cld'), $(this).prop('files'), prnt.attr('lvl'), prnt.attr('stts'), prnt.attr('nm'), prnt.find('.nvgtn-fldr-ctnr-glyph-rgt'));
                        else
                            handleFileUpdate($(this).attr('dcmnt'), $(this).prop('files'), (notFromPermsPane = $('[dcl=' + $(this).attr('dcmnt') + ']').length) ? prnt.attr('stts') : $(this).attr('dok-stts'), notFromPermsPane ? prnt.attr('nm') : $(this).attr('dok-fldr'), notFromPermsPane ? prnt.find('.nvgtn-fldr-ctnr-glyph-rgt') : $('#this-not-exists-and-will-never-be-found'));
                            
                        $(this).attr('dok-fldr', null);
                        $(this).attr('dok-stts', null);
                    }
                );
            /* upload files from the file input element */
            
            /* copy files to or remove from clipboard automatically as they are selected or deselected */
                $('.inst-ctnt-pn').bind('selecteditems',
                    function () {
                        clipBoard();
                    }
                );
            /* copy files to or remove from clipboard automatically as they are selected or deselected */
            
            /* select folder when clicked */
                $('.institution-default-index').unbind('click').click(
                    function (event) {
                        clickAndContextEvent(event);
                    }
                );
            /* select folder when clicked */
            
            /* control length of filename */
                $(document).on('keydown',
                        function (event) {
                            if ($(event.target).hasClass('file-name-field')) {
                                maxLengthContentEditable(event);
                                
                                setTimeout(
                                    function () { 
                                        notExceedMaxLengthContentEditable(event);
                                        event.keyCode === 13 ? changeNameOfFile($(event.target)) : '';
                                    }
                                , 250);
                            }
                        }
                );
                
                $(document).on('paste',
                        function (event) {
                            if ($(event.target).hasClass('file-name-field')) {
                                event.preventDefault();
                            }
                        }
                );
            /* control length of filename */
            
            /* put the right and left arrows middle for the carousel */
                $('.carousel-control').css('padding-top', ($('.carousel-control').height() - 20) / 2 + 'px'); //20 is the font size for $('.carousel-control').text()
            /* put the right and left arrows middle for the carousel */
            
            /* align floating menu div appropriately */
                $('#header-float-doc-div').css('top', ($('.institution-default-index').height() - $('#header-float-doc-div').height()) / 2 + 'px').css('right', 0);
                $('#sidebar-float-doc-div').css('top', ($('.institution-default-index').height() - $('#sidebar-float-doc-div').height()) / 2 + 'px').css('right', $('#sidebar-float-doc-div').width() + 'px');
                $('#slider-float-doc-div').css('right', $('#header-float-doc-div').width() * -1 + 'px');
            /* align floating menu div appropriately */
            
            /* on mouse leave floating menu, hide it */
                $('#header-float-doc-div').on('mouseleave',
                    function () {
                        $('#sidebar-float-doc-div').click();
                    }
                );
            /* on mouse leave floating menu, hide it */
            
            /* search btn to search files */
                $('#srch-btn').attr('onclick', 'searchDocuments()');
            /* search btn to search files */
            
            /* on press enter in search field */
                $('#srch-fld').on('keydown',
                    function (event) {
                        if (event.keyCode === 13) {
                            searchDocuments();
                            return false;
                        }
                    }
                );
            /* on press enter in search field */
            
        "
        , View::POS_READY
);
?>