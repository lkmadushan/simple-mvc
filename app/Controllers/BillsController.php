<?php

namespace App\Controllers;

use App\Bill;
use App\Core\Request;
use Exception;

class BillsController
{
    public function index()
    {
        if (Request::is('GET')) {
            return view('index');
        }

        $content = json_decode(Request::get('bill'), true);

        if (json_last_error() == JSON_ERROR_SYNTAX) {
            return view('index', [
                'errors' => 'Invalid json string.'
            ]);
        }

        try {
            $bill = new Bill($content['data']);

            return view('index', compact('bill'));
        } catch (Exception $e) {
            return view('index', [
                'errors' => $e->getMessage()
            ]);
        }
    }
}