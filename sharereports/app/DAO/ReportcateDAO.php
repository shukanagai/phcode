<?php
/**
 *
 * @author Shuka Nagai
 *
 * ファイル名=ReportcateDAO.php
 * フォルダ=/sharerepots/app/DAO/
 */
namespace App\DAO;

use PDO;
use App\Entity\reportcate;

/**
 * usersテーブルへのデータ操作クラス。
 */
class ReportcateDAO {
    /**
     * @var PDO DB接続オブジェクト
     */
    private PDO $db;

    /**
     * コンストラクタ
     *
     * @param PDO $db DB接続オブジェクト
     */
    public function __construct(PDO $db) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db = $db;
    }

    /**
     * 全作業種類情報検索。
     *
     */
    public function findAll(): array {
        $sql = "SELECT * FROM reportcates ORDER BY rc_order";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $reportcateList = [];
        while($row = $stmt->fetch()) {
            $id = $row["id"];
            $rcNote = $row["rc_note"];
            $rcName = $row["rc_name"];
            $rcList = $row["rc_list_flg"];
            $rcOrder = $row["rc_order"];
    
            $reportcate = new Reportcate();
            $reportcate->setRcId($id);
            $reportcate->setRcNote($rcNote);
            $reportcate->setRcName($rcName);
            $reportcate->setRcListFlg($rcList);
            $reportcate->setRcOrder($rcOrder);
            $reportcateList[$id] = $reportcate;
        }
        return $reportcateList;
    }

    
}