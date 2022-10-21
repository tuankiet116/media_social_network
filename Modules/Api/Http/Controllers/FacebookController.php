<?php

namespace Modules\Api\Http\Controllers;

use App\Services\User\UserAuthenticationService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class FacebookController extends Controller
{
    private $userAuthenticationService;

    public function __construct(UserAuthenticationService $userAuthenticationService)
    {
        $this->userAuthenticationService = $userAuthenticationService;
    }

    public function fbLogin(Request $request) {
        $this->userAuthenticationService->facebookLogin($request);
    }
}
