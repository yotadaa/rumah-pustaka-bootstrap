{{--
    This component uses Bootstrap for styling and ApexCharts for the visualization.
    Make sure you have Bootstrap and ApexCharts.js included in your main layout file.
    You can add ApexCharts via CDN:
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
--}}
<div class="d-flex flex-column align-items-center">

    <!-- Chart container -->
    <div class="bg-light p-3 rounded-3 shadow-sm">
        <!-- The chart will be rendered inside this div -->
        <div id="circle-chart-container"></div>
    </div>


    <!-- Button to trigger the update -->
    <div class="mt-4">
        <button wire:click="randomizePercentage" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shuffle"
                viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M0 3.5A.5.5 0 0 1 .5 3H1c2.202 0 3.827 1.24 4.874 2.418.49.552.865 1.102 1.126 1.532.26-.43.636-.98 1.126-1.532C9.173 4.24 10.798 3 13 3h.5a.5.5 0 0 1 0 1H13c-1.798 0-3.173 1.01-4.126 2.082A9.624 9.624 0 0 0 7.556 8a9.624 9.624 0 0 0 1.317 1.918C9.828 10.99 11.204 12 13 12h.5a.5.5 0 0 1 0 1H13c-2.202 0-3.827-1.24-4.874-2.418A10.595 10.595 0 0 1 7 9.05c-.26.43-.636.98-1.126 1.532C4.827 11.76 3.202 13 1 13H.5a.5.5 0 0 1 0-1H1c1.798 0 3.173-1.01 4.126-2.082A9.624 9.624 0 0 0 6.444 8a9.624 9.624 0 0 0-1.317-1.918C4.172 5.01 2.796 4 1 4H.5a.5.5 0 0 1-.5-.5z" />
                <path
                    d="M13 5.466V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192zm0 9v-3.932a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192z" />
            </svg>
            Randomize Data
        </button>
    </div>
    <script>
        (function() {
            const chartOptions = {
                series: [@json($percentage)],
                chart: {
                    height: 280,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '75%'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: '2.5rem',
                                fontWeight: 'bold',
                                color: '#333',
                                offsetY: 10,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        }
                    }
                },
                // Labels for the chart series.
                labels: ['Progress'],
                // Colors for the progress bar
                colors: ['#0d6efd'], // Using a Bootstrap primary blue
                stroke: {
                    lineCap: 'round' // Makes the ends of the progress bar rounded
                }
            };

            // Create the chart instance
            const chart = new ApexCharts(document.querySelector("#circle-chart-container"), chartOptions);
            // Render the initial chart
            chart.render();


            // 2. LIVEWIRE EVENT LISTENER
            // --------------------------
            // This is the bridge between Livewire and our JavaScript chart.
            // We listen for the 'updateChart' event dispatched from our PHP component.
            Livewire.on('updateChart', (event) => {
                if (chart) {
                    // ApexCharts provides a method to update the series data dynamically.
                    chart.updateSeries([event.percentage]);
                }
            });
        })();
    </script>
</div>

@push('scripts')
    <script>
        (function() {
            const chartOptions = {
                series: [@json($percentage)],
                chart: {
                    height: 280,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '75%'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: '2.5rem',
                                fontWeight: 'bold',
                                color: '#333',
                                offsetY: 10,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            }
                        }
                    }
                },
                // Labels for the chart series.
                labels: ['Progress'],
                // Colors for the progress bar
                colors: ['#0d6efd'], // Using a Bootstrap primary blue
                stroke: {
                    lineCap: 'round' // Makes the ends of the progress bar rounded
                }
            };

            // Create the chart instance
            const chart = new ApexCharts(document.querySelector("#circle-chart-container"), chartOptions);
            // Render the initial chart
            chart.render();


            // 2. LIVEWIRE EVENT LISTENER
            // --------------------------
            // This is the bridge between Livewire and our JavaScript chart.
            // We listen for the 'updateChart' event dispatched from our PHP component.
            Livewire.on('updateChart', (event) => {
                if (chart) {
                    // ApexCharts provides a method to update the series data dynamically.
                    chart.updateSeries([event.percentage]);
                }
            });
        })();
    </script>
@endpush
