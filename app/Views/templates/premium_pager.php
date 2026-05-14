<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" style="margin-top: 40px; display: flex; justify-content: center;">
    <ul class="premium-pagination" style="display: flex; gap: 8px; list-style: none; padding: 0; align-items: center;">
        <?php if ($pager->hasPrevious()) : ?>
            <li>
                <a href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>" class="pager-btn">
                    <i class="ph-bold ph-caret-left"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li>
                <a href="<?= $link['uri'] ?>" class="pager-link <?= $link['active'] ? 'active' : '' ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li>
                <a href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>" class="pager-btn">
                    <i class="ph-bold ph-caret-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>

<style>
    .premium-pagination .pager-link {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: white;
        color: var(--gray-500);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.2s;
        border: 1px solid var(--gray-100);
    }

    .premium-pagination .pager-link.active {
        background: var(--app-primary);
        color: white;
        border-color: var(--app-primary);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.2);
    }

    .premium-pagination .pager-link:hover:not(.active) {
        background: var(--gray-50);
        color: var(--app-primary);
        border-color: var(--app-primary);
    }

    .premium-pagination .pager-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: var(--gray-100);
        color: var(--gray-600);
        text-decoration: none;
        transition: all 0.2s;
    }

    .premium-pagination .pager-btn:hover {
        background: var(--gray-200);
        color: var(--gray-800);
    }
</style>
