@props(['data'])

<div class="d-flex flex-column align-items-center" wire:ignore>

    <div class="">
        <div id="circle-chart-container"></div>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            // Use the data passed from the component props, or a default value.
            const chartData = {{ $data ?? 0 }};

            const chartOptions = {
                series: [chartData],
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
        })();
    </script>
@endpush
