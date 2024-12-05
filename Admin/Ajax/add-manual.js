document.addEventListener('DOMContentLoaded', function () {
    const addManuallyLink = document.getElementById('addManuallyLink');
    const formInputs = document.querySelectorAll('#updateStudentForm input, #updateStudentForm select');

    addManuallyLink.addEventListener('click', function(event) {
        event.preventDefault();

        formInputs.forEach(input => {
            // Toggle the disabled state of the fields
            if (input.hasAttribute('disabled')) {
                input.removeAttribute('disabled');
                input.classList.remove('form-control-sm'); 
            } else {
                input.setAttribute('disabled', 'disabled');
                input.classList.add('form-control-sm'); 
            }
        });

        if (addManuallyLink.innerText === "Add manually") {
            addManuallyLink.innerText = "Cancel manual entry";
        } else {
            addManuallyLink.innerText = "Add manually";
        }
    });
});