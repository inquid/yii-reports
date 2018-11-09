namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class TermicTicket extends Widget
{

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $this->view->layout = 'print-layout';
        $ticket = new TicketPrint();
        $ticket->title = Yii::$app->name;
        $ticket->beforeData = [
            ['title' => 'Title1 ', 'value' => " Value1"],
            ['title' => 'Title2 ', 'value' => " Value2"],
            ['title' => 'Title3 ', 'value' => " Value3"]
        ];
        $ticket->tableHeaders = ['Column1', 'Column2'];
        $ticket->tableData = [['Value', 'Value'],['Value', 'Value']];
        $ticket->postData
            = 'TEXT POST DATA';
        return $this->render('ticket_view', ['title' => 'Title', 'manual_print' => true, 'ticket' => $ticket]);
    }
}
