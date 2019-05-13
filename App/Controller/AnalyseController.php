<?php
namespace App\Controller;
use App\Controller\BaseController;

class AnalyseController extends BaseController{

    public function __construct(){}

    private static $sentence = 'http://www.lideshuai.cnqaw/analysis/sentence?s=';
    private static $words = 'http://www.lideshuai.cn/analysis/best/word?s=';
    private static $fileWords = 'www.lideshuai.cn/analysis/best/file?file=';
    private static $file = 'www.lideshuai.cn/analysis/bayes?file=';

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
        $filepath = input('get.file');
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
            ->signToNothing()
            ->getKeyWords()
            ->jsonEncode()
            ->getData()
        ;
        $this->returnJson($rst);
	}

    public function words()
    {
        // $lists = $this->doRequest(static::$fileWords . '/root/CNC/Analysis/data/title.CSV');
        // $lists = json_decode($lists, true)['result'];
        // $lists = array_slice($lists, 0, 50);
        // $lists = json_encode($lists);
        $lists = '["\u9ece\u5eb6","\u65f6\u5019","\u8d54\u507f\u6807\u51c6","\u6587\u827a\u754c","\u4eba\u53e3\u8001\u9f84\u5316","\u4eba\u8d29\u5b50","\u5efa\u8bae","\u519c\u6751","\u6709\u620f","\u4e0b\u5c97\u5de5\u4eba","\u53f0\u80de","\u76db\u4f1a","\u8001\u9f84\u5316","\u9ad8\u804c","\u8425\u5546","\u6d88\u606f","\u5355\u65b9","\u5b9e\u4f53","\u6c11\u751f","\u4e61\u9547","\u533b\u7597\u6cd5","\u4eba\u5de5\u667a\u80fd","\u5957\u82b1","\u9a7e\u6821","\u6c11\u751f","\u62a5\u544a","\u8001\u8d56","\u4eba\u5de5\u667a\u80fd","\u8272\u5f31","\u4e8c\u9662","\u533a\u5757","\u70ed\u70b9\u8bdd\u9898","\u836f\u54c1","\u4e61\u6751","\u95ee\u9898","\u6770\u51fa\u4eba\u624d","\u53d1\u529b","\u8cea\u91cf","\u5f81\u7a0b","\u5c0f\u8c79","\u5de1\u793c","\u9886\u822a","\u5171\u521b","\u5927\u901a\u9053","\u70ed\u8bcd","\u70ed\u8bcd","\u4e2d\u5916\u8bb0\u8005","\u96be\u9898","\u7fa4\u4f17","\u9ad8\u8d28\u91cf"]';
        $this->returnJson($lists);
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
        $analyseDb = model('analyse');
        $rst = $analyseDb->getReply($query);
        $rst = $this->setData($rst)
            ->setPage($page)
            ->getKeywords()
            ->jsonEncode()
            ->getData()
        ;
        $this->returnJson($rst);
        
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

    private function signToNothing(): self
    {
        $lists = $this->lists;
        for ($i = 0, $len = count($lists); $i< $len; $i++) {
            $lists[$i]['replyContent'] = str_replace('[,}]', '', $lists[$i]['replyContent']);
        }
        $this->lists = $lists;
        return $this;
    }

    private function getKeywords(): self
    {
        $lists = $this->lists;
        for ($i = 0, $len = count($lists); $i < $len; $i++) {
            $lists[$i]['keywords'] = json_decode($this->doRequest(static::$words . $lists[$i]['replyContent']), true)['result'];
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
