$("#careersNj").validate({
    rules: {
        firstName: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
        lastName: { pattern: /^[a-zA-Z'.\s]{1,40}$/},
        dob: { required: true},
        email: { required: true, pattern: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/},
        contactNumber: { required: true, pattern: /^\d{10}$/},
        language: { required: true },
        houesNo: { required: true },
        city: { required: true },
        country: { required: true },
        postal: { required: true},
        myfile: { required: true },

        experience: { required: true},
        fromDuration : { required: true },
        toDuration:{required:true},
        designation: { required:true},
        industry:{required:true},
        ctc:{required:true},
        reason:{required:true}
    },
    messages: {
        firstName: { pattern: 'Firstname is invalid.' },
        lastName: { pattern: 'Lastname is invalid.' },
        email: { pattern: 'Email is invalid.' },
        dob: { pattern: 'DOB is invalid.' },
        contactNumber: { pattern: 'Phone Number is invalid.' },
        toDuration:{pattern:'To date must be less than from date'},
        
    }
});

