<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
?>

<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a href="<?= $pager->getFirst() ?>" data-page="1" aria-label="<?= lang('Pager.first') ?>" class="page-link rounded-pill">
                    <span aria-hidden="true"><?= lang('Pager.first') ?></span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getPrevious() ?>" data-page="<?= $pager->getCurrentPage() - 1 ?>" aria-label="<?= lang('Pager.previous') ?>" class="page-link rounded-pill">
                    <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li <?= $link['active'] ? 'class="page-item active"' : 'class="page-item"' ?>>
                <a href="<?= $link['uri'] ?>" data-page="<?= $link['title'] ?>" class="page-link rounded-pill">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a href="<?= $pager->getNext() ?>" data-page="<?= $pager->getCurrentPage() + 1 ?>" aria-label="<?= lang('Pager.next') ?>" class="page-link rounded-pill">
                    <span aria-hidden="true"><?= lang('Pager.next') ?></span>
                </a>
            </li>
            <li class="page-item">
                <a href="<?= $pager->getLast() ?>" data-page="<?= $pager->getPageCount() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link rounded-pill">
                    <span aria-hidden="true"><?= lang('Pager.last') ?></span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>
