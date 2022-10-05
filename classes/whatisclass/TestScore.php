<?php
/**
PH35 サンプル1　クラスの復習 src2/7
クラスとは
クラス記述ファイル

*@author Shinzo SAITO

ファイル名=TestScore.php
フォルダ=/ph35/classes/whatisclass
*/

// テストの特典を表すクラス

class TestScore {
    // @var string 生徒名
    public string $name = "";

    /**
     * @var integer 英語の点数
    */
    public int $english = 0;

    /**
     * @var integer 数学の点数
    */
    public int $math = 0;

    /**
     * @var integer 国語の点数
     */
    public int $japanese = 0;

    /**
    プロパティにまとめてデータをセットするメソッド。
    *@param string $name 生徒名。¬37
    *@param integer $english 英語の点数。¬38
    *@param integer $math 数学の点数。¬39
    *@param integer $japanese 国語の点数。
    */

    public function setData(string $name , int $english , int $math , int $japanese): void{
        $this->name = $name;
        $this->english = $english;
        $this->math = $math;
        $this->japanese = $japanese;
    }

    /**
     * 英数国3教科の合計を計算するメソッド
     * @return integer 3教科の合計点
     */

    public function getSum(): int {
        return $this->english + $this->math + $this->japanese;
    }

    /**
    *英数国3教科の平均を計算するメソッド。
    *@return float 3教科の平均点。小数点以下1桁の数値に四捨五入されている。
    */

    public function getAve(): float {
        $ave = $this->getSum() / 3;
        $ave = round($ave, 1);
        return $ave;    
    }

}