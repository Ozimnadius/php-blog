<form class="needs-validation"
      method="post"
      novalidate
>
  <div class="row">
    <?= $fieldsContent ?>

    <div class="col-md-12 mb-3">
      <button type="submit"
              class="btn btn-primary"
      >Send</button>
    </div>
  </div>

  <?= template('common/validation_errors', [
    'validateErrors' => $validateErrors
  ]) ?>
</form>
