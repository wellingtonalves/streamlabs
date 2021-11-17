<?php

namespace App\Jobs;

use App\Core\Support\Helpers;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use romanzipp\Twitch\Twitch;

class StreamsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $max;
    private $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($max = 1000, $type = 'update')
    {
        $this->max = $max;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $total = 0;
        try {
            $twitch = new Twitch();
            do {
                $nextCursor = null;

                if (isset($result)) {
                    $nextCursor = $result->next();
                }

                $result = $twitch->getStreams(['first' => 100], $nextCursor);
                $data = $result->data();

                if ($this->type == 'create') {
                    Helpers::randomizeArray($data);
                }

                foreach ($data as $stream) {
                    if ($total < $this->max) {
                        if ($this->type == 'create') {
                            $this->create($stream);
                        } else {
                            $this->update($stream);
                        }
                        $total++;
                    }
                }

            } while ($total < $this->max);
            if ($this->type == 'update') {
                event(new \App\Events\StreamsUpdate());
            }
            Cache::flush();
        } catch (\Exception $exception) {
            Log::info('Twitch error', [$exception]);
        }
    }

    /**
     * Create stream
     * @param $stream
     */
    private function create($stream)
    {
        try {
            DB::table('streams')->insert($this->transform($stream));
        } catch (\Exception $exception) {
            Log::info('Twitch error', [$exception]);
        }
    }

    /**
     * Update stream
     * @param $stream
     */
    private function update($stream)
    {
        try {
            $data = $this->transform($stream);
            unset($data['id']);
            DB::table('streams')->where('id', $stream->id)->update($this->transform($stream));

        } catch (\Exception $exception) {
            Log::info('Twitch error', [$exception]);
        }
    }

    /**
     * Transform stream
     * @param $stream
     * @return array
     */
    private function transform($stream): array
    {
        return [
            'id' => $stream->id,
            'user_id' => $stream->user_id,
            'user_login' => $stream->user_login,
            'user_name' => $stream->user_name,
            'game_id' => intval($stream->game_id) ?? null,
            'game_name' => $stream->game_name,
            'type' => $stream->type,
            'title' => $stream->title,
            'viewer_count' => $stream->viewer_count,
            'started_at' => Carbon::createFromTimeString($stream->started_at)->format('Y-m-d H:i:s'),
            'language' => $stream->language,
            'thumbnail_url' => $stream->thumbnail_url,
            'is_mature' => $stream->is_mature,
        ];
    }
}
