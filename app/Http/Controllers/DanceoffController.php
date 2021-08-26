<?php

namespace App\Http\Controllers;

use App\Http\Resources\DanceoffResource;
use App\Models\Danceoff;
use App\Models\Robot;
use Illuminate\Http\Request;

class DanceoffController extends Controller
{
    public function index()
    {
        return DanceoffResource::collection(Danceoff::orderBy('id', 'DESC')->get());
    }

    public function populated()
    {
        $robots = Robot::all()->toArray();
        $danceoffs = Danceoff::all()->toArray();
        $res = [];
        foreach ($danceoffs as $danceoff) {
            array_push($res,  [
                'id' => $danceoff['id'],
                'dancedAt' => $danceoff['created_at'],
                'winner' => $this->searchForRobot($danceoff['winner'], $robots),
                'loser' => $this->searchForRobot($danceoff['loser'], $robots),
            ]);
        }
        return array_reverse($res);
    }

    private function searchForRobot($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] === $id) {
                return [
                    'id' => $val['id'],
                    'name' => $val['name'],
                    'powermove' => $val['powermove'],
                    'experience' => $val['experience'],
                    'outOfOrder' => (bool)$val['outOfOrder'],
                    'avatar' => $val['avatar'],
                ];
            }
        }
        return null;
    }
}
