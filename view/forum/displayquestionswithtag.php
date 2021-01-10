<?php $filter   = new \Anax\TextFilter\TextFilter(); ?>
<?php foreach ($tags as $t) : ?>
    <h1> Frågor med taggen [<?= $t->tag ?>]</h1>
<?php endforeach; ?>

<?php if ($questionWithTag) { ?>
    <?php foreach ($questionWithTag as $qt) : ?>
        <div style="border-left: 3px solid grey; padding-left: 8px; margin-bottom: 15px;">
            <?php $parsedtitle = $filter->parse($qt->title, ["shortcode", "markdown"]); ?>
            <a class="questions-link" style="font-size: 23px;" href="../displayquestion/<?=$qt->questionid?>"><?= $parsedtitle->text ?></a></h4>
            <p style="font-style: oblique; font-size: 14px;"> <?= $qt->created ?> </p>
       </div>
    <?php endforeach; ?>
    <?php
}
?>

<?php if (!$questionWithTag) { ?>
<p> Finns inga frågor med denna taggen än! </p>
    <?php
}
?>
