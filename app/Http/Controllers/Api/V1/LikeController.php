<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Palette;
use App\Repositories\Like\LikeRepository;
use App\Services\ApiResponse\ApiResponseFacade;
use Illuminate\Database\UniqueConstraintViolationException;

class LikeController extends Controller
{
    public function __construct(private LikeRepository $likeRepository) {}

    public function like(Palette $palette)
    {
        try {
            $this->likeRepository->like($palette);

        } catch (UniqueConstraintViolationException $e) {
            return ApiResponseFacade::withStatus(409)
                ->withMessage(__('messages.previously_added'))
                ->build()->response();
        }

        return ApiResponseFacade::build()->response();
    }

    public function unLike(Palette $palette)
    {
        if (! $palette->checkLikeExists()) {
            return ApiResponseFacade::withStatus(404)
                ->withMessage(__('messages.model_not_found'))
                ->build()->response();
        }

        $this->likeRepository->unLike($palette);

        return ApiResponseFacade::build()->response();
    }
}
