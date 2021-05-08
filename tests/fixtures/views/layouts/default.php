<?php echo $this->Doctype()->set("XHTML1_STRICT"); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php $this->load('/modules/head'); ?>
<body>
<?php $this->load('/modules/header'); ?>

<main>
    <?php $this->render("content"); ?>
</main>

<?php $this->load('/modules/footer'); ?>
</body>
</html>