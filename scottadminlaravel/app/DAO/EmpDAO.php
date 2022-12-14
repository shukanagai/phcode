<?php
/**
 *
 * @author Shuka NAGAI
 *
 * ファイル名=EmpDAO.php
 * フォルダ=/scottadminlaravel/app/DAO/
 */

namespace App\DAO;

use PDO;
use App\Entity\Emp;

class EmpDAO {
    /**
     * @var PDO DB接続オブジェクト
     */
    private $db;

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
     * 主キーidによる検索
     * 
     * @param integer $id 主キーであるid
     * @return Dept 該当するEmpオブジェクト。ただし、該当データがない場合はnull
     */
    public function findByPK(int $id): ?Emp {
       $sql = "SELECT * FROM emps WHERE id = :id";
       $stmt = $this->db->prepare($sql);
       $stmt->bindValue(":id", $id, PDO::PARAM_INT);
       $result = $stmt->execute();
       $dept = null;
       if($result && $row = $stmt->fetch()) {
            $idDb = $row["id"];
            $emNo = $row["em_no"];
            $emName = $row["em_name"];
            $emJob = $row["em_job"];
            $emMgr = $row["em_mgr"];
            $emHiredate = $row["em_hiredate"];
            $emSal = $row["em_sal"];
            $deptId = $row["dept_id"];

            $emp = new Emp();
            $emp->setId($idDb);
            $emp->setEmNo($emNo);
            $emp->setEmName($emName);
            $emp->setEmJob($emJob);
            $emp->setEmMgr($emMgr);
            $emp->setEmHiredate($emHiredate);
            $emp->setEmSal($emSal);
            $emp->setDeptId($deptId);
       }
       return $emp;
    }

    /**
     * 部門番号による検索
     * 
     * @param integer $dpNo 主キーであるid。
     * @return Emp 該当するempオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByEmNo(int $emNo): ?Emp {
        $sql = "SELECT * FROM emps WHERE em_no = :em_no";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":em_no", $emNo, PDO::PARAM_INT);
        $result = $stmt->execute();
        $emp = null;
        if($result && $row = $stmt->fetch()) {
            $id = $row['id'];
            $emNoDB = $row["em_no"];
            $emName = $row["em_name"];
            $emJob = $row["em_job"];
            $emMgr = $row["em_mgr"];
            $emHiredate = $row["em_hiredate"];
            $emSal = $row["em_sal"];
            $deptId = $row["dept_id"];

            $emp = new Emp();
            $emp->setId($id);
            $emp->setEmNo($emNoDB);
            $emp->setEmName($emName);
            $emp->setEmJob($emJob);
            $emp->setEmMgr($emMgr);
            $emp->setEmHiredate($emHiredate);
            $emp->setEmSal($emSal);
            $emp->setDeptId($deptId);
        }
        return $emp;
    }

    /**
     * 全従業員情報検索。
     * 
     * @return array 全従業員情報が格納された連想配列。キーは従業員番号、値はEmpエンティティオブジェクト。
     */
    public function findAll(): array {
        $sql = "SELECT * FROM emps ORDER BY em_no";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $deptList = [];
        while($row = $stmt->fetch()) {
            $id = $row["id"];
            $emNo = $row["em_no"];
            $emName = $row["em_name"];
            $emJob = $row["em_job"];
            $emMgr = $row["em_mgr"];
            $emHiredate = $row["em_hiredate"];
            $emSal = $row["em_sal"];
            $deptId = $row["dept_id"];

            $emp = new Emp();
            $emp->setId($id);
            $emp->setEmNo($emNo);
            $emp->setEmName($emName);
            $emp->setEmJob($emJob);
            $emp->setEmMgr($emMgr);
            $emp->setEmHiredate($emHiredate);
            $emp->setEmSal($emSal);
            $emp->setDeptId($deptId);
            $empList[$id] = $emp;
        }
        return $empList;
    }

    /**
     * 従業員情報登録。
     * 
     * @param Emp $dept 登録情報が格納されたEmpオブジェクト。
     * @return integer 登録情報の連番主キーの値。登録に失敗した場合は-1。
     */
    public function insert(Emp $emp): int {
        $sqlInsert = "INSERT INTO emps (em_no, em_name, em_job, em_mgr, em_hiredate, em_sal, dept_id) VALUES (:em_no, :em_name, :em_job, :em_mgr, :em_hiredate, :em_sal, :dept_id)";
        $stmt = $this->db->prepare($sqlInsert);
        $stmt->bindValue(":em_no", $emp->getEmNo(), PDO::PARAM_INT);
        $stmt->bindValue(":em_name", $emp->getEmName(), PDO::PARAM_STR);
        $stmt->bindValue(":em_job", $emp->getEmJob(), PDO::PARAM_STR);
        $stmt->bindValue(":em_mgr", $emp->getEmMgr(), PDO::PARAM_INT);
        $stmt->bindValue(":em_hiredate", $emp->getEmHiredate(), PDO::PARAM_STR);
        $stmt->bindValue(":em_sal", $emp->getEmSal(), PDO::PARAM_INT);
        $stmt->bindValue(":dept_id", $emp->getDeptId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        if($result) {
            $EmId = $this->db->lastInsertId();
        }
        else {
            $EmId = -1;
        }
        return $EmId;
    }

    /**
     * 従業員情報更新。更新対象は1レコードのみ。
     * 
     * @param Emp $emp更新情報が格納されたDeptオブジェクト。主キーがこのオブジェクトのidの値のレコードを更新する。
     * @return boolean 登録が成功したかどうかを表す値
     */
    public function update(Emp $emp): bool {
        $sqlUpdate = "UPDATE emps SET em_no = :em_no, em_name = :em_name, em_job = :em_job, em_mgr = :em_mgr, em_hiredate = :em_hiredate, em_sal = :em_sal, dept_id = :dept_id WHERE id = :id";
        $stmt = $this->db->prepare($sqlUpdate);
        $stmt->bindValue(":em_no", $emp->getEmNo(), PDO::PARAM_INT);
        $stmt->bindValue(":em_name", $emp->getEmName(), PDO::PARAM_STR);
        $stmt->bindValue(":em_job", $emp->getEmJob(), PDO::PARAM_STR);
        $stmt->bindValue(":em_mgr", $emp->getEmMgr(), PDO::PARAM_INT);
        $stmt->bindValue(":em_hiredate", $emp->getEmHiredate(), PDO::PARAM_STR);
        $stmt->bindValue(":em_sal", $emp->getEmSal(), PDO::PARAM_INT);
        $stmt->bindValue(":dept_id", $emp->getDeptId(), PDO::PARAM_INT);
        $stmt->bindValue(":id", $emp->getId(), PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * 従業員情報削除。削除対象は1レコードのみ。
     *
     * @param integer $id 削除対象の主キー。
     * @return boolean 登録が成功したかどうかを表す値。
     */
     public function delete(int $id): bool {
        $sql = "DELETE FROM emps WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

} 