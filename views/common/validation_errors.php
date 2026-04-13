<div class="error-list">
  <? foreach ($validateErrors as $error): ?>
    <div class="alert alert-danger"
         role="alert"
    >
      <?= $error ?>
    </div>
  <? endforeach; ?>
</div>
