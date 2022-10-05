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
use App\Entity\Report;
use App\DAO\ReportDAO;
use App\DAO\ReportcateDAO;
use App\DAO\UserDAO;
use App\Exceptions\DataAccessException;
use App\Http\Controllers\Controller;


class ReportController extends Controller {
    /**
     * レポート画面表示処理。
     */
    public function showList(Request $request) {
        $templatePath = "report.list";
        $assign = [];
        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $userDAO = new UserDAO($db);
        $reportList = $reportDAO->findAll();
        $userList = $userDAO->findAll();
        $session = Functions::sessionUser($request);
        $assign['session'] = $session;
        $assign['reportList'] = $reportList;
        $assign['userList'] = $userList;
        return view($templatePath , $assign);
    }

    /**
     * レポート登録画面表示処理。
     */
    public function goAdd(Request $request) {
        $db = DB::connection()->getPdo();
        $templatePath = "report.add";
        $reportcate = new ReportcateDAO($db);
        $assign = [];
        $assign["report"] = new Report();
        $session = Functions::sessionUser($request);
        $assign['session'] = $session;
        $assign['reportcateList'] = $reportcate->findAll();
        return view($templatePath , $assign);
    }

    public function add(Request $request) {
        $templatePath = "report.add";
        $isRedirect = false;
        $assign = [];
        $addReYear = $request->input("addDateYear");
        $addReMonth = $request->input("addDateMonth");
        $addReDay = $request->input("addDateDay");
        $addReTimeFrom = $request->input("addTimeFrom");
        $addReTimeTo = $request->input("addTimeTo");
        $addReportcateId = $request->input("addReportcateId");
        $addReportContent = $request->input("reportContent");
                        
        $report = new Report();
        $report-> setRpDate($addReYear . '-' . $addReMonth . '-' . $addReDay);
        $report->setRpTimeFrom($addReTimeFrom);
        $report->setRpTimeTo($addReTimeTo);
        $report->setRpContent($addReportContent);
        $report->setReportCateId($addReportcateId);
        $session = Functions::sessionUser($request);
        $report->setUserId($session['id']);
        $validationMsgs = [];

        if(empty($addReportContent)) {
            $validationMsgs['reportContent'] = "作業内容の入力は必須です。";
        }

        if($addReTimeFrom > $addReTimeTo){
            $validationMsgs['timeFrom'] = "作業終了時刻よりも前に設定してください。";
            $validationMsgs['timeTo'] = "作業開始時刻よりも後に設定してください。";
        }

        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $reportcate = new ReportcateDAO($db);
        if(empty($validationMsgs)) {
            $Id = $reportDAO->insert($report);
            if($Id === -1) {
                throw new DataAccessException("情報登録に失敗しました。もう一度はじめからやり直してください。");
            }
            else {
                $isRedirect = true;
            }
        }
        else {
            $session = Functions::sessionUser($request);
            $assign['session'] = $session;
            $assign["report"] = $report;
            $assign["reportcateList"] = $reportcate->findAll();
            $assign["validationMsgs"] = $validationMsgs;
        }
        if($isRedirect) {
            $response = redirect("/report/showList")->with("flashMsg", "レポートID".$Id."でレポート情報を登録しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    public function showDetail(Request $request, int $reId) {
        $templatePath = "report.detail";
        $assign = [];
        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $userDAO = new UserDAO($db);
        $reportcateDAO = new ReportcateDAO($db);
        $report = $reportDAO->findByPK($reId);
        $userId = $report->getUserId();
        $user = $userDAO->findByLoginId($userId);
        $reportcate = $reportcateDAO->findAll();
        if(empty($report)) {
            throw new DataAccessException("レポート情報の取得に失敗しました。");
        }
        else {
            $session = Functions::sessionUser($request);
            $assign['session'] = $session;
            $assign["report"] = $report;
            $assign["user"] = $user;
            $assign["reportcate"] = $reportcate;
        }
        return view($templatePath , $assign);
    }

    public function prepareEdit(Request $request, int $reId){
        $templatePath = "report.edit";
        $assign = [];
        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $reportcate = new ReportcateDAO($db);
        $session = Functions::sessionUser($request);
        $assign['session'] = $session;
        $assign['report'] = $reportDAO->findByPK($reId);
        $assign['reportcateList'] = $reportcate->findAll();
        return view($templatePath , $assign);
    }


    public function edit(Request $request) {
        $templatePath = "report.edit";
        $isRedirect = false;
        $assign = [];
        $editId = $request->input("editId");
        $editReYear = $request->input("editDateYear");
        $editReMonth = $request->input("editDateMonth");
        $editReDay = $request->input("editDateDay");
        $editReTimeFrom = $request->input("editTimeFrom");
        $editReTimeTo = $request->input("editTimeTo");
        $editReportcateId = $request->input("editReportcateId");
        $editReportContent = $request->input("reportContent");
                        
        $report = new Report();
        $report->setId($editId);
        $report-> setRpDate($editReYear . '-' . $editReMonth . '-' . $editReDay);
        $report->setRpTimeFrom($editReTimeFrom);
        $report->setRpTimeTo($editReTimeTo);
        $report->setRpContent($editReportContent);
        
        $report->setReportCateId($editReportcateId);
        $session = Functions::sessionUser($request);
        $report->setUserId($session['id']);
        $validationMsgs = [];

        if(empty($editReportContent)) {
            $validationMsgs['reportContent'] = "作業内容の入力は必須です。";
        }

        if($editReTimeFrom > $editReTimeTo){
            $validationMsgs['timeFrom'] = "作業終了時刻よりも前に設定してください。";
            $validationMsgs['timeTo'] = "作業開始時刻よりも後に設定してください。";
        }

        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $reportcate = new ReportcateDAO($db);
        if(empty($validationMsgs)) {
            $result = $reportDAO->update($report);
            if($result) {
                $isRedirect = true;
            }
            else {
                throw new DataAccessException("情報更新に失敗しました。もう一度はじめからやり直してください。");
            }
        }
        else {
            $session = Functions::sessionUser($request);
            $assign['session'] = $session;
            $assign["report"] = $report;
            $assign["reportcateList"] = $reportcate->findAll();
            $assign["validationMsgs"] = $validationMsgs;
        }
        if($isRedirect) {
            $response = redirect("/report/showDetail/".$report->getId())->with("flashMsg", "レポートID".$report->getId()."でレポート情報を変更しました。");
        }
        else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }

    public function confirmDelete(Request $request, int $reId){
        $templatePath = "report.delete";
        $assign = [];
        $db = DB::connection()->getPdo();
        $reportDAO = new ReportDAO($db);
        $userDAO = new UserDAO($db);
        $reportcateDAO = new ReportcateDAO($db);
        $report = $reportDAO->findByPK($reId);
        $userId = $report->getUserId();
        $user = $userDAO->findByLoginId($userId);
        $reportcate = $reportcateDAO->findAll();
        if(empty($report)) {
            throw new DataAccessException("レポート情報の取得に失敗しました。");
        }
        else {
            $session = Functions::sessionUser($request);
            $assign['session'] = $session;
            $assign["report"] = $report;
            $assign["user"] = $user;
            $assign["reportcate"] = $reportcate;
        }
        return view($templatePath , $assign);
    }

    /**
     * 部門情報削除処理。
     */
    public function delete(Request $request) {
        $deleteId = $request->input("deletId");
        $db = DB::connection()->getPdo();
        $deptDAO = new reportDAO($db);
        $result = $deptDAO->delete($deleteId);
        if(!$result) {
            throw new DataAccessException("情報削除に失敗しました。もう一度はじめからやり直してください。");
        }
        $response = redirect("/report/showList")->with("flashMsg", "レポートID".$deleteId ."のレポート情報を削除しました。");
        return $response;
    }
}