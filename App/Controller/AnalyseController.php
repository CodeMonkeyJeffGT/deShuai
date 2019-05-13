<?php
namespace App\Controller;
use App\Controller\BaseController;

class AnalyseController extends BaseController{

    public function __construct(){}

    private static $number = 10;

    private $lists;

	public function topic()
	{
        $page = input('get.page', 1);
        $query = input('get.query', '');
        $query = $this->encodeQuery($query);
        $analyseDb = model('analyse');
        $rst = $analyseDb->getContents($query);
        $rst = $this->setData($rst)
            ->setPage($page)
            ->addHundred()
            ->jsonEncode()
            ->getData()
        ;
        $this->returnJson($rst);
	}

    public function words()
    {

    }
    
    public function hots()
    {

    }

    public function comments()
    {
        $page = input('get.page', 1);
        $query = input('get.query', 1);

    }

    private function encodeQuery($query): string
    {
        $query = '' . $query;
        if ($query !== '') {
            $arr = array();
            for ($i = 0, $len = mb_strlen($query); $i < $len; $i++)
            {
                $arr[] = mb_substr($query, $i, 1);
            }
            $query = '%' . implode('%', $arr) . '%';
        }
        if ($query === '') {
            $query = '%';
        }
        return $query;
    }

    private function setData($lists): self
    {
        $this->lists = $lists;
        return $this;
    }

    private function setPage($page = 1): self
    {
        $len = count($this->lists);
        if ($len < $page * static::$number) {
            $this->lists = array();
        }
        $min = ($page - 1) * static::$number;
        $left =  $len - $min;
        if ($left > static::$number) {
            $left = static::$number;
        }
        $this->lists = array_slice($this->lists, $min, $left);
        return $this;
    }

    private function addHundred(): self
    {
        $lists = $this->lists;
        for ($i = 0, $len = count($lists); $i < $len; $i++) {
            $lists[$i]['replycount'] = '' . ((int)$lists[$i]['replycount'] + 100);
        }
        $this->lists = $lists;
        return $this;
    }

    private function jsonEncode(): self
    {
        $this->lists = json_encode($this->lists, true);
        return $this;
    }
    
    private function getData()
    {
        return $this->lists;
    }
}
