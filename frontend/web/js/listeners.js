function commitRegistration(auth_key) {
    $.post('../institution/sections/commit-registration', {'AuthKey[auth_key]': auth_key}, function () {});
}

function commitClass(lvl, cls, str, sbl, nm, act) {
    $.post('../institution/sections/commit-class',
            {
                'Classes[level]': lvl,
                'Classes[class]': cls,
                'Classes[stream]': str,
                'Classes[symbol]': sbl,
                'Classes[name]': nm,
                'Classes[active]': act
            },
            function () {}
    );
}

function commitSubject(lvl, dpt, dpt_nm, cls, sbj, cd, nm, act) {
    $.post('../institution/sections/commit-subject',
            {
                'Subjects[level]': lvl,
                'Subjects[dept]': dpt,
                'Subjects[dept_name]': dpt_nm,
                'Subjects[class]': cls,
                'Subjects[subject]': sbj,
                'Subjects[code]': cd,
                'Subjects[name]': nm,
                'Subjects[active]': act
            },
            function () {}
    );
}