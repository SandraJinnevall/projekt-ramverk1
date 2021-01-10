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
<table>
<?php foreach ($tags as $t) : ?>
<tr>
    <td class="startpage-question">
        <a href="displayquestionswithtag/<?= $t->tagid ?>"><p><?= $t->tag ?></p></a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?php if (!$tags) { ?>
<p> Finns inga taggar än. </p>
    <?php
}
?>
