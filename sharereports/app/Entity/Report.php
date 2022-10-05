<?php
/**
 *
 * @author Shuka Nagai
 *
 * ファイル名=Report.php
 * フォルダ=/sharereports/app/Entity/
 */
namespace App\Entity;

/**
 *ユーザエンティティクラス。
 */
class Report {
    /**
     * 主キーのid。
     */
    private ?int $id = null;
    /**
     * 作業日。
     */
    private ?string $rpDate = "";
    /**
     * 作業開始時間。
     */
    private ?string $rpTimeFrom = "";
    /**
     * 作業終了時間。
     */
    private ?string $rpTimeTo = "";
    /**
     * 作業内容。
     */
    private ?string $rpContent = "";
    /**
     * 登録日時。
     */
    private ?string $rpCreatedAt = "";
    /**
     * 作業種類ID。
     */
    private ?int $reportCateId = null;
    /**
     * 報告者ID。
     */
    private ?int $userId = null;
    
    //以下アクセサメソッド。

    public function getId(): ?int {
        return $this->id;
    }
    public function setId(?int $id): void {
        $this->id = $id;
    }
    public function getRpDate(): ?string {
        return $this->rpDate;
    }
    public function setRpDate(string $date): void {
        $this->rpDate = $date;
    }
    public function getRpDateYear(): ?int {
        $year = explode("-" , $this->getRpDate());
        return (int) $year[0];
    }
    public function getRpDateMonth(): ?int {
        $month = explode("-" , $this->getRpDate());
        if(count($month) == 3){
            return (int) $month[1];
        }
        else{
            return 0;
        } 
    }
    public function getRpDateDay(): ?int {
        $day = explode("-" , $this->getRpDate());
        if(count($day) == 3){
            return (int) $day[2];
        }
        else{
            return 0;
        }
    }
    public function getRpTimeFrom(): ?string {
        return $this->rpTimeFrom;
    }
    public function setRpTimeFrom(?string $timeFrom): void {
        $this->rpTimeFrom = $timeFrom;
    }
    public function getRpTimeTo(): ?string {
        return $this->rpTimeTo;
    }
    public function setRpTimeto(?string $timeTo): void {
        $this->rpTimeTo = $timeTo;
    }
    public function getRpContent(): ?string {
        return $this->rpConnect;
    }
    public function setRpContent(?string $connect): void {
        $this->rpConnect = $connect;
    }
    public function getRpCreatedAt(): ?string {
        return $this->rpCreatedAt;
    }
    public function setRpCreatedAt(string $createdAt): void {
        $this->rpCreatedAt = $createdAt;
    }
    public function getReportCateId(): ?int {
        return $this->reportCateId;
    }
    public function setReportCateId(int $reportCateId): void {
        $this->reportCateId = $reportCateId;
    }
    public function getUserId(): ?int {
        return $this->userId;
    }
    public function setUserId(?int $userId): void {
        $this->userId = $userId;
    }

    public function getTitle(): string {
        return mb_substr($this->rpContent , 0 ,10);
    }
}