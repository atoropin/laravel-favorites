<?php

namespace Smartopolis\Favorites\Controllers;

use App\Http\Controllers\Controller;
use Smartopolis\Favorites\Traits\Favoritable;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    protected string $appModelsPath = '';

    public function __construct()
    {
        $this->middleware('auth:api');

        $this->appModelsPath = config('favorites.app_models_path') ?? 'App\\Models\\';
    }

    /**
     * @param $favoritableType
     * @param $favoritableId
     *
     * @return JsonResponse
     */
    public function toggle($favoritableType, $favoritableId): JsonResponse
    {
        $favoritableClass = App::make($this->appModelsPath . Str::studly(Str::singular($favoritableType)));

        if (in_array(Favoritable::class, class_uses_recursive($favoritableClass), true) === true) {
            $favoritableModel = $favoritableClass->findOrFail($favoritableId);
            $favoritableModel->toggleFavorite();
        }

        return (new JsonResource(['favorited'=> $favoritableModel->favorited]))
            ->response()
            ->setStatusCode(200);
    }
}
