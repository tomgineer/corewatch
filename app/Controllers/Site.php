<?php
namespace App\Controllers;
use App\Models\AppModel;

class Site extends BaseController {
    public function index(): string {
        $model = new AppModel();
        $data = [
            'apiResults' => $model->fetchApis(),
        ];
        return view('front', $data);
    }
}
