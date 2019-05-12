<?php
namespace App\Controller;
use App\Controller\BaseController;

class TopicController extends BaseController{

    public function __construct(){}
        
    private static $now = 'http://www.lideshuai.cn/baidu/now';
    private static $today = 'http://www.lideshuai.cn/baidu/today';
    private static $seven = 'http://www.lideshuai.cn/baidu/seven';

    private static $number = 10;

    private $lists;

	public function now()
	{
        $page = input('get.page', 1);
        $lists = $this->doRequest(static::$now);
        $lists = $this->setData($lists)
            ->jsonDecode()
            ->arrToStr()
            ->sortArr()
            ->getPage($page)
            ->jsonEncode()
            ->getData()
        ;
		$this->returnJson($lists);
	}

    public function today()
    {
        $page = input('get.page', 1);
        $lists = $this->doRequest(static::$today);
        $lists = $this->setData($lists)
            ->jsonDecode()
            ->arrToStr()
            ->sortArr()
            ->getPage($page)
            ->jsonEncode()
            ->getData()
        ;
		$this->returnJson($lists);
	}

    public function seven()
    {
        $page = input('get.page', 1);
        $lists = $this->doRequest(static::$seven);
        $lists = $this->setData($lists)
            ->jsonDecode()
            ->arrToStr()
            ->sortArr()
            ->getPage($page)
            ->jsonEncode()
            ->getData()
        ;
		$this->returnJson($lists);
    }

    private function setData($lists): self
    {
        $this->lists = $lists;
        return $this;
    }

    private function jsonDecode(): self
    {
        $this->lists = json_decode($this->lists, true);
        return $this;
    }

    private function arrToStr(): self
    {
        foreach ($this->lists as $key => $value) {
            $this->lists[$key] = array(
                'rank' => $value['rank'][0],
                'link' => $value['link'][0],
                'title' => $value['title'][0],
                'num' => $value['num'][0],
            );
        }
        return $this;
    }

    private function sortArr(): self
    {
        $lists = $this->lists;
        for ($i = count($lists) - 1; $i > 0; $i--) {
            for ($j = 0; $j < $i; $j++) {
                if ((int)$lists[$j]['rank'] > (int)$lists[$j + 1]['rank']) {
                    $tmp = $lists[$j];
                    $lists[$j] = $lists[$j + 1];
                    $lists[$j + 1] = $tmp;
                }
            }
        }
        $this->lists = $lists;
        return $this;
    }

    private function getPage($page = 1): self
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
