<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardTable extends Component
{
    public string $title;
    public array $headers;

    public function __construct(string $title, array $headers = [])
    {
        $this->title = $title;
        $this->headers = $headers;
    }

    public function render()
    {
        return view('components.dashboard-table');
    }
}
