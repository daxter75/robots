<?php

namespace App\Http\Controllers;

use App\Http\Resources\DanceoffResource;
use App\Http\Resources\RobotResource;
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
        $this->robots = Robot::all();
    }

    public function index()
    {
        return DanceoffResource::collection(Danceoff::orderBy('id', 'DESC')->limit(100)->get());
    }

    public function store()
    {
        $danceoffs = $this->validateStart();

        foreach ($danceoffs as $danceoff) {
            $res = [];
            foreach ($danceoff as $data) {
                $canSave = false;

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
        $danceoffs = Danceoff::limit(100)->get()->toArray();
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

    public function leaderboard()
    {
        $res = [];
        $wins = Danceoff::select(Danceoff::raw("count('winner') as wins"), 'winner')
            ->groupBy('winner')
            ->orderBy('wins', 'desc')
            ->get()
            ->toArray();

        foreach ($wins as $win) {
            array_push($res,  [
                'wins' => $win['wins'],
                'winner' => $this->searchForRobot($win['winner']),
            ]);
        }
        return $res;
    }

    private function searchForRobot(int $id)
    {
        foreach ($this->robots as $robot) {
            if ($robot['id'] === $id) {
                return new RobotResource($robot);
            }
        }
        return null;
    }

    private function validateStart() {
        return \request()->validate([
            'danceoffs' => 'required',
        ]);
    }
}
