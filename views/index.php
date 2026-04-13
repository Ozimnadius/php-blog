<div class="row">
  <? foreach ($rows as $row): ?>
    <div class="col-md-4">
      <div class="card mb-4 shadow-sm">
        <svg class="bd-placeholder-img card-img-top"
             width="100%"
             height="225"
             xmlns="http://www.w3.org/2000/svg"
             preserveAspectRatio="xMidYMid slice"
             focusable="false"
             role="img"
             aria-label="Placeholder: Thumbnail"
        >
          <title>Placeholder</title>
          <rect width="100%"
                height="100%"
                fill="#55595c"
          ></rect>
          <text x="50%"
                y="50%"
                fill="#eceeef"
                dy=".3em"
          ></text>
        </svg>
        <div class="card-body">
          <h2 class="card-title">
            <a href="<?=BASE_URL?>category/<?= $row['id_category'] ?>"><?= $row['name'] ?></a>
          </h2>
        </div>
      </div>
    </div>
  <? endforeach; ?>
</div>