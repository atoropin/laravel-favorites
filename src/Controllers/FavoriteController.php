<?php

namespace Rir\Favorites\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FavoriteResource;
use App\Models\Traits\Favoritable;
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
    public function toggle($favoritableType, $favoritableId)
    {
        $favoritableClass = App::make($this->appModelsPath . Str::studly(Str::singular($favoritableType)));

        if (in_array(Favoritable::class, class_uses_recursive($favoritableClass), true) === true) {
            $favoritableModel = $favoritableClass->findOrFail($favoritableId);
            $favoritableModel->toggleFavorite();
        }

        return (new FavoriteResource($favoritableModel))
            ->response()
            ->setStatusCode(200);
    }
}