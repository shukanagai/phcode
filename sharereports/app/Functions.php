<?php
namespace App;
use Illuminate\Http\Request;

class Functions {
    public static function sessionUser(Request $request) : array {
        $name = null;
        $session = $request->session();
        $name = $session->all();
        return $name;
    }
}