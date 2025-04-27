$(document).ready(function() {
    $('.roles-select,.state-select,.city-select').select2({
        placeholder: "Select option",
        allowClear: true,
    });

    $('#register_form').validate({
        rules: {
            first_name: {
                required: true,
                alphanumeric: true
            },
            last_name: {
                required: true,
                alphanumeric: true
            },
            email: {
                required: true,
                email: true
            },
            contact_no: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            postcode: {
                required: true,
                digits: true,
                minlength: 6,
                maxlength: 6
            },
            password: {
                required: true
            },
            confirm_password: {
                required: true,
                equalTo: '[name="password"]'
            },
            'file_path[]': {
                required: true,
                extension: "jpg|jpeg|png|pdf"
            },
            'hobbies[]': {
                required: true,
                minlength: 1
            },
            gender_id: {
                required: true
            },
            'roles[]': {
                required: true
            },
            state_id:{
                required: true
            },
            city_id:{
                required: true
            }
            
        },
        messages: {
            confirm_password: {
                equalTo: "Passwords do not match"
            },
            'files[]': {
                extension: "Only jpg, jpeg, png, or pdf files allowed"
            },
            'hobbies[]': {
                required: "Select at least one hobby"
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("type") === "checkbox" || element.attr("type") === "radio") {
                error.insertAfter(element.closest('div'));
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\s]+$/i.test(value);
    }, "Only letters and numbers allowed");


    $('#state_id').change(function() {
        let stateID = $(this).val();

        if (!stateID) {
            $("#city_id").empty().append('<option value="">Select a city</option>');
            return; 
        }

        if(stateID){
            let finalURL = getCitiesURL.replace('__STATE__', stateID);
            $.ajax({
                url: finalURL,
                type: 'GET',
                success: function(data) {
                    $('#city_id').empty();
                    $.each(data, function(id, name) {
                        $('#city_id').append(`<option value="${id}">${name}</option>`);
                    });
                }
            });
        }
    });

});

$('#register_form').on('submit', function(e) {
    e.preventDefault(); 
    const formData = $(this).serialize();
    $.ajax({
        url: $(this).attr('action'),  
        type: 'post',  
        dataType:'json',               
        data: formData,  
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },       
        success: function (response) {
            if (response.FLAG) {
                toastr.success(response.MESSAGE);
                // window.location.href = response.redirect_url;
            }
        },
        error: function (xhr) {
            const errors = xhr.responseJSON.errors;
            console.log(errors);
        }
    });
});