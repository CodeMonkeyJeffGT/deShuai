<?php
namespace App\Model;
use \FF\Core\Model;

class AnalyseModel extends Model{

    public function getContents($query = '') {
		$sql = '
            SELECT `c`.`Id` `id`, `c`.`Title` `title`, `c`.`Replycount` `replycount`, sum(`rd`.`result`) `positive`, count(`rd`.`result`) - sum(`rd`.`result`) `negative` 
            FROM `content` `c`
            LEFT JOIN `reply` `r` ON `c`.`Id` = `r`.`Content_Id`
            LEFT JOIN `result_dict` `rd` ON `r`.`id` = `rd`.`id`
            GROUP BY `c`.`Id`
            ORDER BY `c`.`Replycount` DESC
            LIMIT 1000;
        ';
        $rst = $this->query($sql);
        return $rst;
    }
	
}