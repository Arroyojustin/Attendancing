document.getElementById('dropZone').addEventListener('dragover', function(event) {
    event.preventDefault();
    event.stopPropagation();
    event.dataTransfer.dropEffect = 'copy';
});

document.getElementById('dropZone').addEventListener('drop', function(event) {
    event.preventDefault();
    event.stopPropagation();

    const files = event.dataTransfer.files;
    if (files.length > 0) {
        handleFileUpload(files[0]);
    }
});

document.getElementById('fileInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        handleFileUpload(file);
    }
});

function handleFileUpload(file) {
    const formData = new FormData();
    formData.append('file', file);

    // Show progress bar
    document.getElementById('uploadProgress').style.display = 'block';
    document.getElementById('uploadfileName').textContent = file.name;

    // AJAX request to upload CSV
    fetch('controller/create-upload-student.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
        } else {
            populateStudentInfo(data.data);
        }
    })
    .catch(error => {
        console.error('Error uploading file:', error);
        alert('Error uploading file');
    });
}

function populateStudentInfo(students) {
    const internsInfoDiv = document.getElementById('internsInfo');
    internsInfoDiv.innerHTML = ''; // Clear previous content

    students.forEach(student => {
        const div = document.createElement('div');
        div.textContent = `${student.firstname} ${student.lastname}`;
        div.classList.add('student');
        div.addEventListener('click', () => fillUpdateForm(student));
        internsInfoDiv.appendChild(div);
    });
}

function fillUpdateForm(student) {
    document.getElementById('firstName').value = student.firstname;
    document.getElementById('lastName').value = student.lastname;
    document.getElementById('middleInitial').value = student.middle_initial;
    document.getElementById('studentNumber').value = student.student_no;
    document.getElementById('weight').value = student.weight;
    document.getElementById('height').value = student.height;
    document.getElementById('bmi').value = student.bmi;
    document.getElementById('bloodType').value = student.bloodtype;
    document.getElementById('gender').value = student.gender;
    document.getElementById('email').value = student.email;
    document.getElementById('password').value = student.password;
    document.getElementById('sportsType').value = student.sports_type;
}
