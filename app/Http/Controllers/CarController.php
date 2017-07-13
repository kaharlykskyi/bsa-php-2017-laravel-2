<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository,
    App\Car,
    Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    private $car;

    public function __construct(CarRepository $carRepository)
    {
        $this->car = $carRepository;
    }

    /**
     * Method return all cars data in json format
     * @return JsonResponse
     */
    public function getCars() : JsonResponse
    {
        return response()->json($this->car->getAll()->map(function (Car $car) {
                return [
                    'id' => $car->getId(),
                    'model' => $car->getModel(),
                    'year' => $car->getYear(),
                    'color' => $car->getColor(),
                    'price' => $car->getPrice(),
                ];
            })
        );
    }
}