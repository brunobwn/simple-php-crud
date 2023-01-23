function redirect(url) {
	window.location = url;
}

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	return new bootstrap.Tooltip(tooltipTriggerEl);
});

function handleDeleteButton(id) {
	const inputIdModal = document.getElementById('inputIdModal');
	inputIdModal.value = String(id);
}
