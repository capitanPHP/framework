<?php
namespace capitan\database\rdbms\mysql;
use PDO;
use capitan\Main;
class Sql extends PDO
{
    use Conditional,Write,Read,Delete,Table,Helpers;
    protected $inis =[];
    protected $table ='';
    protected $field ='*';
    protected $order ='';
    protected $statement =[];
    protected $comparisonOperator =[
        'EQ' =>'=',
        'NEQ' =>'<>',
        'GT' =>'>',
        'GEQ' =>'>=',
        'LT' =>'<',
        'LEQ' =>'<=',
        'NOT' =>'!=',
        'BETWEEN' =>'BETWEEN',
        'NOT BETWEEN' =>'NOT BETWEEN',
        'IN' =>'IN',
        'NOT IN' =>'NOT IN',
        'LIKE' =>'LIKE',
        'NOT LIKE' =>'NOT LIKE',
        'IS' =>'IS',
        'IS NOT' =>'IS NOT'
    ];
    public function __construct()
    {
        try {
            $this->inis = (new Main)->getIniFile('database')['RDBMS']['mysql'];
            extract($this->inis);
           
            parent::__construct("mysql:host=$host;dbname=$dbname", $username, $password);
           
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
            $this->exec("SET NAMES $charset");
        } catch (PDOException $e) {
           
            die("Connection failed: " . $e->getMessage());
        }
    }
}