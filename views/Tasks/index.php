<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="row">
  <div class="col-12 col-lg-10 mx-auto">
    <div class="card shadow-lg" style="background:#111827;">
      <div class="card-header d-flex align-items-center justify-content-between">
        <div>
          <h4 class="mb-0">My Tasks</h4>
          <small class="text-muted">PHP OOP + PDO • Bootstrap 5</small>
        </div>
        <div>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">+ New Task</button>
        </div>
      </div>
      <div class="card-body">

        <form class="row g-2 mb-3" method="get" action="<?= e(base_url()) ?>">
          <div class="col-md-6">
            <input class="form-control" type="search" name="q" placeholder="Search title/description..." value="<?= e($_GET['q'] ?? '') ?>">
          </div>
          <div class="col-md-3">

            <select class="form-select" name="status">

              <?php $cur = $_GET['status'] ?? '0'; ?>

              <option value="-1" <?= ($cur==='-1'?'selected':'') ?>>All statuses</option>
              <option value="0" <?= ($cur==='0'?'selected':'') ?>>Created</option>
              <option value="1" <?= ($cur==='1'?'selected':'') ?>>Started</option>
              <option value="2" <?= ($cur==='2'?'selected':'') ?>>Done</option>
              <option value="3" <?= ($cur==='3'?'selected':'') ?>>Postponed</option>
              <option value="99" <?= ($cur==='99'?'selected':'') ?>>Not done</option>

            </select>

          </div>
          <div class="col-md-3 d-grid">
            <button class="btn btn-outline-light">Filter</button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-dark table-hover align-middle mb-0">
            <thead>
              <tr>
                <th style="width:60px;"></th>
                <th>Task</th>
                <th style="width:150px;">Due</th>
                <th style="width:140px;">Status</th>
                <th style="width:120px;">Spent</th>
                <th style="width:170px;">Closed</th>
                <th style="width:190px;" class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($tasks)): ?>
                <tr><td colspan="5" class="text-center text-muted py-5">No tasks found.</td></tr>
              <?php else: ?>
                <?php foreach ($tasks as $task): ?>
                  <?php $t = $task; include __DIR__ . '/_row.php'; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/form.php'; ?>
<?php require __DIR__ . '/../layout/footer.php'; ?>
<?php include __DIR__ . '/complete_form.php'; ?>
