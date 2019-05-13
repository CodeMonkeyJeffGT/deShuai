<?php
namespace App\Model;
use \FF\Core\Model;

class AnalyseModel extends Model{

    public function getContents($query = '')
    {
		$sql = '
            SELECT `c`.`Id` `id`, `c`.`Title` `title`, `c`.`Replycount` `replycount`, sum(`rd`.`result`) `positive`, count(`rd`.`result`) - sum(`rd`.`result`) `negative`, GROUP_CONCAT(`r`.`Reply_Content`, "[,}]") `replyContent`
            FROM `content` `c`
            LEFT JOIN `reply` `r` ON `c`.`Id` = `r`.`Content_ID`
            LEFT JOIN `result_dict` `rd` ON `r`.`id` = `rd`.`id`
            WHERE `c`.`Title` LIKE "' . $query . '"
            GROUP BY `c`.`Id`
            ORDER BY `c`.`Replycount` DESC
            LIMIT 1000;
        ';
        $rst = $this->query($sql);
        return $rst;
    }

    public function getReply($query = '')
    {
		$sql = '
            SELECT `r`.`Reply_ID` `replyId`, `r`.`Reply_Level` `replyLevel`, `r`.`Reply_Content` `replyContent`, `rd`.`positive` `positive`, `rd`.`negative` `negative`, `r`.`Content_ID` `contentId`
            FROM `reply` `r`
            LEFT JOIN `result_dict` `rd` ON `r`.`id` = `rd`.`id`
            WHERE `r`.`Reply_Content` LIKE "' . $query . '"
                OR `r`.`Reply_ID` LIKE "' . $query . '"
            LIMIT 1000;
        ';
        $rst = $this->query($sql);
        return $rst;
    }
	
}