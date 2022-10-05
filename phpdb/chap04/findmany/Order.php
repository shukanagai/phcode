<?php
/**
 * PH35 サンプル2 PHP DB Access Src13/14
 * Ch4-2 エンティティクラスその2。
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Order.php
 * フォルダ=/ph35/phpdb/findmany/
 */

/**
 * managementsテーブルに対応するエンティティクラス。
 */
class Order {
    /**
     * @var integer 部門ID。
     */
    private ?int $departmentId = null;
    /**
     * @var string 部門名。
     */
    private ?string $departmentName = "";
    /**
     * @var int 管理者ID。
     */
    private ?int $managerId = "";
    /**
     * @var integer 所在地ID。
     */
    private ?int $locationId = null;

    
    //以下アクセサメソッド。

    // 部門ID
    public function getDepartmentId(): ?int {
        return $this->departmentId;
    }
    public function setOrderId(?int $departmentId): void {
        $this->departmentId = $departmentId;
    }

    // 部門名
    public function getDepartmentName(): ?string {
        return $this->departmentName;
    }
    public function setDepartmentName(?string $departmentName): void {
        $this->departmentName = $departmentName;
    }

    // 管理者ID
    public function getManagerId(): ?int {
        return $this->managerId;
    }
    public function setManagerId(?int $managerId): void {
        $this->managerId = $managerId;
    }

    // 所在地ID
    public function getLocationId(): ?int {
        return $this->locationId;
    }
    public function setLocationId(?int $locationId): void {
        $this->locationId = $locationId;
    }
}