// Common error handling function
async function handleApiResponse(response) {
    const data = await response.json();
    
    if (!response.ok || data.status === 'error') {
        throw new Error(data.message || 'Something went wrong');
    }
    
    return data;
}

// Common error display function
function handleError(error) {
    console.error('Error:', error);
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: error.message || 'Something went wrong!',
        confirmButtonColor: '#3085d6'
    });
}

// Common success message function
function showSuccess(message, timer = 1500) {
    return Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

// Common loading state function
function showLoading(message = 'Loading...') {
    Swal.fire({
        title: message,
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
}

// Common delete confirmation
function showDeleteConfirmation() {
    return Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    });
}

// Common form validation
function validateForm(title, content) {
    if (!title.trim() || !content.trim()) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Title and content are required!'
        });
        return false;
    }

    if (title.length > 255) {
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            text: 'Title cannot be longer than 255 characters!'
        });
        return false;
    }

    return true;
}
