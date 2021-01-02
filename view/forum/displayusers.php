<h1>Alla Användare</h1>
<?php if (!$users) { ?>
<p> Finns inga användare än. </p>
    <?php
}
?>
<div class="" style="width:100%;height:180px;margin:auto;">
    <?php foreach ($users as $u) : ?>
        <div class="" style="width:15%;height:180px;float:left;">
            <img style="width:80px;" src="<?= $u->img ?>" alt="Finns ingen bild">
        </div>
        <div class="user-link" style="margin-left: 15%;height: 180px;">
            <a class="" href="displayuser/<?= $u->id ?>"><?= $u->displayname ?></a>
            <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Senast inloggad <?= $u->active ?></p>
            <p style="font-style: oblique;margin-top:2px;margin-bottom:2px;">Rykte [<?= $u->reputation ?>]</p>
        </div>
    <?php endforeach; ?>
</div>
