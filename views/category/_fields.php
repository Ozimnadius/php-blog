<div class="col-md-6 mb-3">
  <label for="title">Заголовок</label>
  <input type="text"
         name="name"
         class="form-control"
         id="title"
         placeholder="Заголовок"
         value="<?= $fields['name'] ?>"
         required
  >
  <div class="invalid-feedback">
    Valid first name is required.
  </div>
</div>
