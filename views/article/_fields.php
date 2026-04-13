<div class="col-md-6 mb-3">
  <label for="title">Заголовок</label>
  <input type="text"
         name="title"
         class="form-control"
         id="title"
         placeholder="Заголовок"
         value="<?= $fields['title'] ?>"
         required
  >
  <div class="invalid-feedback">
    Valid first name is required.
  </div>
</div>

<div class="col-md-6 mb-3">
  <label for="cat">Категория</label>
  <select class="custom-select d-block w-100"
          id="cat"
          name="id_category"
          required
  >
    <? foreach ($categories as $category): ?>
      <option <? if ($fields['id_category'] == $category['id_category']): ?>selected<? endif; ?>
              value="<?= $category['id_category'] ?>"
      >
        <?= $category['name'] ?>
      </option>
    <? endforeach; ?>
  </select>
  <div class="invalid-feedback">
    Please provide a valid state.
  </div>
</div>

<div class="col-md-12 mb-3">
  <label for="content">Content</label>
  <textarea class="form-control"
            id="content"
            rows="3"
            name="content"
  ><?= $fields['content'] ?></textarea>
</div>
