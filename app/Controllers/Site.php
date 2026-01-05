<?php
namespace App\Controllers;
use App\Models\AppModel;

class Site extends BaseController {
    public function index(): string {
        $model = new AppModel();
        $data = [
            'displayResults' => $model->getDisplayResults(),
        ];
        return view('front', $data);
    }
}
