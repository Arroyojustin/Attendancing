<div class="container-fluid bg-light p-0 m-0" id="addstud" style="display: none;">
    <div class="row g-4">
        <!-- Left square container -->
        <div class="col-md-4 col-lg-3">
            <div class="bg-light rounded-3 px-4 py-4 d-flex flex-column" style="min-height: 200px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
                <h5 class="text-gray-800 fw-bold border-bottom border-dark pb-2 mb-3">Upload Students Lists</h5>
                <!-- Rectangle container with dashed green border -->
                <div id="dropZone" class="d-flex flex-column justify-content-center align-items-center" 
                    style="border: 2px dashed green; min-height: 150px; padding: 20px; border-radius: 10px;">
                    <i class="fa-solid fa-cloud-arrow-up mt-3" style="font-size: 50px; color: green;"></i>
                    <p class="text-gray-800 mt-2">Drag files to upload</p>
                    <!-- Hidden file input -->
                    <input type="file" id="fileInput" accept=".xlsx, .xls .csv" style="display: none;"/>
                </div>
                <!-- Upload button -->
                <button type="button" id="uploadButton" class="btn btn-outline-success mt-3">
                    <i class="fa-solid fa-cloud-arrow-up"></i> Upload Files
                </button>
                <!-- Progress Container -->
                <div id="uploadProgress" class="mt-4" style="display: none;">
                    <div class="d-flex align-items-center justify-content-between" style="width: 100%;">
                        <div class="d-flex align-items-center flex-grow-1">
                            <i class="fa-solid fa-file-excel" style="font-size: 30px; color: green;"></i>
                            <div class="ms-2">
                                <span id="uploadfileName" class="text-gray-800"></span>
                                <div class="progress mb-1" style="width: 180px; height: 15px;">
                                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" 
                                        role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <span id="progressPercent" class="text-end d-block me-1">0%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="uploadCompleteIcon" style="display: none;">
                            <i class="fa-solid fa-check" style="font-size: 15px; color: green;"></i>
                        </span>
                        <button id="cancelUploadBtn" style="display: none;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Middle square container -->
        <div class="col-md-4 col-lg-3">
            <div class="bg-light rounded-3 px-4 py-4 d-flex flex-column" style="min-height: 200px; box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
                <h5 class="text-gray-800 fw-bold border-bottom border-dark pb-2 mb-3">students</h5>
                <div class="mb-3 position-relative">
                    <input type="text" class="form-control" id="searchInterns" placeholder="Search student...">
                    <i class="fa-solid fa-magnifying-glass position-absolute search-icon"></i>
                </div>
                <div id="internsInfo" class="text-gray-800">
                    <!-- Student names will be displayed here -->
                </div>
            </div>
        </div>

        <!-- Right rectangle container -->
        <div class="col-md-6 col-lg-6">
            <div class="bg-light rounded-3 px-4 py-4" style="box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 2px 6px 2px;">
                <h5 class="text-gray-800 fw-bold border-bottom border-dark pb-2 mb-3">Update Students</h5>
                <form id="updateStudentForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control form-control-sm" id="lastName" name="lastName">
                        </div>
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control form-control-sm" id="firstName" name="firstName">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="middleInitial" class="form-label">Middle Initial</label>
                            <input type="text" class="form-control form-control-sm" id="middleInitial" name="middleInitial">
                        </div>
                        <div class="col-md-3">
                            <label for="studentNumber" class="form-label">Student No.</label>
                            <input type="text" class="form-control form-control-sm" id="studentNumber" name="studentNumber">
                        </div>
                        <div class="col-md-3">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" class="form-control form-control-sm" id="weight" name="weight">
                        </div>
                        <div class="col-md-3">
                            <label for="height" class="form-label">Height (cm)</label>
                            <input type="number" class="form-control form-control-sm" id="height" name="height">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="bmi" class="form-label">BMI</label>
                            <input type="text" class="form-control form-control-sm" id="bmi" name="bmi" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="bloodType" class="form-label">Blood Type</label>
                            <input type="text" class="form-control form-control-sm" id="bloodType" name="bloodType" disabled>
                        </div>
                        <div class="col-md-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-select-sm" id="gender" name="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="emergencyContact" class="form-label">Contact no.</label>
                            <input type="text" class="form-control form-control-sm" id="emergencyContact" name="emergencyContact">
                        </div>
                    </div>

                    <h5 class="text-gray-800 fw-bold mt-4">Account Information</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password">
                        </div>
                        <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="sportsType" class="form-label">Sports Type</label>
                            <select id="sportsType" class="form-control">
                                <option value="basketball">Basketball</option>
                                <option value="volleyball">Volleyball</option>
                            </select>
                        </div>
                     </div>
                    </div>

                    <!-- Sports Type Dropdown -->
                    

                    <div class="text-end d-flex justify-content-between">
                        <!-- Left side: Add manually link -->
                        <a href="#" id="addManuallyLink" class="text-primary mt-1" style="text-decoration: none; font-size: 14px; margin-right: auto;">
                            Add manually
                        </a>
                        <button type="button" class="btn btn-outline-secondary me-2" onclick="showSection(event, 'student')" style="width: 150px;">Back</button>
                        <button type="button" class="btn btn-outline-success" onclick="showSection(event, 'student')" style="width: 150px;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle file drop and selection
    document.getElementById('dropZone').addEventListener('drop', handleFileDrop);
    document.getElementById('fileInput').addEventListener('change', handleFileSelect);
    document.getElementById('uploadButton').addEventListener('click', () => document.getElementById('fileInput').click());

    let studentData = []; // Array to hold parsed CSV data

    function handleFileDrop(event) {
        event.preventDefault();
        handleFileSelect(event.dataTransfer.files);
    }

    function handleFileSelect(files) {
        const file = files[0];
        if (file && file.name.endsWith('.csv')) {
            const formData = new FormData();
            formData.append('file', file);

            // Show upload progress
            document.getElementById('uploadProgress').style.display = 'block';
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');
            const uploadFileName = document.getElementById('uploadfileName');
            uploadFileName.textContent = file.name;

            // Send the file to the server for parsing
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '.controller/create-upload-student.php', true);

            xhr.upload.addEventListener('progress', function (event) {
                if (event.lengthComputable) {
                    const percent = (event.loaded / event.total) * 100;
                    progressBar.style.width = percent + '%';
                    progressPercent.textContent = Math.round(percent) + '%';
                }
            });

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        alert(response.error);
                    } else {
                        studentData = response.data;
                        displayStudentData();
                    }
                }
            };

            xhr.send(formData);
        } else {
            alert('Please upload a valid CSV file.');
        }
    }

    // Display the students in internsInfo
    function displayStudentData() {
        const internsInfo = document.getElementById('internsInfo');
        internsInfo.innerHTML = ''; // Clear previous data

        studentData.forEach((student, index) => {
            const div = document.createElement('div');
            div.classList.add('student');
            div.innerHTML = `${student.firstname} ${student.lastname} (${student.sports_type})`;
            div.onclick = () => populateStudentForm(student);
            internsInfo.appendChild(div);
        });
    }

    // Populate the updateStudentForm with the selected student data
    function populateStudentForm(student) {
        document.getElementById('firstName').value = student.firstname;
        document.getElementById('lastName').value = student.lastname;
        document.getElementById('middleInitial').value = student.middle_initial;
        document.getElementById('studentNumber').value = student.student_no;
        document.getElementById('weight').value = student.weight;
        document.getElementById('height').value = student.height;
        document.getElementById('bmi').value = student.bmi;
        document.getElementById('bloodType').value = student.bloodtype;
        document.getElementById('gender').value = student.gender;
        document.getElementById('emergencyContact').value = student.phone_no;
        document.getElementById('email').value = student.email;
        document.getElementById('password').value = student.plain_password;
        document.getElementById('sportsType').value = student.sports_type;
    }

    // Handle the save button click
    document.querySelector('.btn-outline-success').addEventListener('click', function () {
        const formData = new FormData(document.getElementById('updateStudentForm'));

        // Append the sports_type from the form
        formData.append('sportsType', document.getElementById('sportsType').value);

        // Send the data to save_student.php to save it to the database
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'controller/save_student.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    alert('Student saved successfully!');
                    // You can update the DataTable here if you want
                } else {
                    alert('Error saving student.');
                }
            }
        };

        xhr.send(formData);
    });
</script>
