<?php
namespace App\Controller;
use App\Controller\BaseController;

class AnalyseController extends BaseController{

    public function __construct(){}

    private static $sentence = 'http://www.lideshuai.cn/analysis/sentence?s=';
    private static $words = 'http://www.lideshuai.cn/analysis/best/word?s=';

    private static $number = 10;

    private $lists;

    public function sentence()
    {
        $sentence = input('get.sentence', '');
        $result = json_decode($this->doRequest(static::$sentence . $sentence), true);
        $keywords = json_decode($this->doRequest(static::$words . $sentence), true);
        $rst = array(
            'result' => $result['positive'] > $result['negative'] ? 1 : 0,
            'positive' => $result['positive'],
            'negative' => $result['negative'],
            'keyword' => $keywords['result'],
        );
        $this->returnJson(json_encode($rst));
    }

    public function file()
    {

    }

	public function topic()
	{
        $page = input('get.page', 1);
        $query = input('get.query', '');
        $query = $this->encodeQuery($query);
        $analyseDb = model('analyse');
        $rst = $analyseDb->getContents($query);
        $rst = $this->setData($rst)
            ->setPage($page)
            ->toPercent()
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
        date_default_timezone_set('PRC');
        $hour = (int)date('H');
        $min = (int)date('i');
        $min = $min > 30 ? 1 : 0;
        $arr = array();
        for ($i = 0; $i < 10; $i++) {
            $arr[] = array(
                'time' => ($hour < 10 ? '0' . $hour : $hour) . ':' . ($min * 30 < 10 ? '0' . $min * 30 : $min * 30),
                'value' => '' . mt_rand(6, 20),
                'min' => '0',
                'max' => '0',
            );
            $min = 1 - $min;
            $hour = $hour - $min;
            if ($hour < 0) {
                $hour = 24;
            }
        }
        $min = 0;
        $max = 0;
        for ($i = 1; $i < 10; $i++) {
            if ($arr[$i]['value'] < $arr[$min]['value']) {
                $min = $i;
            }
            if ($arr[$i]['value'] > $arr[$max]['value']) {
                $max = $i;
            }
        }
        $arr[$min]['min'] = '1';
        $arr[$max]['max'] = '1';
        $this->returnJson(json_encode($arr));
    }

    public function comments()
    {
        $page = input('get.page', 1);
        $query = input('get.query', 1);
        $query = $this->encodeQuery($query);
        
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

    private function toPercent(): self
    {
        $lists = $this->lists;
        for ($i = 0, $len = count($lists); $i < $len; $i++) {
            if ((int)$lists[$i]['positive'] + (int)$lists[$i]['negative'] == 0) {
                $lists[$i]['positive'] = '50';
                $lists[$i]['negative'] = '50';
            } else {
                $lists[$i]['positive'] = (int)(((int)$lists[$i]['positive'] / ((int)$lists[$i]['positive'] + (int)$lists[$i]['negative'])) * 100);
                $lists[$i]['negative'] = 100 - $lists[$i]['positive'];
            }
            $lists[$i]['positive'] .= '%';
            $lists[$i]['negative'] .= '%';
        }
        $this->lists = $lists;
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
