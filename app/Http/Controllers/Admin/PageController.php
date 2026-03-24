<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home() { return view('admin.pages.home'); }
    public function shop() { return view('admin.pages.shop'); }
    public function product() { return view('admin.pages.product'); }
    public function vendor() { return view('admin.pages.vendor'); }
    public function seller() { return view('admin.pages.seller'); }
    public function blog() { return view('admin.pages.blog'); }
    public function contact() { return view('admin.pages.contact'); }
    public function cart() { return view('admin.pages.cart'); }
    public function checkout() { return view('admin.pages.checkout'); }
    public function auth() { return view('admin.pages.auth'); }
}
