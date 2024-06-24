//workspace functions
document.addEventListener('DOMContentLoaded', function() {
	const openModalBtn = document.getElementById('openModal');
	const closeModalBtn = document.getElementById('closeModal');
	const createWorkspaceModal = document.getElementById('createWorkspace');

	if (openModalBtn && closeModalBtn && createWorkspaceModal) {
		openModalBtn.addEventListener('click', function() {
			createWorkspaceModal.style.display = 'block';
		});

		closeModalBtn.addEventListener('click', function() {
			const name = document.getElementById('workspaceName').value;
			const description = document.getElementById('description').value;

			fetch('/workspace', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				},
				body: JSON.stringify({ name: name, description: description })
			})
			.then(response => response.json())
			.then(data => {
				alert(data.message);
				createWorkspaceModal.style.display = 'none';
				document.getElementById('workspaceName').value = '';
				document.getElementById('description').value = '';
			})
			.catch(error => {
				alert('Error: ' + error.message);
			});
		});
	}
});
