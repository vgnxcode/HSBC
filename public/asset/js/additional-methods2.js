$("#slidesubmitForm").validate({
    rules: {
        slidename: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
        slideemail: { required: true, pattern: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/},
        slidephone: { required: true, pattern: /^\d{10}$/},
        slidecity: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
    },
    messages: {
        slidename: { pattern: 'Firstname is invalid.' },
        slideemail: { pattern: 'Email is invalid.' },
        slidephone: { pattern: 'Phone Number is invalid.' },
        slidecity: { pattern: 'City is invalid.' },
       
    }
});



$("#popupsubmitForm").validate({

   
    rules: {
        popupname: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
        popupemail: { required: true, pattern: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/},
        popupphone: { required: true, pattern: /^\d{10}$/},
        popupcity: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
    },
    messages: {
        popupname: { pattern: 'Firstname is invalid.' },
        popupemail: { pattern: 'Email is invalid.' },
        popupphone: { pattern: 'Phone Number is invalid.' },
        popupcity: { pattern: 'City Number is invalid.' },
       
    }
});


$("#projectform").validate({

   
    rules: {
        projectname: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
        projectemail: { required: true, pattern: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/},
        projectphone: { required: true, pattern: /^\d{10}$/},
    },
    messages: {
        projectname: { pattern: 'Firstname is invalid.' },
        projectemail: { pattern: 'Email is invalid.' },
        projectphone: { pattern: 'Phone Number is invalid.' },
       
    }
});



$("#contactform").validate({

   
    rules: {
        contactname: { required: true, pattern: /^[a-zA-Z'.\s]{1,40}$/ },
        contactemail: { required: true, pattern: /^([a-z\d\.-]+)@([a-z\d-]+)\.([a-z]{2,8})(\.[a-z]{2,8})?$/},
        contactphone: { required: true, pattern: /^\d{10}$/},
        contactmsg: { required: true}
    },
    messages: {
        contactname: { pattern: 'Firstname is invalid.' },
        contactemail: { pattern: 'Email is invalid.' },
        contactphone: { pattern: 'Phone Number is invalid.' },
       
    }
});

