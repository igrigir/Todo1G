<?php // views/tasks/form.php ?>
<div class="modal fade" id="taskModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <form class="modal-content" method="post" action="<?= e(base_url('?action=store')) ?>" id="taskForm">
      <div class="modal-header">
        <h5 class="modal-title" id="taskModalLabel">New Task</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="task_id">
        <div class="mb-3">
          <label class="form-label">Title</label>
          <input type="text" class="form-control" name="title" id="task_title" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Description</label>
          <textarea class="form-control" name="description" id="task_description" rows="3"></textarea>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" id="task_status">
              <option value="0">Created</option>
              <option value="1">Started</option>
              <option value="2">Done</option>
              <option value="3">Postponed</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Due date</label>
            <input type="date" class="form-control" name="due_date" id="task_due">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-outline-light" type="button" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
document.getElementById('taskModal')?.addEventListener('show.bs.modal', (ev) => {
  const btn = ev.relatedTarget;
  const form = document.getElementById('taskForm');
  const isEdit = !!btn?.dataset?.id;

  document.getElementById('task_id').value = btn?.dataset?.id || '';
  document.getElementById('task_title').value = btn?.dataset?.title || '';
  document.getElementById('task_description').value = btn?.dataset?.description || '';
  document.getElementById('task_status').value = btn?.dataset?.status || 0;
  document.getElementById('task_due').value = btn?.dataset?.due || '';

  document.getElementById('taskModalLabel').innerText = isEdit ? 'Edit Task' : 'New Task';
  form.action = isEdit ? '<?= e(base_url("?action=update")) ?>' : '<?= e(base_url("?action=store")) ?>';
});
</script>
