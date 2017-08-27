function registerSchool() {
    yiiModal('School Registration', '../institution/sections/school-registration', {}, $('.class-of-content').width() * 0.5, $('.class-of-content').height() * 0.775);
}

function pushRegistration() {
    post = $('#form-school-registration').serializeArray();

    post.push({name: 'sbmt', value: ''});

    $.post('../institution/sections/school-registration', post,
            function (form) {
                $('#yii-modal-cnt').html(form);
            }
    );
}

function registerClasses() {
    yiiModal('Class Registration', '../institution/sections/school-classes', {}, $('.class-of-content').width() * 0.4, $('.class-of-content').height() * 0.975);
}

function pushClasses() {
    post = $('#form-school-classes').serializeArray();

    post.push({name: 'sbmt', value: ''});

    $.post('../institution/sections/school-classes', post,
            function (form) {
                $('#yii-modal-cnt').html(form);
            }
    );
}

function registerSubjects() {
    yiiModal('Subject Registration', '../institution/sections/school-subjects', {}, $('.class-of-content').width() * 0.4, $('.class-of-content').height() * 0.975);
}

function pushSubject(btn) {
    $.post('../institution/sections/school-subjects',
            {
                'Subjects[level]': btn.attr('lvl'),
                'Subjects[dept]': btn.attr('dpt'),
                'Subjects[dept_name]': btn.attr('dpt_nm'),
                'Subjects[class]': btn.attr('cls'),
                'Subjects[subject]': btn.attr('sbj'),
                'Subjects[code]': btn.attr('cd'),
                'Subjects[name]': btn.attr('nm'),
                'Subjects[active]': btn.hasClass('btn-warning') ? 'yes' : 'no'
            },
            function (actv) {
                if ((actv === 'yes' &&  !btn.hasClass('btn-success')) || (actv !== 'yes' &&  !btn.hasClass('btn-warning'))) {
                    commitSubject(btn.attr('lvl'),  btn.attr('dpt'),  btn.attr('dpt_nm'),  btn.attr('cls'),  btn.attr('sbj'),  btn.attr('cd'),  btn.attr('nm'),  actv);
                    btn.removeClass(actv === 'yes' ? 'btn-warning' : 'btn-success').addClass(actv === 'yes' ? 'btn-success' : 'btn-warning');
                }
            }
    );
}