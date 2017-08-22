function dynamicConstituencies(county, constituency, constituencyField, url) {
    $.post(url, {'county': county, 'constituency': constituency},
            function (constituencies) {
                constituencyField.html(constituencies).change();
            }
    );
}

function dynamicWards(constituency, ward, wardField, url) {
    $.post(url, {'constituency': constituency, 'ward': ward},
            function (wards) {
                wardField.html(wards);
            }
    );
}