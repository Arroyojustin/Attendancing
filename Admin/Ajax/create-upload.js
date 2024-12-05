function uploadFile(file) {
    const formData = new FormData();
    formData.append('file', file);

    $.ajax({
        url: 'controller/create-upload-student.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $('#uploadProgress').show();
            $('#progressBar').css('width', '0%');
        },
        xhr: function () {
            const xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener('progress', function (evt) {
                if (evt.lengthComputable) {
                    const percentComplete = (evt.loaded / evt.total) * 100;
                    $('#progressBar').css('width', percentComplete + '%');
                    $('#progressPercent').text(Math.round(percentComplete) + '%');
                }
            }, false);
            return xhr;
        },
        success: function (response) {
            let res;
            try {
                res = JSON.parse(response);

                if (res.error) {
                    Swal.fire({
                        toast: true,
                        icon: 'error',
                        title: res.error,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                    });
                } else if (res.message) {
                    Swal.fire({
                        toast: true,
                        icon: 'success',
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500,
                        position: 'top-end',
                    });

                    $('#internsInfo').empty();
                    res.data.forEach((student) => {
                        const studentDiv = $(`<div class="student-name" style="border: 1px solid #ddd; text-align: center; padding: 10px; margin: 5px 0; background-color: #f9f9f9; cursor: pointer;">
                                                ${student.firstname} ${student.lastname}</div>`);
                        studentDiv.data('student', student);
                        $('#internsInfo').append(studentDiv);
                    });

                    $('.student-name').on('click', function () {
                        const student = $(this).data('student');
                        populateUpdateForm(student); 
                    });
                }
            } catch (e) {
                console.error('Invalid JSON response');
            }
        },
    });
}

function populateUpdateForm(student) {
    $('#lastName').val(student.lastname);
    $('#firstName').val(student.firstname);
    $('#middleInitial').val(student.middle_initial);
    $('#studentNumber').val(student.student_no);
    $('#weight').val(student.weight || '');
    $('#height').val(student.height || '');
    $('#bmi').val(student.bmi || '');
    $('#bloodType').val(student.blood_type || '');
    $('#gender').val(student.gender);
    $('#emergencyContact').val(student.phone_no);
    $('#email').val(student.email);
    $('#password').val(student.plain_password); // Plain password for update form
    $('#sportsType').val(student.sports_type || ''); // Set the sports type
}
