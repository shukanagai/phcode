<?php
/**
 * PH35 Sample12 マスタテーブル管理Laravel版 Src04/17
 *
 * @author Shinzo SAITO
 *
 * ファイル名=Dept.php
 * フォルダ=/scottadminlaravel/app/Entity/
 */
namespace App\Entity;

/**
 *部門エンティティクラス。
 */
class Dept {
    /**
     * ID。
     */
    private ?int $id = null;
    /**
     * 部門番号。
     */
    private ?int $dpNo = null;
    /**
     * 部門名。
     */
    private ?string $dpName = "";
    /**
     * 所在地
     */
    private ?string $dpLoc = "";

    //以下アクセサメソッド。

    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function getDpNo(): ?int {
        return $this->dpNo;
    }
    public function setDpNo(?int $dpNo): void {
        $this->dpNo = $dpNo;
    }
    public function getDpName(): ?string{
        return $this->dpName;
    }
    public function setDpName(?string $dpName): void {
        $this->dpName = $dpName;
    }
    public function getDpLoc(): ?string{
        return $this->dpLoc;
    }
    public function setDpLoc(?string $dpLoc): void {
        $this->dpLoc = $dpLoc;
    }
}