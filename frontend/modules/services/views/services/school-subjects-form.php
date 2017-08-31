<?php

use common\models\StaticMethods;

/* @var $models common\models\Subjects */
?>

<?php
foreach ($models as $model):
    /**
     * @var common\models\Subjects subject
     */
    $rowsAndColumns[$model->level][$model->dept_name][$model->name][$model->class] = $model;
endforeach;
?>

<div class="files-form" style="height: 90%; overflow-x: hidden">

    <?php foreach ($rowsAndColumns as $level => $depts): ?>

        <?php foreach ($depts as $dept => $subjects): ?>

            <table>
                <tr><td colspan="2"><h3 style="margin-bottom: 0"><b><?= $dept ?></b></h3></td></tr>
            </table>

            <table>
                <?php foreach ($subjects as $name => $classes): ?>
                    <tr>
                        <td class="td-left" style="width: 40%"><b><?= $name ?></b></td>

                        <?php foreach ($classes as $class): ?>

                            <td class="td-pdg-vtc" style="width: <?= 60 / count($classes) ?>%">
                                <div class="btn btn-xs btn-<?= $class->active == common\models\Subjects::active ? 'success' : 'warning' ?>"
                                     lvl="<?= $class->level ?>" dpt="<?= $class->dept ?>" dpt_nm="<?= $class->dept_name ?>" cls="<?= $class->class ?>" sbj="<?= $class->subject ?>" cd="<?= $class->code ?>" nm="<?= $class->name ?>"
                                     onclick="pushSubject($(this))">
                                         <?= StaticMethods::schoolLevelClassTitle($level) . ' ' . StaticMethods::classes($level)[$class->class][StaticMethods::name] ?>
                                </div>
                            </td>

                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>

        <?php endforeach; ?>

    <?php endforeach; ?>

</div>

<div style="height: 10%; padding-top: 15px"><div class="btn btn-danger pull-right" onclick="closeDialog()">Close</div></div>