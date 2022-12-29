<?php declare(strict_types=1);
echo $this->Doctype()->set('XHTML1_STRICT'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load('/modules/head'); ?>
<body>
<?php $this->load('/modules/header'); ?>

<main>
    <?= $this->render('content'); ?>
</main>

<?php $this->load('/modules/footer'); ?>
</body>
</html>