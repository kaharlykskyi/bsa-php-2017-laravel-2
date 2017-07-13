<?php

namespace App\Http\Controllers;

use App\Repositories\CarRepository,
    App\Car,
    Illuminate\Http\JsonResponse;

class CarController extends Controller
{
    protected $car;

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
        $car = $this->car->getAll();
        return response()->json($car->map(function (Car $car) {
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

    public function getOneCar($id) : JsonResponse
    {
        $car = $this->car->getById($id);
        if ($car === null) return abort(404, "Car with id({$id}) not found!");
        return response()->json(
                [
                    'id' => $car->getId(),
                    'model' => $car->getModel(),
                    'year' => $car->getYear(),
                    'mileage' => $car->getMileage(),
                    'registration_number' => $car->getRegistrationNumber(),
                    'color' => $car->getColor(),
                    'price' => $car->getPrice(),
                ]
        );
    }
}