<?php
// views/tasks/_row.php
$statusMap = [
  0 => ['label'=>'Created','class'=>'bg-secondary'],
  1 => ['label'=>'Started','class'=>'bg-info'],
  2 => ['label'=>'Done','class'=>'bg-success'],
  3 => ['label'=>'Postponed','class'=>'bg-warning text-dark'],
];
$st = $statusMap[(int)$task['status']] ?? $statusMap[0];

$isDone = ((int)$task['status'] === 2);
?>
<tr class="<?= $isDone ? 'task-done' : '' ?>">
  
  <!-- kolona s “check” ikonom — može ostati prazna ili koristiš za nešto drugo -->
  <td class="text-nowrap">
    <?php if ($isDone): ?>
      <span title="Completed">✔</span>
    <?php endif; ?>
  </td>

  <!-- opis -->
  <td>
    <strong><?= e($task['title']) ?></strong><br>
    <small class="text-secondary"><?= nl2br(e($task['description'])) ?></small>
  </td>

  <!-- due -->
  <td class="text-nowrap">
    <?= $task['due_date'] ? e($task['due_date']) : '<span class="text-muted">—</span>' ?>
  </td>

  <!-- status -->
  <td><span class="badge <?= e($st['class']) ?>"><?= e($st['label']) ?></span></td>

  <!-- spent -->
  <td class="text-nowrap">
    <?= isset($task['spent_minutes']) && $task['spent_minutes'] !== null
        ? (int)$task['spent_minutes'] . ' min'
        : '<span class="text-muted">—</span>' ?>
  </td>

  <!-- closed -->
  <td class="text-nowrap">
    <?= $task['closed_at'] ? e($task['closed_at']) : '<span class="text-muted">—</span>' ?>
  </td>

  <!-- actions -->
  <td class="text-end text-nowrap">
    <?php if (!$isDone): ?>
      <!-- Complete: otvori modal za unos utrošenog vremena -->
      <button type="button"
              class="btn btn-sm btn-success"
              data-bs-toggle="modal"
              data-bs-target="#completeModal"
              data-id="<?= (int)$task['id'] ?>">
        Complete
      </button>
    <?php else: ?>
      <!-- Reopen: vrati na status=0 i resetiraj vremena -->
      <form class="d-inline" method="post" action="<?= e(base_url('?action=reopen')) ?>">
        <input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
        <button class="btn btn-sm btn-outline-warning">Reopen</button>
      </form>
    <?php endif; ?>

    <!-- Edit modal trigger -->
    <button type="button"
            class="btn btn-sm btn-outline-info"
            data-bs-toggle="modal"
            data-bs-target="#taskModal"
            data-id="<?= (int)$task['id'] ?>"
            data-title="<?= e($task['title']) ?>"
            data-description="<?= e($task['description']) ?>"
            data-status="<?= (int)$task['status'] ?>"
            data-due="<?= e($task['due_date']) ?>">
      Edit
    </button>

    <form class="d-inline" method="post" action="<?= e(base_url('?action=destroy')) ?>" onsubmit="return confirm('Delete task?')">
      <input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
      <button class="btn btn-sm btn-outline-danger">Delete</button>
    </form>
  </td>
</tr>
