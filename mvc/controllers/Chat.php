<?php

class chat extends ControllerBase
{
    public function send($queries)
    {
        $bot = $this->model("botModel");
        $bot->getReplies($queries);
    }
}
