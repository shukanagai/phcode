<?php
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=UserDAO.php
 * フォルダ=/sharerepots/app/DAO/
 */
namespace App\DAO;

use PDO;
use App\Entity\User;

/**
 * usersテーブルへのデータ操作クラス。
 */
class UserDAO {
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
     * メアドによる検索。
     *
     * @param string $loginMail ログインメール。
     * @return User 該当するUserオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByLoginMail(string $loginMail): ?User {
        $sql = "SELECT * FROM users WHERE us_mail = :us_mail";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":us_mail", $loginMail, PDO::PARAM_INT);
        $result = $stmt->execute();
        $user = null;
        if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $usMail = $row["us_mail"];
            $usName = $row["us_name"];
            $passwd = $row["us_password"];
            $usAuth = $row["us_auth"];

            $user = new User();
            $user->setId($id);
            $user->setUSMail($usMail);
            $user->setUsName($usName);
            $user->setUsPasswd($passwd);
            $user->setUsAuth($usAuth);
        }
        return $user;
    }

    /**
     * reportのuser_IDによる検索。
     *
     * @param string $loginMail ログインメール。
     * @return User 該当するUserオブジェクト。ただし、該当データがない場合はnull。
     */
    public function findByLoginId(int $Id): ?User {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $Id, PDO::PARAM_INT);
        $result = $stmt->execute();
        $user = null;
        if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $id = $row["id"];
            $usMail = $row["us_mail"];
            $usName = $row["us_name"];
            $passwd = $row["us_password"];
            $usAuth = $row["us_auth"];

            $user = new User();
            $user->setId($id);
            $user->setUsMail($usMail);
            $user->setUsName($usName);
            $user->setUsPasswd($passwd);
            $user->setUsAuth($usAuth);
        }
        return $user;
    }

    /**
     * レポート情報検索。
     *
     * @return array 全部門情報が格納された連想配列。キーは部門番号、値はDeptエンティティオブジェクト。
     */
    public function findAll(): array {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute();
        $userList = [];
        while($row = $stmt->fetch()) {
            $id = $row["id"];
            $usMail = $row["us_mail"];
            $usName = $row["us_name"];
            $passwd = $row["us_password"];
            $usAuth = $row["us_auth"];

            $user = new User();
            $user->setId($id);
            $user->setUsMail($usMail);
            $user->setUsName($usName);
            $user->setUsPasswd($passwd);
            $user->setUsAuth($usAuth);
            $userList[$id] = $user;
        }
        return $userList;
    }
}
