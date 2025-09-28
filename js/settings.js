function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const placeholder = document.getElementById('avatarPlaceholder');
            let preview = document.getElementById('avatarPreview');
            
            if (!preview) {
                // Create new img element if doesn't exist
                preview = document.createElement('img');
                preview.id = 'avatarPreview';
                preview.className = 'avatar-preview';
                preview.alt = 'Avatar';
                
                if (placeholder) {
                    placeholder.parentNode.replaceChild(preview, placeholder);
                }
            }
            
            preview.src = e.target.result;
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Auto dismiss alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        const bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);