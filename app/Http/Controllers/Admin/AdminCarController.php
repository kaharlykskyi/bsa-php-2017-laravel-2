<?php

namespace App\Http\Controllers\Admin;

use App\Car,
    Illuminate\Http\Request,
    App\Http\Controllers\CarController,
    App\Repositories\Exceptions\NotFoundException,
    \Illuminate\Http\JsonResponse;

class AdminCarController extends CarController
{
    /**
     * Method returns all cars data in json format
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        return $this->getCars();
    }

    /**
     * Method returns data about one car with $id
     * @param $id
     * @return JsonResponse
     */
    public function show($id) : JsonResponse
    {
        return $this->getOneCar($id);
    }

    /**
     * Add car
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $car = new Car($data);
        $this->car->addItem($car);
        return $this->getOneCar($car->getId());
    }

    /**
     * Delete one car with $id
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy($id)
    {
        $this->car->delete($id);
        return response("", 200);
    }

    /**
     * Update info about car with $id
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id) : JsonResponse
    {
        $data = $request->all();
        $CarControllerObj = $this->car->getById($id);
        if ($CarControllerObj) {
            $car = $CarControllerObj->toArray();
        } else {
            $car = abort(404);
        }
        foreach ($data as $key => $val) {
            $car[$key] = $val;
        }

        $car = new Car($car);
         try {
              $this->car->update($car);
         } catch(NotFoundException $e) {
            abort(404, "Update error: {$e->getMessage()}");
         }
         return $this->getOneCar($car->getId());
     }

}