<h1>Taggar</h1>
<?php if ($loggedin) {?>
    <form class="create-question" style="padding-top: 5px;" method="POST" action="tags">
        <input name="tag" placeholder="Skapa en ny tagg" required>
        <button type="submit">Skicka</button>
    </form>
    <?php
}
?>
<?php if ($message) {?>
<p> <?= $message ?> </p>
    <?php
}
?>
<?php foreach ($tags as $t) : ?>
<p class="startpage-question"><a href="displayquestionswithtag/<?= $t->tagid ?>"><?= $t->tag ?></a><p>
<?php endforeach; ?>

<?php if (!$tags) { ?>
<p> Finns inga taggar än. </p>
    <?php
}
?>
