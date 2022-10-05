<?php
/**
 * PH35 課題02
 * PH35 Sample10 マスタテーブル管理完版
 *
 * @author Shuka NAGAI
 *
 * ファイル名=showEmpList.php
 * フォルダ=/ph35/scottadmin/classes/entity/
 */
namespace App\Entity;

 class Emp {
    /**
      * ID
      */
    private ?int $id = null;

    /**
      * 従業員番号
      */
    private ?int $emNo = null;

    /**
      * 従業員名
      */
    private ?string $emName = "";

    /**
     *  役職
     */
    private ?string $emJob = "";

    /**
     * 上司番号
     */
    private ?int $emMgr = null;

    /**
     * 雇用日
     */
    private ?string $emHiredate = "";

    /**
     * 給与
     */
    private ?int $emSal = null;

    /**
     * 所属部門ID
     */
    private ?int $deptId = null;


    // 以下アクセスメソッド
    public function getId(): ?int {
        return $this->id;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getEmNo(): ?int {
        return $this->emNo;
    }
    public function setEmNo(int $emNo): void {
        $this->emNo = $emNo;
    }

    public function getEmName(): ?string {
        return $this->emName;
    }
    public function setEmName(?string $emName): void {
        $this->emName = $emName;
    }

    public function getEmJob(): ?string {
        return $this->emJob;
    }
    public function setEmJob(?string $emJob): void {
        $this->emJob = $emJob;
    }

    public function getEmMgr(): ?int {
        return $this->emMgr;
    }
    public function setEmMgr(int $emMgr): void {
        $this->emMgr = $emMgr;
    }

    public function getEmHiredate(): ?string {
        return $this->emHiredate;
    }
    public function setEmHiredate(string $emHiredate): void {
        $this->emHiredate = $emHiredate;
    }

    public function getEmHiredateYear(): ?int {
        $year = explode("-" , $this->getEmHiredate());
        return (int) $year[0];
    }
    public function getEmHiredateMonth(): ?int {
        $month = explode("-" , $this->getEmHiredate());
        if(count($month) == 3){
            return (int) $month[1];
        }
        else{
            return 0;
        }
        
    }
    public function getEmHiredateDay(): ?int {
        $day = explode("-" , $this->getEmHiredate());
        if(count($day) == 3){
            return (int) $day[2];
        }
        else{
            return 0;
        }
    }
    public function getEmSal(): ?int {
        return $this->emSal;
    }
    public function setEmSal(int $emSal): void {
        $this->emSal = $emSal;
    }

    public function getDeptId(): ?int {
        return $this->deptId;
    }
    public function setDeptId(?int $deptId): void {
        $this->deptId = $deptId;
    }
 }