<div class="sidebar-container d-none d-md-flex flex-column p-0 m-0">
    <!-- Header -->
    <div class="sidebar-header d-flex flex-column align-items-center">
        <img src="./uploads/RAWR.png" alt="Logo" width="45">
    </div>

    <nav>
        <a href="#" class="sidebar-link" onclick="showSection(event, 'home')">
            <i class="bx bx-home"></i>
            <span>Home</span>
        </a>
        <a href="#" class="sidebar-link" onclick="showSection(event, 'attendance')">
            <i class="bx bx-user-check"></i>
            <span>Attendance</span>
        </a>
        <a href="#" class="sidebar-link" onclick="showSection(event, 'tasks')">
            <i class="bx bx-task"></i>
            <span> Add Tasks</span>
        </a>
        <a href="#" class="sidebar-link" onclick="showSection(event, 'student')">
            <i class='bx bx-user'></i>
            <span> Student</span>
        </a>
    </nav>
</div>

<script>
    function showSection(event, sectionID) {
        // Remove 'active' class from all links (both sidebar and header)
        document.querySelectorAll('.sidebar-link, .menu-link').forEach(link => {
            link.classList.remove('active');
        });

        // Mark clicked link as active
        if (event && event.target) {
            const clickedLink = event.target.closest('.sidebar-link, .menu-link');
            if (clickedLink) {
                clickedLink.classList.add('active');
            }
        }

        // Hide all sections
        document.querySelectorAll('#home, #attendance, #tasks,  #student,  #profile, #addstud').forEach(section => {
            section.style.display = 'none';
        });

        // Show the active section
        const activeSection = document.getElementById(sectionID);
        if (activeSection) {
            activeSection.style.display = 'block';
        }
    }

    window.onload = function() {
        // Set the dashboard as the default active section and link
        showSection(null, 'home'); 

        // Mark the dashboard link as active on load
        document.querySelector('a[href="#"][onclick*="home"]').classList.add('active');
    };
</script>