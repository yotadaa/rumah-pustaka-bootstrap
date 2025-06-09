<?php

namespace App\Livewire;

use Livewire\Component;

class CircleChart extends Component
{
    /**
     * The value to be displayed on the chart (e.g., 90 for 90%).
     * @var int
     */
    public int $percentage = 90;

    /**
     * A method to demonstrate updating the chart dynamically.
     * It picks a new random percentage.
     */
    public function randomizePercentage(): void
    {
        // Set a new random percentage between 10 and 100.
        $this->percentage = rand(10, 100);

        // Dispatch a browser event to notify the front-end chart.
        // We pass the new percentage as a parameter.
        $this->dispatch('updateChart', percentage: $this->percentage);
    }

    /**
     * Render the component's view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.circle-chart');
    }
}
