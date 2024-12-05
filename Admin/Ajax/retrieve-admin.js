function createAdminAccount(username, password) {
    const data = {
        username: username,
        password: password
    };

    fetch("../create_admin.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            console.log(data.message); // Admin account created successfully
        } else {
            console.error(data.message); // Error message
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

// Example usage:
createAdminAccount("newAdminUser", "securePassword123");
