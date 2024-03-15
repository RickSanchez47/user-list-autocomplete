<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include Tailwind CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="antialiased">
    <!-- Search input -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search by Name/Department/Designation">
    </div>

    <!-- Create user button -->
    <button id="openModalBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Create User
    </button>

    <!-- User cards -->
    <div id="userCards" class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        <!-- User cards will be displayed here -->
        <!-- Each user card will be a div with appropriate styling -->
    </div>

    <!-- Modal for creating a user -->
    <div id="createUserModal" class="modal hidden fixed inset-0 w-full h-full bg-gray-800 bg-opacity-50 overflow-auto flex justify-center items-center">
        <div class="modal-content bg-white w-1/2 p-8 rounded-lg">
            <span class="close absolute top-0 right-0 mt-4 mr-4 cursor-pointer">&times;</span>
            <h2 class="mb-4">Create User</h2>
            <form id="createUserForm">
                @csrf
                <!-- Input fields for user details -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="department" class="block text-gray-700">Department:</label>
                    <select id="fk_department" name="department" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="designation" class="block text-gray-700">Designation:</label>
                    <select id="fk_designation" name="designation" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="">Select Designation</option>
                        @foreach($designations as $designation)
                            <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="phone_number" class="block text-gray-700">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Create
                </button>
            </form>
        </div>
    </div>

    <!-- Script for handling modal and form submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to open the modal
        function openModal() {
            $('#createUserModal').removeClass('hidden');
        }

        // Function to close the modal
        function closeModal() {
            $('#createUserModal').addClass('hidden');
        }

        // When the document is ready
        $(document).ready(function() {
            // Open modal when the button is clicked
            $('#openModalBtn').click(function() {
                openModal();
            });

            // Close modal when the close button is clicked
            $('.close').click(function() {
                closeModal();
            });

            // Close modal when clicking outside the modal
            $(window).click(function(event) {
                if ($(event.target).is('#createUserModal')) {
                    closeModal();
                }
            });

            // Prevent modal from closing when clicking inside the modal
            $('#createUserModal .modal-content').click(function(event) {
                event.stopPropagation();
            });

             
            // Handle form submission to create a new user
            $('#createUserForm').submit(function(e) {
                e.preventDefault();
                
                // Get form data
                var formData = $(this).serialize();

                // Send AJAX request to create user
                $.ajax({
                    url: '/users/create', // URL to handle user creation on the server
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        // Close the modal after successful user creation
                        closeModal();
                        fetchUserCards();
                        // Optionally, you can update the user list or perform any other action
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Optionally, display error message to the user
                    }
                });
            });

            // Event listener for search input keyup
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                fetchUsers(searchText); // Fetch and update user cards based on search input
            });
           
            fetchUserCards();

            
    
});
        // Function to fetch and update user cards
function fetchUserCards() {
    $.ajax({
        url: '/users',
        method: 'GET',
        success: function(users) {
            // Clear existing user cards
            $('#userCards').empty();

            // Iterate through fetched users and append user cards
            users.forEach(function(user) {
                $('#userCards').append('<div class="user-card">' +
                    '<h3>' + user.name + '</h3>' +
                    '<p>Department: ' + user.fk_department.name + '</p>' +
                    '<p>Designation: ' + user.fk_designation.name + '</p>' +
                    '<p>Phone Number: ' + user.phone_number + '</p>' +
                    '</div>');
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
            // Optionally, display error message to the user
        }
    });
}
function fetchUsers(searchText) {
        $.ajax({
            url: '/users/search', // URL to handle search on the server
            method: 'GET',
            data: { searchText: searchText },
            success: function(users) {
                // Clear existing user cards
            $('#userCards').empty();

            // Iterate through fetched users and append user cards
            users.forEach(function(user) {
                $('#userCards').append('<div class="user-card">' +
                    '<h3>' + user.name + '</h3>' +
                    '<p>Department: ' + user.fk_department.name + '</p>' +
                    '<p>Designation: ' + user.fk_designation.name + '</p>' +
                    '<p>Phone Number: ' + user.phone_number + '</p>' +
                    '</div>');
            });
            },
            error: function(xhr, status, error) {
                console.error(error);
                // Optionally, display error message to the user
            }
        });
    }
    </script>
</body>
</html>
