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

function commitTeacherRegistration(fname, mname, lname, dob, gdr, idno, tscno, phone, email, sbj1, sbj2, postno, postcd, cty, ctcy, ward, lctn, sblctn, vllg, snc, till) {
    $.post('../institution/sections/commit-teacher-registration',
            {
                'SchoolTeachers[fname]': fname,
                'SchoolTeachers[mname]': mname,
                'SchoolTeachers[lname]': lname,
                'SchoolTeachers[dob]': dob,
                'SchoolTeachers[gender]': gdr,
                'SchoolTeachers[id_no]': idno,
                'SchoolTeachers[tsc_no]': tscno,
                'SchoolTeachers[phone]': phone,
                'SchoolTeachers[email]': email,
                'SchoolTeachers[subject_one]': sbj1,
                'SchoolTeachers[subject_two]': sbj2,
                'SchoolTeachers[postal_no]': postno,
                'SchoolTeachers[postal_code]': postcd,
                'SchoolTeachers[county]': cty,
                'SchoolTeachers[constituency]': ctcy,
                'SchoolTeachers[ward]': ward,
                'SchoolTeachers[location]': lctn,
                'SchoolTeachers[sub_location]': sblctn,
                'SchoolTeachers[village]': vllg,
                'SchoolTeachers[since]': snc,
                'SchoolTeachers[till]': till
            },
            function () {}
    );
}