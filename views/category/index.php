<ul class="list-group">
  <? foreach ($rows as $row): ?>
    <li class="list-group-item">
      <a href="<?=BASE_URL?>article/<?= $row['id_article'] ?>">
        <?= $row['title'] ?>
      </a>
    </li>
  <? endforeach; ?>
</ul>