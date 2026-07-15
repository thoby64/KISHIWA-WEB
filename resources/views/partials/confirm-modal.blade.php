<!-- Confirm Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="confirmModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmModalOk">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
function showConfirmModal(title, message, onConfirm) {
    const modalEl = document.getElementById('confirmModal');
    document.getElementById('confirmModalTitle').innerText = title;
    document.getElementById('confirmModalBody').innerText = message;
    const okBtn = document.getElementById('confirmModalOk');
    const bsModal = new bootstrap.Modal(modalEl);
    function cleanup() { okBtn.removeEventListener('click', handler); }
    function handler() { cleanup(); bsModal.hide(); onConfirm(); }
    okBtn.addEventListener('click', handler);
    bsModal.show();
}

function showToast(message, type = 'success') {
    const container = document.createElement('div');
    container.className = 'alert alert-' + (type || 'success') + ' position-fixed top-0 end-0 m-3';
    container.style.zIndex = 2000;
    container.innerText = message;
    document.body.appendChild(container);
    setTimeout(() => { container.classList.add('fade'); container.remove(); }, 2000);
}
</script>
