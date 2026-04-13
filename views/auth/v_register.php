<?php if (!empty($errors)): ?>
  <ul>
    <?php foreach ($errors as $error): ?>
      <li><?= htmlspecialchars($error) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<form method="POST">
  <?= csrfField() ?>
  <label>Email:
    <input type="email" name="email"
           value="<?= htmlspecialchars($fields['email']) ?>">
  </label>

  <label>Пароль:
    <input type="password" name="password">
  </label>

  <button type="submit">Зарегистрироваться</button>
</form>

<a href="<?= BASE_URL ?>login">Уже есть аккаунт? Войти</a>