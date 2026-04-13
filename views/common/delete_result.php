<? if ($deleted): ?>
  <div class="alert alert-success"
       role="alert"
  >
    <?= $entityName ?> успешно удалена
  </div>
<? else: ?>
  <div class="alert alert-danger"
       role="alert"
  >
    <?= $entityName ?> не была удалена
  </div>
<? endif; ?>
