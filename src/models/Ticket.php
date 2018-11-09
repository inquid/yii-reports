<?php
namespace inquid\yiireports\models;

use yii\base\Model;

class Ticket extends Model
{
    public $title;
    public $beforeData = [];
    public $tableHeaders = [];
    public $tableData = [];
    public $postData;
}
