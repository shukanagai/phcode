<?php
/**
 *
 * @author Shinzo SAITO
 *
 * ファイル名=EmpController.php
 * フォルダ=/scottadminlaravel/app/Http/Controllers/
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions;
use App\Entity\Emp;
use App\DAO\EmpDAO;
use App\DAO\DeptDAO;
use App\Http\Controllers\Controller;


class EmpController extends Controller {
    /**
     * 従業員リスト画面表示処理。
     */
    public function showEmpList(Request $request) {
        $templatePath = "emp.empList";
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $empList = $empDAO->findAll();
            $assign["empList"] = $empList;
        }
        return view($templatePath, $assign);
    }

    /**
     * 従業員情報登録画面表示処理。
     */
    public function goEmpAdd(Request $request) {
        $templatePath = "emp.empAdd";
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $assign["emp"] = new Emp();

            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $empList = $empDAO->findAll();
            $assign["empList"] = $empList;
            $assign["deptList"] = $deptList;
        }
        return view($templatePath, $assign);
    }

    /**
     * 従業員情報登録処理。
     */
    public function empAdd(Request $request) {
        $templatePath = "emp.empAdd";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else{
            $addEmNo = $request->input('addEmNo');
            $addEmName = $request->input('addEmName');
            $addEmJob = $request->input("addEmJob");
            $addEmSal = $request->input("addEmSal");
            $addEmMgr = $request->input('addEmMgr');
            $addEmHiredateYear = $request->input("addEmHiredateYear");
            $addEmiredateMonth = $request->input("addEmHiredateMonth");
            $addEmiredateDay = $request->input("addEmHiredateDay");
            $addDpId = $request->input("addDpId");

            $emp = new Emp();
            $emp->setEmNo($addEmNo);
            $emp->setEmName($addEmName);
            $emp->setEmJob($addEmJob);
            $emp->setEmSal($addEmSal);
            $emp->setEmMgr($addEmMgr);
            $emp->setEmHiredate($addEmHiredateYear.'-'.$addEmiredateMonth.'-'.$addEmiredateDay);
            $emp->setDeptId($addDpId);


            if(empty($addEmName)) {
                $validationMsgs[] = "従業員名の入力は必須です。";
            }
            
            if(empty($addEmJob)) {
                $validationMsgs[] = "役職の入力は必須です。";
            }
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $empDB = $empDAO->findByEmNo($emp->getEmNo());
            if(!empty($empDB)) {
                $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $emId = $empDAO->insert($emp);
                if($emId === -1) {
                    $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
                else {
                    $isRedirect = true;
                }
            }
            else {
                $assign["emp"] = $emp;
                $assign["validationMsgs"] = $validationMsgs;
            }
        }
        if($isRedirect) {
            $response = redirect("/emp/showEmpList")->with("flashMsg", "従業員ID".$emId."で従業員情報を登録しました。");
        }
        else {
            $empDAO = new EmpDAO($db);
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $empList = $empDAO->findAll();
            $assign["empList"] = $empList;
            $assign["deptList"] = $deptList;
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    /**
     * 従業員情報編集画面表示処理。
     */
    public function prepareEmpEdit(Request $request, int $emId) {
        $templatePath = "emp.empEdit";
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $emp = $empDAO->findByPK($emId);
            if(empty($emp)) {
                $assign["errorMsg"] = "従業員情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
                $empDAO = new EmpDAO($db);
                $deptDAO = new DeptDAO($db);
                $deptList = $deptDAO->findAll();
                $empList = $empDAO->findAll();
                $assign["empList"] = $empList;
                $assign["deptList"] = $deptList;
                $assign["emp"] = $emp;
            }
        }
        return view($templatePath, $assign);
    }

    /**
     * 従業員情報編集処理。
     */
    public function empEdit(Request $request) {
        $templatePath = "emp.empEdit";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $editEmId = $request->input('editEmId');
            $editEmNo = $request->input('editEmNo');
            $editEmName = $request->input('editEmName');
            $editEmJob = $request->input("editEmJob");
            $editEmSal = $request->input("editEmSal");
            $editEmMgr = $request->input('editEmMgr');
            $editEmHiredateYear = $request->input("editEmHiredateYear");
            $editEmiredateMonth = $request->input("editEmHiredateMonth");
            $editEmiredateDay = $request->input("editEmHiredateDay");
            $editDpId = $request->input("editDpId");

            $emp = new Emp();
            $emp->setId($editEmId);
            $emp->setEmNo($editEmNo);
            $emp->setEmName($editEmName);
            $emp->setEmJob($editEmJob);
            $emp->setEmSal($editEmSal);
            $emp->setEmMgr($editEmMgr);
            $emp->setEmHiredate($editEmHiredateYear.'-'.$editEmiredateMonth.'-'.$editEmiredateDay);
            $emp->setDeptId($editDpId);


            if(empty($editEmName)) {
                $validationMsgs[] = "従業員名の入力は必須です。";
            }
            
            if(empty($editEmJob)) {
                $validationMsgs[] = "役職の入力は必須です。";
            }

            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $empDB = $empDAO->findByEmNo($emp->getEmNo());
            if(!empty($empDB) && $empDB->getId() != $editEmId) {
                $validationMsgs[] = "その従業員番号はすでに使われています。別のものを指定してください。";
            }
            if(empty($validationMsgs)) {
                $result = $empDAO->update($emp);
                if($result) {
                    $isRedirect = true;
                }
                else {
                    $assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
                    $templatePath = "error";
                }
            }
            else {
                $assign["emp"] = $emp;
                $assign["validationMsgs"] = $validationMsgs;
            }
        }
        if($isRedirect) {
            $response = redirect("/emp/showEmpList")->with("flashMsg", "従業員ID".$emp->getId()."の従業員情報を更新しました。");
        }
        else {
            $deptDAO = new DeptDAO($db);
            $deptList = $deptDAO->findAll();
            $empList = $empDAO->findAll();
            $assign["empList"] = $empList;
            $assign["deptList"] = $deptList;
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    /**
     * 従業員情報削除確認画面表示処理。
     */
    public function confirmEmpDelete(Request $request, int $emId) {
        $templatePath = "emp.empConfirmDelete";
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $emp = $empDAO->findByPK($emId);
            if(empty($emp)) {
                $assign["errorMsg"] = "従業員情報の取得に失敗しました。";
                $templatePath = "error";
            }
            else {
                $assign["emp"] = $emp;
            }
        }
        return view($templatePath, $assign);
    }

    /**
     * 従業員情報削除処理。
     */
    public function empDelete(Request $request) {
        $templatePath = "error";
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($request)) {
            $validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
            $assign["validationMsgs"] = $validationMsgs;
            $templatePath = "login";
        }
        else {
            $deleteEmpId = $request->input("deleteEmpId");
            $db = DB::connection()->getPdo();
            $empDAO = new EmpDAO($db);
            $result = $empDAO->delete($deleteEmpId);
            if($result) {
                $isRedirect = true;
            }
            else {
                $assign["errorMsg"] = "情報削除に失敗しました。もう一度はじめからやり直してください。";
            }
        }
        if($isRedirect) {
            $response = redirect("/emp/showEmpList")->with("flashMsg", "従業員ID".$deleteEmpId."の部門情報を削除しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
}