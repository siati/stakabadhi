
<div class="sld-imgs-mdl">
    <div class="sld-imgs-vw">
        <div class="sld-imgs-vw-pn">
            <div class="sld-imgs-vw-pn-hdr">
                <strong id="imgs-hdng" class="pull-left">Currently Active Images</strong>
                <div id="imgs-actv" class="btn btn-xs btn-success pull-right" onclick="refreshSlideImages(null)"><i></i> View Active</div>
                <div id="imgs-inactv" class="btn btn-xs btn-info pull-right" onclick="refreshSlideImages(1)"><i></i> View Inactive</div>
            </div>

            <div class="sld-imgs-vw-pn-bdy">
                <div id="the-sld-imgs" class="sld-imgs-vw-pn-bdy-pn">
                    <?= $slide_images_panes ?>
                </div>
            </div>
        </div>

    </div>

    <div class="sld-imgs-ldd-img">
        <div class="sld-imgs-ldd-img-img">

            <div class="sld-imgs-ldd-img-img-img">
                <div class="sld-imgs-ldd-img-img-img-tbl">
                    <div id="img-chg" class="btn btn-lg btn-default glyphicon glyphicon-picture sld-img-2-clk" onclick="$('#slideimages-id').val() * 1 > 0 ? '' : $('#slideimages-location').click()"></div>
                    <div id="img-chg-pic-pn"  class="btn btn-lg btn-default sld-img-2-clk" onclick="$('#slideimages-id').val() * 1 > 0 ? '' : $('#slideimages-location').click()">
                        <img id="img-chg-pic"/>
                    </div>
                </div>
            </div>

            <div class="sld-imgs-ldd-img-img-sprt"></div>

            <div class="sld-imgs-ldd-img-img-btns">
                <div class="btn btn-xs btn-danger pull-right" onclick="deleteSlideImage()" style="margin-left: 5px"><i class="glyphicon glyphicon-trash"></i> Delete</div>

                <div id="sld-img-chk" class="btn btn-xs btn-success pull-right" onclick="activeSlideImage()"><i class="glyphicon glyphicon-check"></i> <span>Active</span></div>

                <div class="btn btn-xs btn-primary pull-left" onclick="imageOntoForm(null)"><i class="glyphicon glyphicon-picture"></i> New</div>
            </div>
        </div>

        <div class="sld-imgs-ldd-img-fm">
            <div class="sld-imgs-ldd-img-fm-fm">

                <div id="sld-img-fm" class="sld-imgs-ldd-img-fm-fm-pn">

                    <?= $image_form ?>

                </div>

            </div>

            <div class="btn btn-primary pull-left" onclick="saveSlideImage()" style="height: 12%">Save</div>

            <div class="btn btn-danger pull-right" onclick="closeDialog()" style="height: 12%">Close</div>
        </div>
    </div>

</div>