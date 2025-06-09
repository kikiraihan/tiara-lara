<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Repositories\InferenceRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\Object_;

class InferController extends Controller
{
    public $inferenceRepository;

    function __construct(InferenceRepository $inferenceRepository){
        $this->inferenceRepository = $inferenceRepository;
    }
    
    /**
     * Display the user's profile form.
     */
    public function infer(Request $request): Object
    {
        $data = null;
        try {
            $posts = $request->all();
            $data = $this->inferenceRepository->infer("t", [
                "d1" => 1337,
                "model" => $posts['model'],
                "fname" => $posts['fname'],
            ]);

            return self::success("Ok", $data);
        } catch (\Exception $th) {
            return self::fail($th->getMessage());
        }
    }
}
