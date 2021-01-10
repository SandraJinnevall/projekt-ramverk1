<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>
<h1>Välkommen till QandA!</h1>
<h4>Tema: Allt om kameror och fotografering</h4>

<h3>Nyaste frågorna</h3>
<table>
    <?php foreach ($questions as $question) : ?>
    <tr>
        <td class="startpage-question">
            <?php $parsedtitle = $filter->parse($question->title, ["shortcode", "markdown"]); ?>
            <a href="displayquestion/<?=$question->questionid?>"><?= $parsedtitle->text ?></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!$questions) { ?>
<p> Finns inga frågor än. </p>
    <?php
}
?>


<h3>Mest populära taggarna</h3>
<table>
    <?php foreach ($tags as $t) : ?>
    <tr>
        <td class="startpage-question">
            <a href="displayquestionswithtag/<?= $t->tagid ?>"><p>(<?= $t->reputation ?>) <?= $t->tag ?></p></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!$tags) { ?>
<p> Finns inga taggar än. </p>
    <?php
}
?>

<h3>Mest aktiva användare</h3>
<table>
    <?php foreach ($user as $u) : ?>
    <tr>
        <td class="startpage-question">
            <a href="user/displayuser/<?= $u->id ?>"><p>(<?= $u->reputation ?>) <?= $u->displayname ?></p></a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php if (!$user) { ?>
<p> Finns inga användare än. </p>
    <?php
}
?>
