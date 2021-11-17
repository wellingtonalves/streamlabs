<?php

namespace App\Http\Controllers\Api;

use App\Core\Twitch\Manager as Twitch;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait;

class StreamController extends Controller
{
    use ResponseTrait;

    /**
     * Get the Total amount of streams per game
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function amount()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->amountByGame()
                ->get('total_amount');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Total amount of streams per game');
        }
    }

    /**
     * Get the Highest viewer count stream per game
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function highest()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->highest()
                ->get('viewer_count');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Highest viewer count stream per game');
        }
    }

    /**
     * Get the Median amount of viewers for all streams
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function median()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->median();

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Median amount of viewers for all streams');
        }
    }

    /**
     * Get the Streams with an odd number of viewers
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function odd()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->odd()
                ->get('viewer_count');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Streams with an odd number of viewers');
        }
    }

    /**
     * Get the Streams with an even number of viewers
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function even()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->even()
                ->get('viewer_count');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Streams with an even number of viewers');
        }
    }

    /**
     * Get the List of top 100 streams that can be sorted asc & desc
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function top()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->top(100)
                ->get('viewer_count');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve List of top 100 streams that can be sorted asc & desc');
        }
    }

    /**
     * Get the Streams with the same amount of viewers
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function same()
    {
        try {
            $response = Twitch::driver($this->getTypeToDisplayInfo())
                ->streams()
                ->same()
                ->get('viewer_count');

            return response()->json($response);
        } catch (\Exception $exception) {
            return $this->errorResponse('Error on retrieve Streams with the same amount of viewers');
        }
    }
}
