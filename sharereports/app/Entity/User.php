<?php
/**
 * PH35 Sample13 マスタテーブル管理ミドルウェア版 Src07/19
 *
 * @author Shinzo SAITO
 *
 * ファイル名=User.php
 * フォルダ=/sharereports/app/Entity/
 */
namespace App\Entity;

/**
 *ユーザエンティティクラス。
 */
class User {
    /**
     * 主キーのid。
     */
    private ?int $id = null;
    /**
     * メールアドレス。
     */
    private ?string $usMail = "";
    /**
     * 名前
     */
    private ?string $usName = "";
    /**
     * パスワード。
     */
    private ?string $usPasswd = "";
    /**
     * 認証番号。
     */
    private ?int $usAuth = null;
    
    //以下アクセサメソッド。

    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function getUsMail(): ?string {
        return $this->usMail;
    }
    public function setUsMail(?string $mail): void {
        $this->usMail = $mail;
    }
    public function getUsName(): ?string {
        return $this->usName;
    }
    public function setUsName(?string $name): void {
        $this->usName = $name;
    }
    public function getUsPasswd(): ?string {
        return $this->usPasswd;
    }
    public function setUsPasswd(?string $passwd): void {
        $this->usPasswd = $passwd;
    }
    public function getUsAuth(): ?int {
        return $this->usAuth;
    }
    public function setUsAuth(?int $auth): void {
        $this->usAuth = $auth;
    }
}