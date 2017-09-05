function registerSchool() {
    yiiModal('School Registration', '../institution/sections/school-registration', {}, $('.class-of-content').width() * 0.5, $('.class-of-content').height() * 0.4);
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

function registerTeacher() {
    yiiModal('Teacher Registration', '../institution/sections/teacher-registration', {}, $('.class-of-content').width() * 0.5, $('.class-of-content').height() * 0.775);
}

function pushTeacherRegistration() {
    post = $('#form-teacher-registration').serializeArray();

    post.push({name: 'sbmt', value: ''});

    $.post('../institution/sections/teacher-registration', post,
            function (form) {
                $('#yii-modal-cnt').html(form);
            }
    );
}

function loadTeacherRegistration(id) {
    $.post('../institution/sections/teacher-registration', {'Teachers[id]': id},
            function (form) {
                $('#yii-modal-cnt').html(form);
            }
    );
}

function loadTeacherByIDorTSCNo(nm, val) {
     $.post('../institution/sections/teacher-by-id-or-tsc-no', {nm: nm, val: val},
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
                if ((actv === 'yes' && !btn.hasClass('btn-success')) || (actv !== 'yes' && !btn.hasClass('btn-warning'))) {
                    commitSubject(btn.attr('lvl'), btn.attr('dpt'), btn.attr('dpt_nm'), btn.attr('cls'), btn.attr('sbj'), btn.attr('cd'), btn.attr('nm'), actv);
                    btn.removeClass(actv === 'yes' ? 'btn-warning' : 'btn-success').addClass(actv === 'yes' ? 'btn-success' : 'btn-warning');
                }
            }
    );
}

function pushFile(id) {
    yiiModal('Schemes of Work', 'sections/push-schemes-of-work', {'SchemesOfWork[submitted_as]': $('#' + id).attr('dcl')}, $('.inst-ctnt').width() * 0.75, $('.institution-default-index').height() * 0.7125);
}

function pushSchemeOfWork() {
    post = $('#form-sceheme-of-work').serializeArray();

    post.push({name: 'sbmt', value: ''});

    $.post('sections/push-schemes-of-work', post,
            function (form) {
                $('#yii-modal-cnt').html(form);
            }
    );
}

function serverClassChanged(cls, str, sbj, actv) {
    dynamicServerStreams(cls, str, actv);
    dynamicServerSubjects(cls, sbj, actv);
}

function dynamicServerTeacherSubjects(sbj, val, elmnt) {
    $.post('../institution/sections/dynamic-server-teacher-subjects', {'subject1': sbj, 'subject2': val},
            function (subjects) {
                elmnt.html(subjects);
            }
    );
}

function dynamicServerStreams(cls, str, actv) {
    $.post('sections/dynamic-server-streams', {'class': cls, 'stream': str, 'active': actv},
            function (streams) {
                $('#schemesofwork-stream').html(streams);
            }
    );
}

function dynamicServerSubjects(cls, sbj, actv) {
    $.post('sections/dynamic-server-subjects', {'class': cls, 'subject': sbj, 'active': actv},
            function (subjects) {
                $('#schemesofwork-subject').html(subjects);
            }
    );
}