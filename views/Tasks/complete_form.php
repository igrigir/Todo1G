<?php // views/tasks/complete_form.php ?>
<div class="modal fade" id="completeModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="post" action="<?= e(base_url('?action=complete')) ?>" id="completeForm">
      <div class="modal-header">
        <h5 class="modal-title">Complete Task</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="complete_task_id">
        <div class="mb-3">
          <label class="form-label">Spent time (minutes)</label>
          <input type="number" class="form-control" name="spent_minutes" id="spent_minutes" min="0" step="1" value="0" required>
          <div class="form-text">Upiši približno utrošeno vrijeme.</div>
        </div>
        <div class="alert alert-secondary mb-0">
          Kada potvrdiš, task će biti označen kao <strong>Done</strong>, a datum zatvaranja će se automatski upisati.
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-light" type="button" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" type="submit">Mark as Done</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('completeModal')?.addEventListener('show.bs.modal', (ev) => {
  const btn = ev.relatedTarget;
  document.getElementById('complete_task_id').value = btn?.dataset?.id || '';
  document.getElementById('spent_minutes').value = 0;
});
</script>
