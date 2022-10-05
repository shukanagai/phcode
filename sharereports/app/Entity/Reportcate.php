<?php
/**
 *
 * @author Shuka nagai
 *
 * ファイル名=Reportcate.php
 * フォルダ=/sharereports/app/Entity/
 */
namespace App\Entity;

/**
 *ユーザエンティティクラス。
 */
class Reportcate {
    /**
     * 主キーのid。
     */
    private ?int $rcId = null;
    /**
     * 種類名。
     */
    private ?string $rcName = "";
    /**
     * 備考。
     */
    private ?string $rcNote = "";
    /**
     * リスト表示。
     */
    private ?int $rcListFlg = null;
    /**
     * 表示順序。
     */
    private ?string $rcOrder = "";
    
    //以下アクセサメソッド。

    public function getRcId(): ?int {
        return $this->id;
    }
    public function setRcId(?int $id): void {
        $this->id = $id;
    }
    public function getRcName(): ?string {
        return $this->rcName;
    }
    public function setRcName(string $name): void {
        $this->rcName = $name;
    }
    public function getRcNote(): ?string {
        return $this->rcNote;
    }
    public function setRcNote(string $note): void {
        $this->rcNote = $note;
    }
    public function getRcListFlg(): ?int {
        return $this->rcListFlg;
    }
    public function setRcListFlg(?int $flg): void {
        $this->rcListFlg = $flg;
    }
    public function getRcOrder(): ?int {
        return $this->rcOrder;
    }
    public function setRcOrder(?int $order): void {
        $this->rcOrder = $order;
    }

}