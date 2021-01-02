<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>

<?php if ($loggedin) {?>
    <h1>Fråga en fråga</h1>

    <form class="create-question" method="POST" action="questions">
        <input type="text" name="title" placeholder="Rubrik" required>
        <textarea name="body" placeholder="Fråga en fråga med inriktning på kameror eller fotografering" required></textarea>
        <fieldset class="form-tag-list">
            <legend>Taggar</legend>
            <?php foreach ($tags as $t) { ?>
            <label class="form-tag">
                <input type="checkbox" name="tags[]" value="<?= $t->tag ?>">
                <span class="form-tag-label"><?= $t->tag ?></span>
                <br>
            </label>
            <?php }; ?>
        </fieldset>
        <button type="submit">Skicka</button>
    </form>

    <?php if ($message) { ?>
        <p> <?= $message ?> </p>
        <?php
    }
    ?>

    <?php
}
?>
<h1>Frågor</h1>
<?php if ($questions) { ?>
    <?php foreach ($questions as $question) : ?>
        <div style="border-left: 3px solid grey; padding-left: 8px; margin-bottom: 15px;">
            <?php $parsedtitle = $filter->parse($question->title, ["shortcode", "markdown"]); ?>
            <a class="questions-link" style="font-size: 23px;" href="displayquestion/<?=$question->questionid?>"><?= $parsedtitle->text ?></a>
            <p style="font-style: oblique; font-size: 14px;"> <?= $question->created ?> </p>
       </div>
    <?php endforeach; ?>
    <?php
}
?>


<?php if (!$questions) { ?>
<p> Finns inga frågor än. Var först med att fråga! </p>
    <?php
}
?>
