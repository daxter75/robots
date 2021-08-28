<?php

namespace App\Http\Controllers;

use App\Http\Resources\DanceoffResource;
use App\Models\Danceoff;
use App\Models\Robot;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\throwException;

class DanceoffController extends Controller
{
    private $robots;

    public function __construct()
    {
        $this->robots = Robot::all()->toArray();
    }

    public function index()
    {
        return DanceoffResource::collection(Danceoff::orderBy('id', 'DESC')->get());
    }

    public function store()
    {
        $canSave = false;
        $danceoffs = $this->validateStart();

        foreach ($danceoffs as $danceoff) {
            $res = [];
            foreach ($danceoff as $data) {

                // check dancers in database
                $winner = $this->searchForRobot($data['winner']) ? $data['winner'] : '';
                $opponent1 = $this->searchForRobot($data['opponents'][0]) ? $data['opponents'][0] : '';
                $opponent2 = $this->searchForRobot($data['opponents'][1]) ? $data['opponents'][1] : '';

                // define winner and loser, return error if winner ID not in opponents ID
                if ($winner == $opponent1) {
                    $loser = $opponent2;
                    $canSave = true;
                } else if ($winner == $opponent2) {
                    $loser = $opponent1;
                    $canSave = true;
                } else {
                    array_push($res, [
                        'statusCode' => Response::HTTP_NOT_ACCEPTABLE,
                        'error' => 'Not acceptable',
                        'message' => 'Winner not in opponents',
                    ]);
                }

                // save in database
                if ($canSave) {
                    $dance = Danceoff::create([
                        'winner' => $winner,
                        'loser' => $loser,
                    ]);
                    // prepare answer
                    array_push($res, (new DanceoffResource($dance)));
                }
            }
        }
        return $res;
    }

    public function populated()
    {
        $danceoffs = Danceoff::all()->toArray();
        $res = [];
        foreach ($danceoffs as $danceoff) {
            array_push($res,  [
                'id' => $danceoff['id'],
                'dancedAt' => $danceoff['created_at'],
                'winner' => $this->searchForRobot($danceoff['winner']),
                'loser' => $this->searchForRobot($danceoff['loser']),
            ]);
        }
        return array_reverse($res);
    }

    private function searchForRobot($id)
    {
        foreach ($this->robots as $robot) {
            if ($robot['id'] === $id) {
                return [
                    'id' => $robot['id'],
                    'name' => $robot['name'],
                    'powermove' => $robot['powermove'],
                    'experience' => $robot['experience'],
                    'outOfOrder' => (bool)$robot['outOfOrder'],
                    'avatar' => $robot['avatar'],
                ];
            }
        }
        return null;
    }

    private function validateStart() {
        return \request()->validate([
            'danceoffs' => 'required|array',
        ]);
    }
}
