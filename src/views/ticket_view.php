<?php
/**
 * Created by PhpStorm.
 * User: gogl92
 * Date: 1/10/18
 * Time: 02:07 AM
 */

/** @var boolean $manual_print */
if ($manual_print) {
    $this->registerJs('
window.print();
(function() {
    var beforePrint = function() {
        console.log(\'Functionality to run before printing.\');
    };
    var afterPrint = function() {
        console.log(\'Functionality to run after printing\');
          //window.close();
    };
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia(\'print\');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) {
                beforePrint();
            } else {
                afterPrint();
            }
        });
    }
    window.onbeforeprint = beforePrint;
    window.onafterprint = afterPrint;
}());
window.onafterprint = function(){
   console.log("Printing completed...");
  //window.close();
}', \yii\web\VIEW::POS_BEGIN);
} else {
    $this->registerJs('window.close();', \yii\web\View::POS_HEAD);
}

$this->title = $model->nombre;

?>
    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the initial value */
            margin: 4mm;  /* this affects the margin in the printer settings */
            font-size: 12px; !important;
            font-family: serif;
        }

        .ordenes-view {
            margin-top: 0;
        }

        .pagebreak {
            page-break-before: always;
        }

        /* page-break-after works, as well */
    </style>
    <div class="ordenes-view" style="font-size: 12px">
        ------------------------------------<br>
        <?= /** @var \app\modules\components\TicketPrint $ticket */
        $ticket->title ?><br>
        ------------------------------------<br>
        <?php foreach ($ticket->beforeData as $data): ?>
            <?= $data['title'] ?>: <?= $data['value']; ?><br>
        <?php endforeach; ?>
        ------------------------------------<br>
        <table style="font-size: 12px">
            <thead>
            <tr>
                <?php foreach ($ticket->tableHeaders as $data): ?>
                    <th align="left"><?= $data ?></th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ticket->tableData as $row): ?>
                <tr>
                    <?php foreach ($row as $column): ?>
                        <td align="center"><?= $column ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            <tr>

            </tr>
            </tbody>
        </table>
    </div>
<?php if (isset($ticket->postData)) : ?>
    <div class="pagebreak"></div>
    <div class="ordenes-view" style="font-size: 13px">
        <?= $ticket->postData ?>
    </div>
<?php endif;
