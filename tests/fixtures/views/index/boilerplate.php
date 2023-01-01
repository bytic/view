<?= $this->loadIfExists('/modules/header/menu'); ?>
<?= $this->loadIfExists('/modules/header/title'); ?>
<?= $this->loadWithFallback('/modules/header/menu', '/modules/header/title'); ?>
<?php if ($this->existPath('/modules/header/title')): ?>
    ++
<?php endif; ?>

