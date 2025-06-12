@props(['data', 'id'])

@php
    // If no ID is passed, generate a unique one.
    $chartId = $id ?? 'chart-' . str()->random(8);
@endphp

<div class="col" wire:ignore>
    <div class="">
        <div id="{{ $chartId }}"></div>
    </div>
</div>

@push('scripts')
    <script>
        // We wrap this in a self-executing function to avoid polluting the global scope.
        (function() {
            // 1. Initial Data Setup
            const initialData = {{ $data ?? 0 }};
            const chartElementId = '#{{ $chartId }}';

            // 2. Chart Options
            const chartOptions = {
                series: [initialData],
                chart: {
                    height: '100%',
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '60%'
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                show: true,
                                fontSize: '2rem',
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
                labels: ['Progress'],
                colors: ['#0d6efd'],
                stroke: {
                    lineCap: 'round'
                }
            };

            // 3. Chart Initialization
            const chart = new ApexCharts(document.querySelector(chartElementId), chartOptions);
            chart.render();

            // 4. LIVEWIRE EVENT LISTENER
            // Listen for an event dispatched from Livewire to update the chart.
            // We use window.addEventListener for compatibility with Livewire 3.
            window.addEventListener('update-chart-{{ $chartId }}', event => {
                // The event detail contains the new data.
                // Livewire 3 wraps details in an array, so we access event.detail[0]
                const newData = event.detail[0].data;

                // Use the ApexCharts API to update the series with the new data.
                chart.updateSeries([newData]);
            });

        })();
    </script>
@endpush
