<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DashboardCard extends Component
{
    public string $title;
    public string $value;
    public ?string $subtitle;

    public function __construct(string $title, string $value, string $subtitle = null)
    {
        $this->title = $title;
        $this->value = $value;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('components.dashboard-card');
    }
}
