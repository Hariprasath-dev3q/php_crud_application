<?php
/**
 * Bootstrap 5 Pagination for CodeIgniter 4
 * File: app/Views/Pager/custom_pager.php
 */
?>

<?php $pager->setSurroundCount(2) ?>
<?php  if ($pager->hasPreviousPage() || $pager->hasNextPage()) : ?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

    <!-- Previous -->
    <li class="page-item <?= $pager->hasPreviousPage() ? '' : 'disabled' ?>">
      <a class="page-link"
         href="<?= $pager->hasPreviousPage() ? $pager->getPreviousPage() : '#' ?>"
         aria-label="Previous"
         tabindex="<?= $pager->hasPreviousPage() ? '0' : '-1' ?>">
        &laquo;
      </a>
    </li>

    <!-- Page Numbers -->
    <?php foreach ($pager->links() as $link) : ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach; ?>

    <!-- Next -->
    <li class="page-item <?= $pager->hasNextPage() ? '' : 'disabled' ?>">
      <a class="page-link"
         href="<?= $pager->hasNextPage() ? $pager->getNextPage() : '#' ?>"
         aria-label="Next"
         tabindex="<?= $pager->hasNextPage() ? '0' : '-1' ?>">
        &raquo;
      </a>
    </li>

  </ul>
</nav>
<?php endif; ?>

