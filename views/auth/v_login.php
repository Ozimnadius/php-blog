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
  <label>
    <input type="checkbox" name="remember"> Запомнить меня на 30 дней
  </label>
  <button type="submit">Войти</button>
</form>

<a href="<?= BASE_URL ?>register">Нет аккаунта? Зарегистрируйтесь</a>