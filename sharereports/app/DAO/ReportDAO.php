<?php
/**
 *
 * @author Shuka Nagai
 *
 * ファイル名=ReportDAO.php
 * フォルダ=/sharerepots/app/DAO/
 */
namespace App\DAO;

use PDO;
use App\Entity\User;
use App\Entity\Report;


/**
 * usersテーブルへのデータ操作クラス。
 */
class ReportDAO {
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
     * レポート情報検索。
     *
     * @return array 全部門情報が格納された連想配列。キーは部門番号、値はDeptエンティティオブジェクト。
     */
    public function findAll(): array {
        $sql = "SELECT * FROM reports ORDER BY rp_date DESC";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $reportList = [];
        while($row = $stmt->fetch()) {
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpTimeFrom = $row["rp_time_from"];
            $rpTimeTo = $row["rp_time_to"];
            $rpConnect = $row["rp_content"];
            $rpCreatedAt = $row["rp_created_at"];
            $rpreportcateId = $row["reportcate_id"];
            $userId = $row["user_id"];

            
    
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpTimeFrom($rpTimeFrom);
            $report->setRpTimeTo($rpTimeTo);
            $report->setRpContent($rpConnect);
            $report->setRpCreatedAt($rpCreatedAt);
            $report->setReportCateId($rpreportcateId);
            $report->setUserId($userId);
            $reportList[$id] = $report;
        }
        return $reportList;
    }

    /**
     * レポート情報登録。
     *
     * @param Report $report 登録情報が格納されたReportオブジェクト。
     * @return integer 登録情報の連番主キーの値。登録に失敗した場合は-1。
     */
    public function insert(Report $report): int {
        $sqlInsert = "INSERT INTO reports (rp_date, rp_time_from , rp_time_to , rp_content , rp_created_at , reportcate_id , user_id) VALUES (:rp_date, :rp_time_from , :rp_time_to , :rp_content , :rp_created_at , :reportcate_id , :user_id)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":rp_date", $report->getRpDate(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_time_from", $report->getRpTimeFrom(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_time_to", $report->getRpTimeTo(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_content", $report->getRpContent(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_created_at", date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(":reportcate_id", $report->getReportCateId(), PDO::PARAM_INT);
        $stmt->bindValue(":user_id", $report->getUserId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        if($result) {
            $Id = $this->db->lastInsertId();
        }
        else {
            $Id = -1;
        }
        return  $Id;
    }

    /**
     * 主キーidによる検索。
     *
     * @param integer $id 主キーであるid。
     * @return Report 該当するDeptオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByPK(int $id): ?Report {
        $sql = "SELECT * FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $dept = null;
        if($result && $row = $stmt->fetch()) {
            $id = $row["id"];
            $rpDate = $row["rp_date"];
            $rpTimeFrom = $row["rp_time_from"];
            $rpTimeTo = $row["rp_time_to"];
            $rpConnect = $row["rp_content"];
            $rpCreatedAt = $row["rp_created_at"];
            $rpreportcateId = $row["reportcate_id"];
            $userId = $row["user_id"];
    
            $report = new Report();
            $report->setId($id);
            $report->setRpDate($rpDate);
            $report->setRpTimeFrom($rpTimeFrom);
            $report->setRpTimeTo($rpTimeTo);
            $report->setRpContent($rpConnect);
            $report->setRpCreatedAt($rpCreatedAt);
            $report->setReportCateId($rpreportcateId);
            $report->setUserId($userId);
        }
        return $report;
    }
    /**
     * レポート情報更新。更新対象は1レコードのみ。
     *
     * @param Dept $dept 更新情報が格納されたDeptオブジェクト。主キーがこのオブジェクトのidの値のレコードを更新する。
  * @return boolean 登録が成功したかどうかを表す値。
     */
    public function update(report $report): bool {
        $sqlUpdate = "UPDATE reports SET rp_date = :rp_date, rp_time_from = :rp_time_from, rp_time_to = :rp_time_to, rp_content = :rp_content, reportcate_id = :reportcate_id WHERE id = :id";
        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bindValue(":id", $report->getId(), PDO::PARAM_INT);
        $stmt->bindValue(":rp_date", $report->getRpDate(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_time_from", $report->getRpTimeFrom(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_time_to", $report->getRpTimeTo(), PDO::PARAM_STR);
        $stmt->bindValue(":rp_content", $report->getRpContent(), PDO::PARAM_STR);
        $stmt->bindValue(":reportcate_id", $report->getReportCateId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * レポート情報削除。削除対象は1レコードのみ。
     *
     * @param integer $id 削除対象の主キー。
     * @return boolean 登録が成功したかどうかを表す値。
     */
    public function delete(int $id): bool {
        $sql = "DELETE FROM reports WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

}